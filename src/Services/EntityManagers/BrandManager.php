<?php

namespace App\Services\EntityManagers;

use App\Entity\Brand;
use App\Repository\BrandRepository;

class BrandManager
{
    private BrandRepository $brandRepository;

    public function __construct(BrandRepository $brandRepository)
    {
        $this->brandRepository = $brandRepository;
    }

    public function findOrCreateByName(string $name): Brand
    {
        $brand = $this->brandRepository->findOneByName($name);
        if(!is_null($brand)) {
            return $brand;
        }
        $brand = new Brand();
        $brand->setName($name);
        $this->brandRepository->add($brand, true);

        return $brand;
    }
}