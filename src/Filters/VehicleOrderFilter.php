<?php

namespace App\Filters;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use Doctrine\ORM\QueryBuilder;
final class VehicleOrderFilter extends OrderFilter
{
    protected function filterProperty(
        string $property,
        $value,
        QueryBuilder $queryBuilder,
        QueryNameGeneratorInterface $queryNameGenerator,
        string $resourceClass,
        string $operationName = null
    )
    {
        $parameterName = $queryNameGenerator->generateParameterName($property);

        $vehicle = $queryBuilder->getRootAliases()[0];
        if ($property === 'saleDate') {
            $queryBuilder->addOrderBy($vehicle.'.saleDate', $value);
        }
        $queryBuilder->join($vehicle.'.model', 'm');
        if ($property === 'modelName') {
            $queryBuilder->addOrderBy('m.name', $value);
        }
        if ($property === 'brandName') {
            $queryBuilder->join('m.brand', 'b')
                ->addOrderBy('b.name', $value);
        }
        /*dump($property);
        dump($value);
        dump($resourceClass);
        dd(1111);*/
    }
}