<?php
declare(strict_types=1);

namespace Test\GeoWeather\CustomerData;

use Magento\Customer\CustomerData\SectionSourceInterface;
use Magento\Framework\DataObject;
use Test\GeoWeather\Model\ResourceModel\Collection\GeoWeatherCollectionFactory;

/**
 * Data source of geoWeather section
 */
class GeoWeatherCustomerDataSource extends DataObject implements SectionSourceInterface
{
    /**
     * @var GeoWeatherCollectionFactory
     */
    protected GeoWeatherCollectionFactory $collectionFactory;

    /**
     * @param GeoWeatherCollectionFactory $collectionFactory
     * @param array $data
     */
    public function __construct(
        GeoWeatherCollectionFactory $collectionFactory,
        array                       $data = []
    ) {
        parent::__construct($data);
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * Prepare section data based on last geoWeather entity
     *
     * @return array
     */
    public function getSectionData()
    {
        $collection = $this->collectionFactory->create();
        $collection->setOrder('entity_id', 'DESC');
        $data = $collection->getFirstItem()->getData();
        if(!empty($data)) {
            return [
                'position' => html_entity_decode($data['position']),
                'temperature' => html_entity_decode($data['temperature']),
                'windSpeed' => html_entity_decode($data['wind_speed']),
                'windDirection' => html_entity_decode($data['wind_dir']),
                'humidity' => html_entity_decode($data['humidity'])
            ];
        } else {
            return [
                'position' => '',
                'temperature' => '',
                'windSpeed' => '',
                'windDirection' => '',
                'humidity' => ''
            ];
        }

    }
}
