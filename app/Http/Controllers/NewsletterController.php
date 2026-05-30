<?php

namespace App\Http\Controllers;

use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:255',
        ]);

        $existing = NewsletterSubscriber::where('email', $request->email)->first();

        if ($existing) {
            if ($existing->is_active) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email ini sudah terdaftar sebagai pelanggan newsletter kami.',
                ], 409);
            }

            // Reactivate previously unsubscribed email
            $existing->update([
                'is_active' => true,
                'subscribed_at' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Selamat datang kembali! Langganan newsletter Anda telah diaktifkan ulang.',
            ]);
        }

        NewsletterSubscriber::create([
            'email' => $request->email,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Terima kasih! Anda berhasil berlangganan newsletter Tabibito.',
        ]);
    }

    public function unsubscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $subscriber = NewsletterSubscriber::where('email', $request->email)
            ->where('is_active', true)
            ->first();

        if (!$subscriber) {
            return response()->json([
                'success' => false,
                'message' => 'Email tidak ditemukan dalam daftar langganan.',
            ], 404);
        }

        $subscriber->update(['is_active' => false]);

        return response()->json([
            'success' => true,
            'message' => 'Anda telah berhenti berlangganan newsletter.',
        ]);
    }
}
