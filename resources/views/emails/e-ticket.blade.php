<h2>E-Ticket Aktif</h2>
<p>Order ID: {{ $transaction->order_id }}</p>
<p>Destinasi: {{ $transaction->ticket->destination->name }}</p>
<p>Tanggal Booking: {{ $transaction->booking_date->format('d M Y') }}</p>
<p>Status: LUNAS. Tunjukkan QR berikut saat masuk lokasi:</p>
<div>{!! QrCode::size(200)->generate($transaction->qr_code_token) !!}</div>
