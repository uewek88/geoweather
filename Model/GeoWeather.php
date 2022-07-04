<?php
declare(strict_types=1);

namespace Test\GeoWeather\Model;

use Magento\Framework\Model\AbstractModel;
use Test\GeoWeather\Api\Data\GeoWeatherInterface;
use Test\GeoWeather\Model\ResourceModel\GeoWeatherResource;

/**
 * Model of geoWeather entity
 */
class GeoWeather extends AbstractModel implements GeoWeatherInterface
{
    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(GeoWeatherResource::class);
    }

    /**
     * @inheritDoc
     *
     * @param string $temperature
     * @return GeoWeatherInterface
     */
    public function setTemperature(string $temperature): GeoWeatherInterface
    {
        $this->setData(self::TEMPERATURE, $temperature);

        return $this;
    }

    /**
     * @inheirtDoc
     *
     * @return string|null
     */
    public function getTemperature(): ?string
    {
        return $this->getData(self::TEMPERATURE);
    }

    /**
     * @return GeoWeatherInterface
     */
    public function setTime(): GeoWeatherInterface
    {
        $this->setData(self::TIME, time());

        return $this;
    }

    /**
     * @inheritDoc
     *
     * @return string|null
     */
    public function getTime(): ?string
    {
        return $this->getData(self::TIME);
    }

    /**
     * @param string $windDirection
     * @return GeoWeatherInterface
     */
    public function setWindDirection(string $windDirection): GeoWeatherInterface
    {
        $this->setData(self::WIND_DIRECTION, $windDirection);

        return $this;
    }

    /**
     * @return string|null
     */
    public function getWindDirection(): ?string
    {
        return $this->getData(self::WIND_DIRECTION);
    }

    /**
     * Set current humidity
     *
     * @param string $humidity
     * @return GeoWeatherInterface
     */
    public function setHumidity(string $humidity): GeoWeatherInterface
    {
        $this->setData(self::HUMIDITY, $humidity);

        return $this;
    }

    /**
     * Get geoweather humidity
     *
     * @return string|null
     */
    public function getHumidity(): ?string
    {
        return $this->getData(self::HUMIDITY);
    }

    /**
     * Set current wind speed
     *
     * @param string $windSpeed
     * @return GeoWeatherInterface
     */
    public function setWindSpeed(string $windSpeed): GeoWeatherInterface
    {
        $this->setData(self::WIND_SPEED, $windSpeed);

        return $this;
    }

    /**
     * Get entity wind speed
     *
     * @return string|null
     */
    public function getWindSpeed(): ?string
    {
        return $this->getData(self::WIND_SPEED);
    }

    /**
     * Set entity position
     *
     * @param string $position
     * @return GeoWeatherInterface
     */
    public function setPosition(string $position): GeoWeatherInterface
    {
        $this->setData(self::POSITION, $position);

        return $this;
    }

    /**
     * Get entity position
     *
     * @return string|null
     */
    public function getPosition(): ?string
    {
        return $this->getData(self::POSITION);
    }


}
