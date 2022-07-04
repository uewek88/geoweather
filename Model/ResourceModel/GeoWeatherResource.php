<?php
declare(strict_types=1);

namespace Test\GeoWeather\Model\ResourceModel;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Resource model of geoWeather entity
 */
class GeoWeatherResource extends AbstractDb
{
    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init('geo_weather', 'entity_id');
    }
}
