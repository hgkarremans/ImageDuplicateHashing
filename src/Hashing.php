<?php

namespace App;

interface Hashing
{
    public function hash (string $imagePath): string;
    public function DhammingDistance(string $hash1, string $hash2): int;
    public function PhammingDistance(string $hash1, string $hash2): int;

}