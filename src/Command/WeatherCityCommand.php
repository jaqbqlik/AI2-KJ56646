<?php
namespace App\Command;
use App\Service\WeatherUtil;
use Symfony\Component\Console\Attribute\Argument;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'weather:city',
    description: 'Show weather for a city',
)]
class WeatherCityCommand
{
    public function __construct(
        private WeatherUtil $weatherUtil
    ) {
    }
    public function __invoke(
        SymfonyStyle $io,
        #[Argument('Country Code (ex.: PL, DE, EN)')] string $countrySymbol,
        #[Argument('Name of city in given country (ex.: Szczecin, Police)')] string $cityName,
    ): int {
        $measurements = $this->weatherUtil->getWeatherForCountryAndCity(
            $countrySymbol,
            $cityName
        );
        $io->writeln(sprintf('Location: %s', $cityName));
        $io->table(['Date', 'Temperature'], array_map(fn($m) => [
            $m->getDate()->format('Y-m-d'),
            $m->getCelsius(),
        ], $measurements));

        return Command::SUCCESS;
    }
}
