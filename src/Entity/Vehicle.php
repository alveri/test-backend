<?php

namespace App\Entity;

use App\Repository\VehicleRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiProperty;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use App\Filters\VehicleOrderFilter;

/**
 * @ApiResource(
 *     collectionOperations={"get"},
 *     itemOperations={"get"},
 *     formats={"json"},
 *     normalizationContext={"groups"={"vehicles"}}
 * )
 * @ApiFilter(SearchFilter::class, properties={"vehicleId": "partial", "vin": "partial"})
 * @ApiFilter(VehicleOrderFilter::class,
 *     properties={"saleDate"},
 *     arguments={"orderParameterName"="order"}
 *     )
 * @ORM\Entity(repositoryClass=VehicleRepository::class)
 */
class Vehicle
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @ApiProperty(identifier=true)
     * @Groups({"vehicles"})
     */
    private $vehicleId;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"read"})
     */
    private $year;

    /**
     * @ORM\ManyToOne(targetEntity=Model::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $model;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"vehicles"})
     */
    private $bodyStyle;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"vehicles"})
     */
    private $color;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"vehicles"})
     */
    private $vin;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"vehicles"})
     */
    private $odometer;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"vehicles"})
     */
    private $engineSize;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"vehicles"})
     */
    private $currentBid;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"vehicles"})
     */
    private $saleDate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"vehicles"})
     */
    private $saleStartAt;

    /**
     * @ORM\ManyToOne(targetEntity=City::class, inversedBy="vehicles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $city;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVehicleId(): ?int
    {
        return $this->vehicleId;
    }

    public function setVehicleId(int $vehicleId): self
    {
        $this->vehicleId = $vehicleId;

        return $this;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(int $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function getModel(): ?Model
    {
        return $this->model;
    }

    public function setModel(?Model $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function getBodyStyle(): ?string
    {
        return $this->bodyStyle;
    }

    public function setBodyStyle(?string $bodyStyle): self
    {
        $this->bodyStyle = $bodyStyle;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function getVin(): ?string
    {
        return $this->vin;
    }

    public function setVin(string $vin): self
    {
        $this->vin = $vin;

        return $this;
    }

    public function getOdometer(): ?int
    {
        return $this->odometer;
    }

    public function setOdometer(int $odometer): self
    {
        $this->odometer = $odometer;

        return $this;
    }

    public function getEngineSize(): ?string
    {
        return $this->engineSize;
    }

    public function setEngineSize(string $engineSize): self
    {
        $this->engineSize = $engineSize;

        return $this;
    }

    public function getCurrentBid(): ?int
    {
        return $this->currentBid;
    }

    public function setCurrentBid(int $currentBid): self
    {
        $this->currentBid = $currentBid;

        return $this;
    }

    public function getSaleDate(): ?\DateTimeInterface
    {
        return $this->saleDate;
    }

    public function setSaleDate(?\DateTimeInterface $saleDate): self
    {
        $this->saleDate = $saleDate;

        return $this;
    }

    public function getSaleStartAt(): ?\DateTimeInterface
    {
        return $this->saleStartAt;
    }

    public function setSaleStartAt(?\DateTimeInterface $saleStartAt): self
    {
        $this->saleStartAt = $saleStartAt;

        return $this;
    }

    public function getCity(): ?City
    {
        return $this->city;
    }

    public function setCity(?City $city): self
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @Groups("vehicles")
     */
    public function getModelName(): string
    {
        return $this->getModel()->getName();
    }

    /**
     * @Groups("vehicles")
     */
    public function getBrandName(): string
    {
        return $this->getModel()->getBrand()->getName();
    }

    /**
     * @Groups("vehicles")
     */
    public function getLocation()
    {
        return $this->getCity()->getName() . ', ' . $this->getCity()->getState()->getCode();
    }
}