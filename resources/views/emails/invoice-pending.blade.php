<h2>Invoice Pemesanan Tiket</h2>
<p>Order ID: {{ $transaction->order_id }}</p>
<p>Tiket: {{ $transaction->ticket->name }}</p>
<p>Total: Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</p>
<p>Status saat ini: PENDING.</p>
