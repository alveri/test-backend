<?php

namespace App\DTO;

class VehicleDTO
{
    public string $vehicleId;
    public int $year;
    public ModelDTO $model;
    public ?string $bodyStyle = null;
    public string $color;
    public string $vin;
    public int $odometer;
    public string $engineSize;
    public int $currentBid = 0;
    public ?\DateTime $saleDate = null;
    public ?\DateTime $startSaleAt = null;
    public LocationDTO $location;
    public string $state;
    public string $city;
    public static function createFromArray(array $vehicleData): VehicleDTO
    {
        $dto = new self();
        $dto->vehicleId = $vehicleData['id'];
        $dto->year = $vehicleData['year'];
        $dto->model = new ModelDTO($vehicleData['make'], $vehicleData['model']);
        $dto->bodyStyle = $vehicleData['body_style'];
        $dto->vin = $vehicleData['vin'];
        $dto->color = $vehicleData['color'];
        $dto->odometer = $vehicleData['odometer'];
        $dto->engineSize = $vehicleData['engine_size'];
        $dto->currentBid = $vehicleData['current_bid'];
        $dto->saleDate = $vehicleData['sale_date'];
        $dto->startSaleAt = $vehicleData['sale_start_at'];
        $dto->location = new LocationDTO($vehicleData['state'], $vehicleData['city']);

        return $dto;
    }
}