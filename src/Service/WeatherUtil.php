<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Location;
use App\Entity\Measurement;
use App\Repository\LocationRepository;
use App\Repository\MeasurementRepository;

class WeatherUtil
{
    public function __construct(
        private MeasurementRepository $mRep,
        private LocationRepository $lRep
    ) {
    }

    /**
     * @return Measurement[]
     */
    public function getWeatherForLocation(Location $location): array
    {
        return $this->mRep->findByLocation($location);
    }

    /**
     * @return Measurement[]
     */
    public function getWeatherForCountryAndCity(string $countryCode, string $city): array
    {
        $location = $this->lRep->findOneBy([
            'country' => $countryCode,
            'city' => $city,
        ]);

        if ($location === null) {
            return [];
        }

        return $this->getWeatherForLocation($location);
    }
}
