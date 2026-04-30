<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ScannerController extends Controller
{
    public function index(): View
    {
        return view('owner.scanner');
    }

    public function verify(Request $request): JsonResponse
    {
        $data = $request->validate([
            'qr_code_token' => ['required', 'string'],
        ]);

        $transaction = Transaction::query()->where('qr_code_token', $data['qr_code_token'])->first();

        if (! $transaction) {
            return response()->json(['message' => 'QR tidak ditemukan.'], 404);
        }

        if ($transaction->status !== 'settlement') {
            return response()->json(['message' => 'Tiket tidak valid atau sudah digunakan.'], 422);
        }

        $transaction->update(['status' => 'used']);

        return response()->json(['message' => 'Tiket valid dan berhasil digunakan.']);
    }
}
