<?php

namespace Test\GeoWeather\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Test\GeoWeather\Api\Data\GeoWeatherInterface;

/**
 * Interface for geoWeather repository
 */
interface GeoWeatherRepositoryInterface
{
    /**
     * Save geoWeather entity
     *
     * @param GeoWeatherInterface $geoWeather
     * @return GeoWeatherInterface
     * @throws LocalizedException
     */
    public function save(GeoWeatherInterface $geoWeather): GeoWeatherInterface;

    /**
     * Get geoWeather entity
     *
     * @param int $entityId
     * @return GeoWeatherInterface
     */
    public function get(int $entityId): GeoWeatherInterface;

    /**
     * Get search result
     *
     * @param SearchCriteriaInterface $criteria
     * @return SearchResultsInterface
     * @throws LocalizedException
     */
    public function getList(SearchCriteriaInterface $criteria): SearchResultsInterface;

    /**
     * Delete geoWeather entity
     *
     * @param GeoWeatherInterface $geoWeather
     * @return void
     * @throws LocalizedException
     */
    public function delete(GeoWeatherInterface $geoWeather): void;

    /**
     * Delete geoWeather entity by entity id
     *
     * @param int $id
     * @throws NoSuchEntityException
     * @throws LocalizedException
     * @return void
     */
    public function deleteById(int $id): void;

    /**
     * Get geoweather data from last entity by API
     *
     * @return mixed
     */
    public function getLatest();
}
