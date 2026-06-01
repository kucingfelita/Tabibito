<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class TransactionExportController extends Controller
{
    public function __invoke(Request $request): StreamedResponse
    {
        $ownerId = auth()->id();
        $destinationIds = Destination::query()->where('user_id', $ownerId)->pluck('id');

        $request->validate([
            'from' => ['nullable', 'date'],
            'to' => ['nullable', 'date', 'after_or_equal:from'],
            'status' => ['nullable', 'in:all,pending,settlement,used,expire,cancelled'],
        ]);

        $query = Transaction::query()
            ->whereHas('ticket', fn ($q) => $q->whereIn('destination_id', $destinationIds))
            ->with(['user:id,name,email', 'ticket:id,name,destination_id', 'ticket.destination:id,name'])
            ->latest();

        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->date('from'));
        }
        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->date('to'));
        }
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $filename = 'transaksi-owner-' . now()->format('Y-m-d-His') . '.csv';

        return response()->streamDownload(function () use ($query) {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($handle, [
                'Order ID',
                'Tanggal Pesanan',
                'Tanggal Kunjungan',
                'Destinasi',
                'Paket Tiket',
                'Jumlah Tiket',
                'Total (Rp)',
                'Status',
                'Nama Pembeli',
                'Email Pembeli',
            ], ';');

            $query->chunk(200, function ($rows) use ($handle) {
                foreach ($rows as $trx) {
                    fputcsv($handle, [
                        $trx->order_id,
                        $trx->created_at?->format('Y-m-d H:i'),
                        $trx->booking_date,
                        $trx->ticket?->destination?->name ?? '',
                        $trx->ticket?->name ?? '',
                        $trx->qty,
                        number_format((float) $trx->total_price, 0, '', ''),
                        $trx->status,
                        $trx->user?->name ?? '',
                        $trx->user?->email ?? '',
                    ], ';');
                }
            });

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }
}
