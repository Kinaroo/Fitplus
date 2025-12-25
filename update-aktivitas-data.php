<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$aktivitas = \App\Models\AktivitasUser::all();
foreach ($aktivitas as $item) {
    if (is_null($item->berat_badan)) {
        $item->berat_badan = 70;
    }
    if (is_null($item->tinggi_badan)) {
        $item->tinggi_badan = 170;
    }
    $item->save();
}

echo "Updated " . count($aktivitas) . " records with default values\n";
