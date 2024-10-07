<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Tester;

$tester = new Tester();
//using pHash
$hash = $tester->generatePHash('../assets/Lijnmarkt.jpg');
$hash2 = $tester->generatePHash('../assets/LijnmarktKopie.jpg');
$hash3 = $tester->generatePHash('../assets/RandomHouse.jpg');
$hashCropped = $tester->generatePHash('../assets/RandomHouse_cropped.jpg');
$hashLessCropped = $tester->generatePHash('../assets/RandomHouse_less_cropped.jpg');
$hashColorDifferent = $tester->generatePHash('../assets/RandomHouse_different_color.jpg');
$hashWatermark = $tester->generatePHash('../assets/randomhouse_watermark.png');
$hashPikachu = $tester->generatePHash('../assets/pikachu.jpeg');


//using dHash
$hashD = $tester->generateDHash('../assets/Lijnmarkt.jpg');
$hash2D = $tester->generateDHash('../assets/LijnmarktKopie.jpg');
$hash3D = $tester->generateDHash('../assets/RandomHouse.jpg');
$hashCroppedD = $tester->generateDHash('../assets/RandomHouse_cropped.jpg');
$hashLessCroppedD = $tester->generateDHash('../assets/RandomHouse_less_cropped.jpg');
$hashColorDifferentD = $tester->generateDHash('../assets/RandomHouse_different_color.jpg');
$hashWatermarkD = $tester->generateDHash('../assets/randomhouse_watermark.png');
$hashPikachuD = $tester->generateDHash('../assets/pikachu.jpeg');

try {
    $noDifference = $tester->hammingDistance($hash, $hash);
    $differenceSmall = $tester->hammingDistance($hash, $hash2);
    $differenceBig = $tester->hammingDistance($hash, $hash3);
    $differenceCropped = $tester->hammingDistance($hash3, $hashCropped);
    $differenceLessCropped = $tester->hammingDistance($hash3, $hashLessCropped);
    $differenceColor = $tester->hammingDistance($hash3, $hashColorDifferent);
    $differenceWatermark = $tester->hammingDistance($hash3, $hashWatermark);
    $differencePikachu = $tester->hammingDistance($hash3, $hashPikachu);
} catch (Exception $e) {
    echo $e->getMessage();
}
try {
    $noDifferenceD = $tester->hammingDistance($hashD, $hashD);
    $differenceSmallD = $tester->hammingDistance($hashD, $hash2D);
    $differenceBigD = $tester->hammingDistance($hashD, $hash3D);
    $differenceCroppedD = $tester->hammingDistance($hash3D, $hashCroppedD);
    $differenceLessCroppedD = $tester->hammingDistance($hash3D, $hashLessCroppedD);
    $differenceColorD = $tester->hammingDistance($hash3D, $hashColorDifferentD);
    $differenceWatermarkD = $tester->hammingDistance($hash3D, $hashWatermarkD);
    $differencePikachuD = $tester->hammingDistance($hash3D, $hashPikachuD);
} catch (Exception $e) {
    echo $e->getMessage();
}
//printing the results
echo "pHashing\n";
echo "no difference: $noDifference\n";
echo "small difference: $differenceSmall\n";
echo "different house difference: $differenceBig\n";

echo "cropped difference: $differenceCropped\n";
echo "less cropped difference: $differenceLessCropped\n";
echo "color difference: $differenceColor\n";
echo "watermark difference: $differenceWatermark\n";
echo "pikachu difference: $differencePikachu\n";


echo "\ndHashing\n";
echo "no difference: $noDifferenceD\n";
echo "small difference: $differenceSmallD\n";
echo "different house difference: $differenceBigD\n";

echo "cropped difference: $differenceCroppedD\n";
echo "less cropped difference: $differenceLessCroppedD\n";
echo "color difference: $differenceColorD\n";
echo "watermark difference: $differenceWatermarkD\n";
echo "pikachu difference: $differencePikachuD\n";
