<?php

namespace App;

use Exception;
use InvalidArgumentException;

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

    public function phash(string $imagePath): string
    {
        // Step 1: Load the image
        $img = imagecreatefromstring(file_get_contents($imagePath));

        // Step 2: Resize the image to 8x8
        $resizedImg = imagecreatetruecolor(32, 32);
        imagecopyresampled($resizedImg, $img, 0, 0, 0, 0, 8, 8, imagesx($img), imagesy($img));

        // Step 3: Convert the image to grayscale and calculate average value
        $grayValues = [];
        $total = 0;

        for ($y = 0; $y < 8; $y++) {
            for ($x = 0; $x < 8; $x++) {
                $rgb = imagecolorat($resizedImg, $x, $y);
                $r = ($rgb >> 16) & 0xFF;
                $g = ($rgb >> 8) & 0xFF;
                $b = $rgb & 0xFF;

                // Calculate grayscale value
                $gray = (0.299 * $r + 0.587 * $g + 0.114 * $b);
                $grayValues[] = $gray;
                $total += $gray;
            }
        }

        // Step 4: Calculate the average value
        $average = $total / 64;

        // Step 5: Create the hash
        $hashBits = '';
        foreach ($grayValues as $gray) {
            $hashBits .= ($gray > $average) ? '1' : '0';
        }

        // Step 6: Convert to hexadecimal
        $hashHex = '';
        for ($i = 0; $i < 64; $i += 4) {
            $hashHex .= dechex(bindec(substr($hashBits, $i, 4)));
        }

        // Clean up
        imagedestroy($img);
        imagedestroy($resizedImg);

        return $hashHex;
    }

    public function DhammingDistance(string $hash1, string $hash2): int
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

    function PhammingDistance($hash1, $hash2): int
    {
        // Ensure both hashes are of the same length
        if (strlen($hash1) !== strlen($hash2)) {
            throw new InvalidArgumentException("Hashes must be of the same length.");
        }

        // Initialize the distance counter
        $distance = 0;

        // Calculate the Hamming distance
        for ($i = 0; $i < strlen($hash1); $i++) {
            if ($hash1[$i] !== $hash2[$i]) {
                $distance++;
            }
        }

        return $distance;
    }
}