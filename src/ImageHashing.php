<?php

namespace App;

use Exception;
use InvalidArgumentException;

class ImageHashing implements Hashing
{

    public function hash(string $imagePath): string
    {
        $size = 8;
        $image = imagecreatefromstring(file_get_contents($imagePath));

        $resizedImage = imagecreatetruecolor($size + 1, $size);

        imagecopyresampled($resizedImage, $image, 0, 0, 0, 0, $size + 1, $size, imagesx($image), imagesy($image));

        $hash = '';
        for ($y = 0; $y < $size; $y++) {
            for ($x = 0; $x < $size; $x++) {
                $leftColor = imagecolorat($resizedImage, $x, $y);
                $rightColor = imagecolorat($resizedImage, $x + 1, $y);

                $leftGray = ($leftColor >> 16) & 0xFF;
                $rightGray = ($rightColor >> 16) & 0xFF;

                $hash .= ($leftGray < $rightGray) ? '1' : '0';

            }
        }
        imagedestroy($image);
        imagedestroy($resizedImage);
        return $hash;
    }

    public function phash(string $imagePath): string
    {
        $img = imagecreatefromstring(file_get_contents($imagePath));

        $resizedImg = imagecreatetruecolor(32, 32);
        imagecopyresampled($resizedImg, $img, 0, 0, 0, 0, 8, 8, imagesx($img), imagesy($img));

        $grayValues = [];
        $total = 0;

        for ($y = 0; $y < 8; $y++) {
            for ($x = 0; $x < 8; $x++) {
                $rgb = imagecolorat($resizedImg, $x, $y);
                $r = ($rgb >> 16) & 0xFF;
                $g = ($rgb >> 8) & 0xFF;
                $b = $rgb & 0xFF;

                $gray = (0.299 * $r + 0.587 * $g + 0.114 * $b);
                $grayValues[] = $gray;
                $total += $gray;
            }
        }

        $average = $total / 64;

        $hashBits = '';
        foreach ($grayValues as $gray) {
            $hashBits .= ($gray > $average) ? '1' : '0';
        }

        $hashHex = '';
        for ($i = 0; $i < 64; $i += 4) {
            $hashHex .= dechex(bindec(substr($hashBits, $i, 4)));
        }

        imagedestroy($img);
        imagedestroy($resizedImg);

        return $hashHex;
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