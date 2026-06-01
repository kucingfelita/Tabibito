<?php

namespace App\Http\Requests;

use App\Models\Ticket;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        /** @var Ticket|null $ticket */
        $ticket = $this->route('ticket');
        $maxQty = $ticket ? max(1, min(20, (int) $ticket->daily_quota)) : 20;

        return [
            'booking_date' => ['required', 'date', 'after_or_equal:today'],
            'qty' => ['required', 'integer', 'min:1', 'max:' . $maxQty],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            /** @var Ticket|null $ticket */
            $ticket = $this->route('ticket');
            $bookingDate = $this->input('booking_date');

            if (!$ticket || !$bookingDate) {
                return;
            }

            $ticket->loadMissing('destination');

            if ($ticket->destination?->status !== 'active') {
                $validator->errors()->add('booking_date', 'Destinasi wisata ini belum tersedia untuk pemesanan.');

                return;
            }

            $available = $ticket->getAvailableQuota($bookingDate);

            if ($available <= 0) {
                $validator->errors()->add('booking_date', 'Kuota tiket untuk tanggal ini sudah habis.');

                return;
            }

            if ((int) $this->input('qty') > $available) {
                $validator->errors()->add('qty', "Kuota tersedia hanya {$available} tiket untuk tanggal tersebut.");
            }
        });
    }

    public function messages(): array
    {
        return [
            'qty.max' => 'Jumlah tiket melebihi kuota harian yang tersedia.',
        ];
    }
}
