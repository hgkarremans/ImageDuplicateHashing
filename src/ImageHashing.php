<?php

namespace App;

use Exception;

class ImageHashing implements Hashing
{

    public function hash(string $imagePath): string
    {
        $size = 8;
        //here i will be loading the image
        $image = imagecreatefromstring(file_get_contents($imagePath));

        //here i will be resizing the image
        $resizedImage = imagecreatetruecolor($size + 1, $size);

        imagecopyresampled($resizedImage, $image, 0, 0, 0, 0, $size + 1, $size, imagesx($image), imagesy($image));

        //calculate the difference hash
        $hash = '';
        for ($y = 0; $y < $size; $y++) {
            for ($x = 0; $x < $size; $x++) {
                //get color of pixel at x and y position
                $leftColor = imagecolorat($resizedImage, $x, $y);
                $rightColor = imagecolorat($resizedImage, $x + 1, $y);

                //calculate the grayscale
                $leftGray = ($leftColor >> 16) & 0xFF;
                $rightGray = ($rightColor >> 16) & 0xFF;

                //create hash
                $hash .= ($leftGray < $rightGray) ? '1' : '0';

            }
        }
        imagedestroy($image);
        imagedestroy($resizedImage);
        return $hash;
    }

    public function hammingDistance(string $hash1, string $hash2): int
    {
        if (strlen($hash1) !== strlen($hash2)) {
            throw new Exception('Hash lengths must be equal.');
        }

        $distance = 0;
        for ($i = 0; $i < strlen($hash1); $i++) {
            if ($hash1[$i] !== $hash2[$i]) {
                $distance++;
            }
        }
        return $distance;
    }
}