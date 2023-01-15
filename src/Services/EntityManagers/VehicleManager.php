<?php

namespace App\Services\EntityManagers;

use App\DTO\VehicleDTO;
use App\Entity\Vehicle;
use App\Repository\VehicleRepository;

class VehicleManager
{
    private ModelManager $modelManager;
    private  LocationManager $locationManager;
    private VehicleRepository $vehicleRepository;

    public function __construct(
        ModelManager $modelManager,
        LocationManager $locationManager,
        VehicleRepository $vehicleRepository
    )
    {
        $this->modelManager = $modelManager;
        $this->locationManager = $locationManager;
        $this->vehicleRepository = $vehicleRepository;
    }
    public function createFromDto(VehicleDTO $vehicleDTO): Vehicle
    {
        $vehicle = new Vehicle();
        $vehicle->setVehicleId($vehicleDTO->vehicleId);
        $vehicle->setYear($vehicleDTO->year);
        $vehicle->setModel(
            $this->modelManager->findOrCreateModelByNameAndBrand($vehicleDTO->model->modelTitle, $vehicleDTO->model->brand)
        );
        $vehicle->setBodyStyle($vehicleDTO->bodyStyle);
        $vehicle->setColor($vehicleDTO->color);
        $vehicle->setVin($vehicleDTO->vin);
        $vehicle->setOdometer($vehicleDTO->odometer);
        $vehicle->setEngineSize($vehicleDTO->engineSize);
        $vehicle->setCurrentBid($vehicleDTO->currentBid);
        $vehicle->setSaleDate($vehicleDTO->saleDate);
        $vehicle->setSaleStartAt($vehicleDTO->startSaleAt);
        $vehicle->setCity(
            $this->locationManager->findOrCreateLocationByCityAndState($vehicleDTO->location->city, $vehicleDTO->location->state)
        );

        $this->vehicleRepository->add($vehicle, true);

        return $vehicle;
    }
}