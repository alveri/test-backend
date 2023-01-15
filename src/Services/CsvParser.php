<?php

namespace App\Services;

use App\DTO\VehicleDTO;
use Symfony\Component\Finder\Finder;

class CsvParser
{
    private const SEPARATOR_SYMBOL= ',';
    private const NULL_VALUE = 'NULL';
    private array $options;
    public function __construct($path, $fileName, $ignoreFirstLine)
    {
        $this->options = array(
            'finder_in' => $path,
            'finder_name' => $fileName,
            'ignoreFirstLine' => $ignoreFirstLine
        );
    }

    public function parse()
    {
        $ignoreFirstLine = $this->options['ignoreFirstLine'];

        $finder = new Finder();
        $finder->files()
            ->in($this->options['finder_in'])
            ->name($this->options['finder_name'])
        ;
        foreach ($finder as $file) { $csv = $file; }

        if (($handle = fopen($csv->getRealPath(), "r")) !== FALSE) {
            $i = 0;
            $header = fgetcsv($handle);
            while (($data = fgetcsv($handle, null, ";")) !== FALSE) {
                $i++;
                if ($ignoreFirstLine && $i == 0) {
                    continue;

                }
                $vehicle = array_combine($header, explode(self::SEPARATOR_SYMBOL, $data[0]));
                $locationData = explode(' - ', $vehicle['location_name']);
                $vehicle['state'] = $locationData['0'];
                $vehicle['city'] = $locationData['1'];

                if ($vehicle['body_style'] === self::NULL_VALUE || !$vehicle['body_style']) {
                    $vehicle['body_style'] = null;
                }
                if ($vehicle['sale_date'] === self::NULL_VALUE || !$vehicle['sale_date']) {
                    $vehicle['sale_date'] = null;
                } else {
                    $vehicle['sale_date'] = date_create_from_format('Y-m-d', $vehicle['sale_date']);
                }
                if ($vehicle['sale_start_at'] === self::NULL_VALUE  || !$vehicle['sale_start_at']) {
                    $vehicle['sale_start_at'] = null;
                } else {
                    $vehicle['sale_start_at'] = date_create_from_format('Y-m-d H:i:s', $vehicle['sale_start_at']);
                }
                yield VehicleDTO::createFromArray($vehicle);
            }
            fclose($handle);
        }
    }
}