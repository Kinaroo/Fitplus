<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$result = \DB::select('DESCRIBE tidur_user');
foreach ($result as $row) {
    echo "{$row->Field}: {$row->Type}" . PHP_EOL;
}
?>
