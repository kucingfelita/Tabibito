<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$destination = \App\Models\Destination::where('name', 'like', '%Candi Borobudur Test%')->with('images')->first();
if ($destination) {
    echo "Destination: " . $destination->name . "\n";
    foreach ($destination->images as $image) {
        echo "Image Path: " . $image->image_path . "\n";
        echo "File Exists: " . (file_exists(storage_path('app/public/' . $image->image_path)) ? 'YES' : 'NO') . "\n";
    }
} else {
    echo "Destination not found\n";
}
