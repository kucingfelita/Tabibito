<?php
$pngPath = __DIR__ . '/../public/assets/images/hero.png'; // Actually a JPEG
$webpPath = __DIR__ . '/../public/assets/images/hero.webp';

if (file_exists($pngPath)) {
    // Since it's mime image/jpeg, we use imagecreatefromjpeg
    $img = imagecreatefromjpeg($pngPath);
    if ($img !== false) {
        imagepalettetotruecolor($img);
        
        // Compress and save as WebP at 75% quality
        if (imagewebp($img, $webpPath, 75)) {
            echo "SUCCESS: WebP created at $webpPath.\n";
            echo "Original size: " . round(filesize($pngPath) / 1024, 2) . " KB\n";
            echo "New WebP size: " . round(filesize($webpPath) / 1024, 2) . " KB\n";
        } else {
            echo "ERROR: Failed to save WebP.\n";
        }
        imagedestroy($img);
    } else {
        echo "ERROR: Failed to read JPEG image.\n";
    }
} else {
    echo "ERROR: File not found at $pngPath.\n";
}
