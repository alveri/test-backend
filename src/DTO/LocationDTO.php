<?php

namespace App\DTO;

class LocationDTO
{
    public string $state;
    public string $city;

    public function __construct(string $state, string $city)
    {
        $this->state = $state;
        $this->city = $city;
    }
}