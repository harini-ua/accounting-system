<?php

namespace App\Services;


interface Calculable
{
    public function create(): void;
    public function update(): void;
    public function delete(): void;
}