<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
$trx = App\Models\Transaction::where('order_id', 'ORD-20260501100756-J2EC7Y')->with('user')->first();
if ($trx) {
   echo 'FOUND|user_id=' . $trx->user_id . '|status=' . $trx->status . '|order_id=' . $trx->order_id;
} else {
   echo 'NOT_FOUND';
}
