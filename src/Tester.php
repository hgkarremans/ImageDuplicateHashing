<?php

namespace App;

class Tester
{
    var $hashing;

    public function __construct()
    {
        $this->hashing = new ImageHashing();
    }

    public function generateHash(string $imagePath): string
    {
        return $this->hashing->hash($imagePath);
    }

    /**
     * @throws \Exception
     */
    public function hammingDistance(string $hash1, string $hash2): int
    {
        return $this->hashing->hammingDistance($hash1, $hash2);
    }
}