<?php

namespace App\Http\Controllers\Traveler;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Services\TransactionPaymentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class HistoryController extends Controller
{
    public function index(TransactionPaymentService $paymentService): View
    {
        $paymentService->expireOverduePendingPayments();

        Transaction::query()
            ->where('user_id', auth()->id())
            ->where('status', 'pending')
            ->each(fn (Transaction $t) => $t->refreshPaymentExpiresAt());

        $transactions = Transaction::query()
            ->where('user_id', auth()->id())
            ->with(['ticket.destination.coverImage', 'ticket.destination.images'])
            ->latest()
            ->paginate(10);

        return view('traveler.history', compact('transactions'));
    }

    public function submitRating(\Illuminate\Http\Request $request, Transaction $transaction): RedirectResponse
    {
        if ($transaction->user_id !== auth()->id() || $transaction->status !== 'used') {
            abort(403);
        }

        if ($transaction->rating !== null) {
            return back()->with('error', 'Anda sudah memberikan penilaian untuk tiket ini.');
        }

        $validationRules = [
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'review_comment' => ['nullable', 'string', 'max:1000'],
        ];

        if (extension_loaded('fileinfo')) {
            $validationRules['review_image'] = ['nullable', 'file', 'mimes:jpg,jpeg,png,webp', 'max:5120'];
        } else {
            $validationRules['review_image'] = ['nullable', 'file', 'max:5120'];
        }

        try {
            $request->validate($validationRules);

            if ($request->hasFile('review_image') && !extension_loaded('fileinfo')) {
                $file = $request->file('review_image');
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
                $ext = strtolower($file->getClientOriginalExtension());
                if (!in_array($ext, $allowedExtensions)) {
                    return back()->withErrors(['review_image' => 'Format file gambar harus berupa: jpg, jpeg, png, webp.'])->withInput();
                }
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Throwable $e) {
            return back()->with('error', 'Gagal memvalidasi file: ' . $e->getMessage());
        }

        try {
            $updateData = [
                'rating' => $request->integer('rating'),
                'review_comment' => $request->input('review_comment'),
            ];

            if ($request->hasFile('review_image')) {
                $file = $request->file('review_image');
                if ($file->isValid()) {
                    $updateData['review_image'] = $this->compressAndStoreReviewImage($file);
                } else {
                    return back()->with('error', 'File gambar yang diunggah tidak valid atau rusak.');
                }
            }

            $transaction->update($updateData);

            return back()->with('success', 'Terima kasih atas penilaian dan ulasan Anda!');
        } catch (\Throwable $e) {
            \Log::error('Error submit rating: ' . $e->getMessage());

            return back()->with('error', 'Gagal menyimpan ulasan: ' . $e->getMessage());
        }
    }

    private function compressAndStoreReviewImage(\Illuminate\Http\UploadedFile $file): string
    {
        $ext = strtolower($file->getClientOriginalExtension());
        if (!in_array($ext, ['jpg', 'jpeg', 'png', 'webp'])) {
            $ext = 'jpg';
        }
        $targetPath = 'reviews/' . uniqid('rev_', true) . '.' . $ext;

        try {
            if (extension_loaded('fileinfo') && class_exists(\Intervention\Image\ImageManager::class) && class_exists(\Intervention\Image\Drivers\Gd\Driver::class)) {
                $manager = new \Intervention\Image\ImageManager(new \Intervention\Image\Drivers\Gd\Driver());
                $image = $manager->read($file->getRealPath())->scaleDown(width: 1200);
                $encoded = $image->toJpeg(75);

                \Storage::disk('public')->put($targetPath, $encoded->toStream());

                return $targetPath;
            }
        } catch (\Throwable $e) {
            \Log::warning('Review image compression failed: ' . $e->getMessage());
        }

        try {
            \Storage::disk('public')->put($targetPath, fopen($file->getRealPath(), 'r'));

            return $targetPath;
        } catch (\Throwable $e) {
            return $file->store('reviews', 'public');
        }
    }

    public function cancel(Transaction $transaction, TransactionPaymentService $paymentService): RedirectResponse
    {
        if ($transaction->user_id !== auth()->id()) {
            abort(403);
        }

        if (!$paymentService->cancelByUser($transaction)) {
            return back()->with('error', 'Hanya pesanan dengan status pending yang bisa dibatalkan.');
        }

        return back()->with('success', 'Pesanan berhasil dibatalkan. Kuota tiket telah dikembalikan dan kode pembayaran dinonaktifkan.');
    }
}
