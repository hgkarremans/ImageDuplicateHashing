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

//difference between perplecual hashing
try {
    $noDifference = $tester->PhammingDistance($hash, $hash);
    $differenceSmall = $tester->PhammingDistance($hash, $hash2);
    $differenceBig = $tester->PhammingDistance($hash, $hash3);
    $differenceCropped = $tester->PhammingDistance($hash3, $hashCropped);
    $differenceLessCropped = $tester->PhammingDistance($hash3, $hashLessCropped);
    $differenceColor = $tester->PhammingDistance($hash3, $hashColorDifferent);
    $differenceWatermark = $tester->PhammingDistance($hash3, $hashWatermark);
    $differencePikachu = $tester->PhammingDistance($hash3, $hashPikachu);
} catch (Exception $e) {
    echo $e->getMessage();
}
//difference between difference hashing
try {
    $noDifferenceD = $tester->DhammingDistance($hashD, $hashD);
    $differenceSmallD = $tester->DhammingDistance($hashD, $hash2D);
    $differenceBigD = $tester->DhammingDistance($hashD, $hash3D);
    $differenceCroppedD = $tester->DhammingDistance($hash3D, $hashCroppedD);
    $differenceLessCroppedD = $tester->DhammingDistance($hash3D, $hashLessCroppedD);
    $differenceColorD = $tester->DhammingDistance($hash3D, $hashColorDifferentD);
    $differenceWatermarkD = $tester->DhammingDistance($hash3D, $hashWatermarkD);
    $differencePikachuD = $tester->DhammingDistance($hash3D, $hashPikachuD);
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
