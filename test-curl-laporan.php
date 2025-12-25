<?php
// Simple curl test
$url = 'http://localhost:8000/laporan/kesehatan';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_COOKIEFILE, sys_get_temp_dir() . '/cookies.txt');
curl_setopt($ch, CURLOPT_COOKIEJAR, sys_get_temp_dir() . '/cookies.txt');
curl_setopt($ch, CURLOPT_TIMEOUT, 30);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);

curl_close($ch);

echo "HTTP Code: " . $httpCode . "\n";
echo "Content-Type: " . $contentType . "\n";
echo "Response Length: " . strlen($response) . "\n";
echo "\n===== FIRST 1000 CHARS =====\n";
echo substr($response, 0, 1000) . "\n";
echo "\n===== LAST 500 CHARS =====\n";
echo substr($response, -500) . "\n";

// Check if contains error
if (strpos($response, 'error') !== false) {
    echo "\n⚠️ ERROR FOUND IN RESPONSE\n";
}
if (strpos($response, 'Exception') !== false) {
    echo "\n⚠️ EXCEPTION FOUND IN RESPONSE\n";
}
if (strpos($response, 'Whoops') !== false) {
    echo "\n⚠️ WHOOPS (Laravel error) FOUND IN RESPONSE\n";
}
?>
