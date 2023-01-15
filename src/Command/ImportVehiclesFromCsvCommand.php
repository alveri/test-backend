<?php

namespace App\Command;

use App\DTO\VehicleDTO;
use App\Repository\VehicleRepository;
use App\Services\CsvParser;
use App\Services\EntityManagers\VehicleManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;
class ImportVehiclesFromCsvCommand extends Command
{
    protected static $defaultName = 'vehicles:import-from-csv';
    private CsvParser $csvParser;
    private VehicleRepository $vehicleRepository;
    private VehicleManager $vehicleManager;
    public function __construct(
        string $name = null,
        VehicleRepository $vehicleRepository,
        VehicleManager $vehicleManager
    )
    {
        $this->csvParser = new CsvParser(
            'assets/data',
            'test.csv',
            true
        );
        $this->vehicleRepository = $vehicleRepository;
        $this->vehicleManager = $vehicleManager;
        parent::__construct($name);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $imported = 0;
        $skipped = 0;
        /** @var VehicleDTO $vehicleDto */
        foreach ($this->csvParser->parse() as $vehicleDto) {
            if(!is_null($this->vehicleRepository->findOneByVehicleId($vehicleDto->vehicleId))) {
                $skipped++;
                continue;
            }
            $vehicle = $this->vehicleManager->createFromDto($vehicleDto);
            $imported++;
        }
        $output->writeln([
            'Import finished',
            sprintf('%d vehicles imported', $imported),
            sprintf('%d vehicles skipped', $skipped),
        ]);
        return Command::SUCCESS;
    }
}
