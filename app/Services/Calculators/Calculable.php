<?php

namespace App\Services\Calculators;

interface Calculable
{
    public function create(): void;

    public function update(): void;

    public function delete(): void;
}
