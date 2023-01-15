<?php

namespace App\DTO;

class ModelDTO
{
    public string $brand;
    public string $modelTitle;

    public function __construct(string $brand, string $modelTitle)
    {
        $this->brand = $brand;
        $this->modelTitle = $modelTitle;
    }
}