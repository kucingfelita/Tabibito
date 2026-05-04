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
            ->with(['images', 'tags'])
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

            if ($request->hasFile('image')) {
                $path = $this->compressAndStoreImage($request->file('image'));
                DestinationImage::query()->create([
                    'destination_id' => $destination->id,
                    'image_path' => $path,
                ]);
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

            $destination->update([
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

            if ($request->hasFile('image')) {
                $path = $this->compressAndStoreImage($request->file('image'));
                DestinationImage::query()->create([
                    'destination_id' => $destination->id,
                    'image_path' => $path,
                ]);
            }

            return back()->with('success', 'Destinasi berhasil diperbarui.');
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
