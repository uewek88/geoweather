<?php
declare(strict_types=1);

namespace Test\GeoWeather\Cron;

use Exception;
use Test\GeoWeather\Api\Data\GeoWeatherInterfaceFactory;
use Test\GeoWeather\Api\GeoWeatherRepositoryInterface;
use Test\GeoWeather\Model\RequestService;
use Test\GeoWeather\Api\ConfigInterface;
use Psr\Log\LoggerInterface;

/**
 * Cron job to get weather api data
 */
class ReciveWeatherData
{
    /**
     * @var RequestService
     */
    private RequestService $requestService;

    /**
     * @var GeoWeatherInterfaceFactory
     */
    private GeoWeatherInterfaceFactory $geoWeatherFactory;

    /**
     * @var GeoWeatherRepositoryInterface
     */
    private GeoWeatherRepositoryInterface $geoWeatherRepository;

    /**
     * @var ConfigInterface
     */
    private ConfigInterface $config;

    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * @param GeoWeatherRepositoryInterface $geoWeatherRepository
     * @param RequestService $requestService
     * @param ConfigInterface $config
     * @param LoggerInterface $logger
     * @param GeoWeatherInterfaceFactory $geoWeatherFactory
     */
    public function __construct(
        GeoWeatherRepositoryInterface $geoWeatherRepository,
        RequestService $requestService,
        ConfigInterface $config,
        LoggerInterface $logger,
        GeoWeatherInterfaceFactory $geoWeatherFactory
    ) {
        $this->requestService = $requestService;
        $this->logger = $logger;
        $this->config = $config;
        $this->geoWeatherFactory = $geoWeatherFactory;
        $this->geoWeatherRepository = $geoWeatherRepository;
    }

    /**
     * Get geoWeather data from API and create geoWeather entity
     *
     * @return void
     */
    public function execute(): void
    {
        $geoWeatherEntity = $this->geoWeatherFactory->create();
        try{
            $weatherData = $this->requestService->getWeatherData();
            $geoWeatherEntity
                ->setTemperature((string)$weatherData['t_2m:C'])
                ->setWindSpeed((string)$weatherData['wind_speed_10m:kmh'])
                ->setWindDirection((string)$weatherData['wind_dir_10m:d'])
                ->setPosition($this->config->preparePositionString())
                ->setHumidity((string)$weatherData['relative_humidity_2m:p']);
            $this->geoWeatherRepository->save($geoWeatherEntity);
        } catch (Exception $exception) {
            $this->logger->error($exception->getMessage());
        }
    }
}
