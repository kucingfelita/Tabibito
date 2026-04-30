<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Http\Requests\OwnerDestinationRequest;
use App\Models\Destination;
use App\Models\DestinationImage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class DestinationController extends Controller
{
    public function index(): View
    {
        $destinations = Destination::query()
            ->where('user_id', auth()->id())
            ->with('images')
            ->latest()
            ->paginate(10);

        return view('owner.destinations.index', compact('destinations'));
    }

    public function store(OwnerDestinationRequest $request): RedirectResponse
    {
        $destination = Destination::query()->create([
            'user_id' => auth()->id(),
            'name' => $request->string('name')->toString(),
            'description' => $request->string('description')->toString(),
            'address' => $request->string('address')->toString(),
            'city' => $request->string('city')->toString(),
            'map_link' => $request->input('map_link'),
            'open_time' => $request->string('open_time')->toString(),
            'close_time' => $request->string('close_time')->toString(),
            'status' => 'pending',
        ]);

        if ($request->hasFile('image')) {
            $path = $this->compressAndStoreImage($request->file('image')->getPathname());
            DestinationImage::query()->create([
                'destination_id' => $destination->id,
                'image_path' => $path,
            ]);
        }

        return back()->with('success', 'Destinasi berhasil ditambahkan dan menunggu verifikasi admin.');
    }

    public function update(OwnerDestinationRequest $request, Destination $destination): RedirectResponse
    {
        abort_unless((int) $destination->user_id === (int) auth()->id(), 403);

        $destination->update([
            'name' => $request->string('name')->toString(),
            'description' => $request->string('description')->toString(),
            'address' => $request->string('address')->toString(),
            'city' => $request->string('city')->toString(),
            'map_link' => $request->input('map_link'),
            'open_time' => $request->string('open_time')->toString(),
            'close_time' => $request->string('close_time')->toString(),
            'status' => 'pending',
        ]);

        if ($request->hasFile('image')) {
            $path = $this->compressAndStoreImage($request->file('image')->getPathname());
            DestinationImage::query()->create([
                'destination_id' => $destination->id,
                'image_path' => $path,
            ]);
        }

        return back()->with('success', 'Destinasi berhasil diperbarui.');
    }

    public function destroy(Destination $destination): RedirectResponse
    {
        abort_unless((int) $destination->user_id === (int) auth()->id(), 403);
        $destination->delete();

        return back()->with('success', 'Destinasi berhasil dihapus.');
    }

    private function compressAndStoreImage(string $sourcePath): string
    {
        $manager = new ImageManager(new Driver());
        $image = $manager->read($sourcePath)->scaleDown(width: 1600);
        $encoded = $image->toJpeg(75);
        $targetPath = 'destinations/'.uniqid('img_', true).'.jpg';
        Storage::disk('public')->put($targetPath, (string) $encoded);

        return $targetPath;
    }
}
