<?php

namespace App;

class Tester
{
    var $hashing;

    public function __construct()
    {
        $this->hashing = new ImageHashing();
    }

    public function generateDHash(string $imagePath): string
    {
        return $this->hashing->hash($imagePath);
    }
    public function generatePHash(string $imagePath): string
    {
        return $this->hashing->phash($imagePath);
    }

    /**
     * @throws \Exception
     */
    public function DhammingDistance(string $hash1, string $hash2): int
    {
        return $this->hashing->DhammingDistance($hash1, $hash2);
    }

    public function PhammingDistance(string $hash1, string $hash2): int
    {
        return $this->hashing->PhammingDistance($hash1, $hash2);
    }
}