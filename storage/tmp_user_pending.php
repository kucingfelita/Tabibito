<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
$user = App\Models\User::find(3);
echo $user ? 'USER=' . $user->name . "\n" : 'USER=none\n';
$pending = App\Models\Transaction::where('user_id', 3)->where('status', 'pending')->get();
foreach ($pending as $t) {
    echo $t->order_id . '|' . $t->status . '|ticket_id=' . $t->ticket_id . "\n";
}
