<?php

namespace App;

interface Hashing
{
    public function hash (string $imagePath): string;
    public function hammingDistance(string $hash1, string $hash2): int;

}