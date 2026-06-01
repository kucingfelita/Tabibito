<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Http\Requests\OwnerDestinationRequest;
use App\Models\Destination;
use App\Models\DestinationImage;
use App\Models\Tag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class DestinationController extends Controller
{
    public function index(): View
    {
        $destinations = Destination::query()
            ->where('user_id', auth()->id())
            ->with(['coverImage', 'slideImages', 'tags'])
            ->latest()
            ->paginate(10);

        $cities = \App\Http\Requests\OwnerDestinationRequest::jawaTengahCities();
        $tags = Tag::all();

        return view('owner.destinations.index', compact('destinations', 'cities', 'tags'));
    }

    public function store(OwnerDestinationRequest $request): RedirectResponse
    {
        try {
            if (Destination::query()->where('user_id', auth()->id())->exists()) {
                return back()->with('error', 'Hanya satu destinasi yang diizinkan untuk setiap owner.');
            }

            $destination = Destination::query()->create([
                'user_id' => auth()->id(),
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'address' => $request->input('address'),
                'city' => $request->input('city'),
                'map_link' => $request->input('map_link'),
                'open_time' => $request->input('open_time'),
                'close_time' => $request->input('close_time'),
                'status' => 'pending',
            ]);

            $this->syncTags($destination, $request);

            if ($request->hasFile('cover_image')) {
                $path = $this->compressAndStoreImage($request->file('cover_image'));
                DestinationImage::query()->create([
                    'destination_id' => $destination->id,
                    'image_path'     => $path,
                    'is_cover'       => true,
                ]);
            }

            if ($request->hasFile('slide_images')) {
                $slides = array_slice($request->file('slide_images'), 0, 7);
                foreach ($slides as $image) {
                    $path = $this->compressAndStoreImage($image);
                    DestinationImage::query()->create([
                        'destination_id' => $destination->id,
                        'image_path'     => $path,
                        'is_cover'       => false,
                    ]);
                }
            }

            return back()->with('success', 'Destinasi berhasil ditambahkan dan menunggu verifikasi admin.');
        } catch (\Throwable $e) {
            return back()->withInput()->withErrors(['error' => 'Gagal tambah: ' . $e->getMessage()]);
        }
    }

    public function update(OwnerDestinationRequest $request, Destination $destination): RedirectResponse
    {
        try {
            abort_unless((int) $destination->user_id === (int) auth()->id(), 403);

            $wasActive = $destination->status === 'active';
            $wasRejected = $destination->status === 'rejected';

            $updateData = [
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'address' => $request->input('address'),
                'city' => $request->input('city'),
                'map_link' => $request->input('map_link'),
                'open_time' => $request->input('open_time'),
                'close_time' => $request->input('close_time'),
            ];

            if (! $wasActive) {
                $updateData['status'] = 'pending';
                $updateData['rejection_reason'] = null;
            }

            $destination->update($updateData);

            $this->syncTags($destination, $request);

            if ($request->hasFile('cover_image')) {
                $path = $this->compressAndStoreImage($request->file('cover_image'));
                // Replace existing cover or create new
                $existingCover = $destination->images()->where('is_cover', true)->first();
                if ($existingCover) {
                    Storage::disk('public')->delete($existingCover->image_path);
                    $existingCover->update(['image_path' => $path]);
                } else {
                    DestinationImage::query()->create([
                        'destination_id' => $destination->id,
                        'image_path'     => $path,
                        'is_cover'       => true,
                    ]);
                }
            }

            if ($request->hasFile('slide_images')) {
                // Count existing slides and cap total at 7
                $existingSlideCount = $destination->images()->where('is_cover', false)->count();
                $allowedNew = max(0, 7 - $existingSlideCount);
                $slides = array_slice($request->file('slide_images'), 0, $allowedNew);
                foreach ($slides as $image) {
                    $path = $this->compressAndStoreImage($image);
                    DestinationImage::query()->create([
                        'destination_id' => $destination->id,
                        'image_path'     => $path,
                        'is_cover'       => false,
                    ]);
                }
            }

            $message = match (true) {
                $wasActive => 'Destinasi berhasil diperbarui dan tetap aktif di katalog.',
                $wasRejected => 'Pengajuan ulang berhasil dikirim. Menunggu verifikasi admin.',
                default => 'Destinasi berhasil diperbarui dan menunggu verifikasi admin.',
            };

            return back()->with('success', $message);
        } catch (\Throwable $e) {
            return back()->withInput()->withErrors(['error' => 'Gagal simpan: ' . $e->getMessage()]);
        }
    }

    private function syncTags(Destination $destination, OwnerDestinationRequest $request): void
    {
        $tagIds = $request->input('tag_ids', []);

        if ($request->filled('custom_tags')) {
            $customTags = collect(explode(',', $request->custom_tags))
                ->map(fn($tag) => trim($tag))
                ->filter()
                ->unique();

            foreach ($customTags as $tagName) {
                $tag = Tag::firstOrCreate(['name' => $tagName]);
                $tagIds[] = $tag->id;
            }
        }

        $destination->tags()->sync(array_unique($tagIds));
    }

    public function destroy(Destination $destination): RedirectResponse
    {
        abort_unless((int) $destination->user_id === (int) auth()->id(), 403);
        $destination->delete();

        return back()->with('success', 'Destinasi berhasil dihapus.');
    }

    public function toggleMaintenance(Destination $destination): RedirectResponse
    {
        abort_unless((int) $destination->user_id === (int) auth()->id(), 403);

        if ($destination->status === 'active') {
            $destination->update(['status' => 'maintenance']);

            return back()->with('success', 'Destinasi dimatikan sementara (mode perawatan). Tidak bisa dipesan traveler.');
        }

        if ($destination->status === 'maintenance') {
            $destination->update(['status' => 'active']);

            return back()->with('success', 'Destinasi kembali dibuka untuk pemesanan.');
        }

        return back()->withErrors(['error' => 'Mode perawatan hanya untuk destinasi yang sudah aktif.']);
    }

    private function compressAndStoreImage(UploadedFile $file): string
    {
        $targetPath = 'destinations/' . uniqid('img_', true) . '.jpg';

        try {
            if (!class_exists(ImageManager::class) || !class_exists(Driver::class)) {
                throw new \Exception('Intervention Image classes missing');
            }

            $manager = new ImageManager(new Driver());
            $image = $manager->read($file->getRealPath())->scaleDown(width: 1600);
            $encoded = $image->toJpeg(75);
            
            Storage::disk('public')->put($targetPath, $encoded->toStream());

            return $targetPath;
        } catch (\Throwable $e) {
            // Fallback to standard upload
            return $file->store('destinations', 'public');
        }
    }
}
