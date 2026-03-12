<?php
include 'db.php';
require_once __DIR__ . '/phpqrcode/qrlib.php';

echo "Database connection is working!<br>";

// Test QR generation
$content = "ATTENDANCE:123";
$filePath = "qr_codes/test_qr.png";
if(!file_exists('qr_codes')){
    mkdir('qr_codes', 0777, true);
}

$result = \QRcode::png($content, $filePath, 'M', 10, 4);
if($result === false){
    echo "QR generation failed!<br>";
} else {
    echo "QR generated successfully at $filePath<br>";
    if(file_exists($filePath)){
        echo "<img src='$filePath' alt='Test QR' /><br>";
        echo "File size: " . filesize($filePath) . " bytes<br>";
    } else {
        echo "File not found!<br>";
    }
}
?>