<?php

namespace Test\GeoWeather\Api\Data;

/**
 * Interface of geoweather model
 */
interface GeoWeatherInterface
{
    /**
     * Data keys constants
     */
    public const TEMPERATURE = 'temperature';

    public const TIME = 'time';

    public const WIND_DIRECTION = 'wind_dir';

    public const HUMIDITY = 'humidity';

    public const WIND_SPEED = 'wind_speed';

    public const POSITION = 'position';

    /**
     * Get temperature
     *
     * @return string|null
     */
    public function getTemperature(): ?string;

    /**
     * Set temperature
     *
     * @param string $temperature
     * @return GeoWeatherInterface
     */
    public function setTemperature(string $temperature):  GeoWeatherInterface;

    /**
     * Get wind speed
     *
     * @return string|null
     */
    public function getWindSpeed(): ?string;

    /**
     * Set current wind speed
     *
     * @param string $windSpeed
     * @return GeoWeatherInterface
     */
    public function setWindSpeed(string $windSpeed): GeoWeatherInterface;

    /**
     * Set weather description
     *
     * @param string $description
     * @return GeoWeatherInterface
     */
    public function setPosition(string $description): GeoWeatherInterface;

    /**
     * Get geoWeather description
     *
     * @return string|null
     */
    public function getPosition(): ?string;

    /**
     * Set time
     *
     * @return GeoWeatherInterface
     */
    public function setTime(): GeoWeatherInterface;

    /**
     * Get entity time
     *
     * @return string|null
     */
    public function getTime(): ?string;

    /**
     * Set current humidity
     *
     * @param string $humidity
     * @return GeoWeatherInterface
     */
    public function setHumidity(string $humidity): GeoWeatherInterface;

    /**
     * @return string|null
     */
    public function getHumidity(): ?string;
}
