<?php
declare(strict_types=1);

namespace Test\GeoWeather\Model;

use Exception;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsFactory;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Serialize\Serializer\Json;
use Test\GeoWeather\Api\Data\GeoWeatherInterface;
use Test\GeoWeather\Api\Data\GeoWeatherInterfaceFactory;
use Test\GeoWeather\Api\GeoWeatherRepositoryInterface;
use Test\GeoWeather\Model\ResourceModel\Collection\GeoWeatherCollectionFactory;
use Test\GeoWeather\Model\ResourceModel\GeoWeatherResource;

/**
 * GeoWeather repository
 */
class GeoWeatherRepository implements GeoWeatherRepositoryInterface
{
    /**
     * @var CollectionProcessorInterface
     */
    private CollectionProcessorInterface $collectionProcessor;

    /**
     * @var GeoWeatherResource
     */
    private GeoWeatherResource $resource;

    /**
     * @var GeoWeatherCollectionFactory
     */
    private GeoWeatherCollectionFactory $collectionFactory;

    /**
     * @var GeoWeatherInterfaceFactory
     */
    private GeoWeatherInterfaceFactory $geoWeatherInterfaceFactory;

    /**
     * @var SearchResultsFactory
     */
    private SearchResultsFactory $geoWeatherSearchResult;

    /**
     * @var Json
     */
    private Json $serializer;

    /**
     * @param GeoWeatherResource $resource
     * @param GeoWeatherCollectionFactory $collectionFactory
     * @param CollectionProcessorInterface $collectionProcessor
     * @param SearchResultsFactory $geoWeatherSearchResult
     * @param Json $serializer
     * @param GeoWeatherInterfaceFactory $geoWeatherInterfaceFactory
     */
    public function __construct(
        GeoWeatherResource              $resource,
        GeoWeatherCollectionFactory     $collectionFactory,
        CollectionProcessorInterface    $collectionProcessor,
        SearchResultsFactory $geoWeatherSearchResult,
        Json $serializer,
        GeoWeatherInterfaceFactory      $geoWeatherInterfaceFactory
    ) {
        $this->geoWeatherInterfaceFactory = $geoWeatherInterfaceFactory;
        $this->geoWeatherSearchResult = $geoWeatherSearchResult;
        $this->serializer = $serializer;
        $this->collectionProcessor = $collectionProcessor;
        $this->collectionFactory = $collectionFactory;
        $this->resource = $resource;
    }

    /**
     * @inheirtDoc
     *
     * @param GeoWeatherInterface $geoWeather
     * @return GeoWeatherInterface
     * @throws CouldNotSaveException
     */
    public function save(GeoWeatherInterface $geoWeather): GeoWeatherInterface
    {
        try {
            $this->resource->save($geoWeather);
        } catch (Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the geoWeather entity: %1',
                $exception->getMessage()
            ));
        }

        return $geoWeather;
    }

    /**
     * @inheirtDoc
     *
     * @param int $id
     * @return GeoWeatherInterface
     * @throws NoSuchEntityException
     */
    public function get(int $id): GeoWeatherInterface
    {
        $geoWeather = $this->geoWeatherInterfaceFactory->create();
        $this->resource->load($geoWeather, $id);

        if (!$geoWeather->getId()) {
            throw new NoSuchEntityException(__('entity with id "%1" does not exist.', $id));
        }

        return $geoWeather;
    }

    /**
     * Prepare and get search result based on given criteria
     *
     * @param SearchCriteriaInterface $criteria
     * @return SearchResultsInterface
     * @throws NoSuchEntityException
     */
    public function getList(SearchCriteriaInterface $criteria): SearchResultsInterface
    {
        try {
            $collection = $this->collectionFactory->create();
            $this->collectionProcessor->process($criteria, $collection);
            $result = $this->geoWeatherSearchResult->create();
            $result->setSearchCriteria($criteria);
            $items = [];

            foreach ($collection as $item) {
                $items[] = $item;
            }

            $result->setItems($items);
            $result->setTotalCount($collection->getSize());
        } catch (\Exception $e) {
            throw new NoSuchEntityException(__('Something went wrong during search'));
        }

        return $result;
    }

    /**
     * @inheirtDoc
     *
     * @param GeoWeatherInterface $geoWeather
     * @return void
     * @throws CouldNotDeleteException
     */
    public function delete(GeoWeatherInterface $geoWeather): void
    {
        try {
            $this->resource->delete($geoWeather);
        } catch (Exception $e) {
            throw new CouldNotDeleteException(__(
                'Could not delete the geoweather entity: %1',
                $e->getMessage()
            ));
        }
    }

    /**
     * @inheritDoc
     */
    public function deleteById(int $entityId): void
    {
        $this->delete($this->get($entityId));
    }

    /**
     * Get geoweather data from last entity by API
     *
     * @return mixed
     */
    public function getLatest()
    {
        $collection = $this->collectionFactory->create();
        $collection->setOrder('entity_id', 'DESC');
        $data = $collection->getFirstItem()->getData();
        $result = ['responce'=>'There is no available geoweather data'];

        if(!empty($data)){
            $result = [
                'position' => $data['position'],
                'temperature' => $data['temperature'],
                'windSpeed' => $data['wind_speed'],
                'windDirection' => $data['wind_dir'],
                'humidity' => $data['humidity'],
                'time' => $data['time']
            ];
        }

        return $this->serializer->serialize($result);
    }
}
