<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Tester;

$tester = new Tester();
$hash = $tester->generateHash('../assets/Lijnmarkt.jpg');
$hash2 = $tester->generateHash('../assets/LijnmarktKopie.jpg');
$hash3 = $tester->generateHash('../assets/RandomHouse.jpg');
$hashCropped = $tester->generateHash('../assets/RandomHouse_cropped.jpg');
$hashColorDifferent = $tester->generateHash('../assets/RandomHouse_different_color.jpg');
echo "hash: $hash\n";

try {
    $noDifference = $tester->hammingDistance($hash, $hash);
    $differenceSmall = $tester->hammingDistance($hash, $hash2);
    $differenceBig = $tester->hammingDistance($hash, $hash3);
    $differenceCropped = $tester->hammingDistance($hash3, $hashCropped);
    $differenceColor = $tester->hammingDistance($hash3, $hashColorDifferent);
} catch (Exception $e) {
    echo $e->getMessage();
}
echo "no difference: $noDifference\n";
echo "small difference: $differenceSmall\n";
echo "big difference: $differenceBig\n";

echo "cropped difference: $differenceCropped\n";
echo "color difference: $differenceColor\n";