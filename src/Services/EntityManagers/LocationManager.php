<?php

namespace App\Services\EntityManagers;

use App\Entity\City;
use App\Entity\State;
use App\Repository\CityRepository;
use App\Repository\StateRepository;

class LocationManager
{
    private CityRepository $cityRepository;
    private StateRepository $stateRepository;

    public function __construct(CityRepository $cityRepository, StateRepository $stateRepository)
    {
        $this->cityRepository = $cityRepository;
        $this->stateRepository = $stateRepository;
    }

    public function findOrCreateLocationByCityAndState(string $cityName, string $code): City
    {
        $city = $this->cityRepository->findOneByTitleAndStateCode($cityName, $code);
        if(!is_null($city)) {
            return $city;
        }
        $state = $this->stateRepository->findOneByCode($code);
        if(is_null($state)) {
            $state = new State();
            $state->setCode($code);
            $this->stateRepository->add($state, true);
        }
        $city = new City();
        $city->setName($cityName);
        $city->setState($state);
        $this->cityRepository->add($city, true);

        return $city;
    }
}