<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Tester;

$tester = new Tester();
$hash = $tester->generatePHash('../assets/Lijnmarkt.jpg');
$hash2 = $tester->generatePHash('../assets/LijnmarktKopie.jpg');
$hash3 = $tester->generatePHash('../assets/RandomHouse.jpg');
$hashCropped = $tester->generatePHash('../assets/RandomHouse_cropped.jpg');
$hashColorDifferent = $tester->generatePHash('../assets/RandomHouse_different_color.jpg');
$hashWatermark = $tester->generatePHash('../assets/randomhouse_watermark.png');

echo "hash: $hash\n";
echo "hash2: $hash2\n";
try {
    $noDifference = $tester->hPhammingDistance($hash, $hash);
    $differenceSmall = $tester->hPhammingDistance($hash, $hash2);
    $differenceBig = $tester->hPhammingDistance($hash, $hash3);
    $differenceCropped = $tester->hPhammingDistance($hash3, $hashCropped);
    $differenceColor = $tester->hPhammingDistance($hash3, $hashColorDifferent);
    $differenceWatermark = $tester->hPhammingDistance($hash3, $hashWatermark);
} catch (Exception $e) {
    echo $e->getMessage();
}
echo "no difference: $noDifference\n";
echo "small difference: $differenceSmall\n";
echo "different house difference: $differenceBig\n";

echo "cropped difference: $differenceCropped\n";
echo "color difference: $differenceColor\n";
echo "watermark difference: $differenceWatermark\n";