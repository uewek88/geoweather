<?php
declare(strict_types=1);

namespace Test\GeoWeather\Model\ResourceModel\Collection;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Test\GeoWeather\Model\GeoWeather;
use Test\GeoWeather\Model\ResourceModel\GeoWeatherResource;

/**
 * GeoWeather collection
 */
class GeoWeatherCollection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'entity_id';

    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init(GeoWeather::class,GeoWeatherResource::class);
    }
}
