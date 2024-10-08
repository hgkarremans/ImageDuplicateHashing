<?php

namespace App;

use Exception;
use InvalidArgumentException;

//https://content-blockchain.org/research/testing-different-image-hash-functions/
class ImageHashing implements Hashing
{

    public function hash(string $imagePath): string
    {
        $size = 8;
        $image = imagecreatefromstring(file_get_contents($imagePath));

        //resizing to 9x8
        $resizedImage = imagecreatetruecolor($size + 1, $size);

        imagecopyresampled($resizedImage, $image, 0, 0, 0, 0, $size + 1, $size, imagesx($image), imagesy($image));

        $hash = '';
        for ($y = 0; $y < $size; $y++) {
            for ($x = 0; $x < $size; $x++) {
                $leftColor = imagecolorat($resizedImage, $x, $y);
                $rightColor = imagecolorat($resizedImage, $x + 1, $y);
                //move red channel 16 bits to the right to get grayscale value
                $leftGray = ($leftColor >> 16) & 0xFF;
                $rightGray = ($rightColor >> 16) & 0xFF;
                //if grayscale version of left pixel is less than right pixel,
                // add 1 to hash, else add 0
                $hash .= ($leftGray < $rightGray) ? '1' : '0';
            }
        }
        imagedestroy($image);
        imagedestroy($resizedImage);
        return $hash;
    }
    //https://github.com/xwiz/phash/blob/master/phash.php

    //speed using 8x8 image
    //Lijnmarkt.jpg: 0.037919044494629 seconds
    //LijnmarktKopie.jpg: 0.045822858810425 seconds
    //RandomHouse.jpg: 0.021607160568237 seconds
    //RandomHouse_cropped.jpg: 0.011152982711792 seconds
    //RandomHouse_less_cropped.jpg: 0.014021873474121 seconds
    //RandomHouse_different_color.jpg: 0.016796112060547 seconds
    //randomhouse_watermark.png: 0.049664974212646 seconds
    //pikachu.jpeg: 0.0005800724029541 seconds

    //speed using a 32x32 image
    //Lijnmarkt.jpg: 0.036460876464844 seconds
    //LijnmarktKopie.jpg: 0.045872211456299 seconds
    //RandomHouse.jpg: 0.036751985549927 seconds
    //RandomHouse_cropped.jpg: 0.011002063751221 seconds
    //RandomHouse_less_cropped.jpg: 0.013952970504761 seconds
    //RandomHouse_different_color.jpg: 0.020583868026733 seconds
    //randomhouse_watermark.png: 0.058554172515869 seconds
    //pikachu.jpeg: 0.00053882598876953 seconds
    public function phash(string $imagePath): string
    {
        $img = imagecreatefromstring(file_get_contents($imagePath));
        $size = 32;
        //resizing
        //not alot of upsides to resizing to 32x32
        $resizedImg = imagecreatetruecolor($size, $size);
        imagecopyresampled($resizedImg, $img, 0, 0, 0, 0, $size, $size, imagesx($img), imagesy($img));

        $grayValues = [];
        $total = 0;
        //calculating average grayscale value
        for ($y = 0; $y < $size; $y++) {
            for ($x = 0; $x < $size; $x++) {
                $rgb = imagecolorat($resizedImg, $x, $y);
                $r = ($rgb >> 16) & 0xFF;
                $g = ($rgb >> 8) & 0xFF;
                $b = $rgb & 0xFF;

                $gray = (0.299 * $r + 0.587 * $g + 0.114 * $b);
                $grayValues[] = $gray;
                $total += $gray;
            }
        }

        $average = $total / 1024;
        //if grayscale value is greater than average, add 1 to hash, else add 0
        $hashBits = '';
        foreach ($grayValues as $gray) {
            $hashBits .= ($gray > $average) ? '1' : '0';
        }
        //convert binary hash to hexadecimal
        $hashHex = '';
        for ($i = 0; $i < 64; $i += 4) {
            $hashHex .= dechex(bindec(substr($hashBits, $i, 4)));
        }
        echo $hashHex;

        imagedestroy($img);
        imagedestroy($resizedImg);

        return $hashHex;
    }

    //speed
    //no difference: 9.5367431640625E-7 seconds
    //small difference: 1.1920928955078E-6 seconds
    //different house difference: 1.9073486328125E-6 seconds
    //cropped difference: 1.9073486328125E-6 seconds
    //less cropped difference: 1.1920928955078E-6 seconds
    //color difference: 1.9073486328125E-6 seconds
    //watermark difference: 9.5367431640625E-7 seconds
    //pikachu difference: 2.1457672119141E-6 seconds

    public function hammingDistance(string $hash1, string $hash2): int
    {
        if (strlen($hash1) !== strlen($hash2)) {
            throw new Exception('Hash lengths must be equal.');
        }
        //compare each character of the two hashes and increment distance if they are different
        $distance = 0;
        for ($i = 0; $i < strlen($hash1); $i++) {
            if ($hash1[$i] !== $hash2[$i]) {
                $distance++;
            }
        }
        return $distance;
    }
}