<?php

namespace App\Services\EntityManagers;

use App\Entity\Model;
use App\Repository\BrandRepository;
use App\Repository\ModelRepository;

class ModelManager
{
    private ModelRepository $modelRepository;
    private BrandManager $brandManager;
    public function __construct(ModelRepository $modelRepository, BrandManager $brandManager)
    {
        $this->modelRepository = $modelRepository;
        $this->brandManager = $brandManager;
    }
    public function findOrCreateModelByNameAndBrand(string $name, string $brand): Model
    {
        $model = $this->modelRepository->findOneByNameAndBrand($name, $brand);
        if(!is_null($model)) {
            return $model;
        }
        $model = new Model();
        $brand = $this->brandManager->findOrCreateByName($brand);
        $model->setName($name);
        $model->setBrand($brand);
        $this->modelRepository->add($model, true);

        return $model;
    }
}