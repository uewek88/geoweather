<?php
declare(strict_types=1);

namespace Test\GeoWeather\Model;

use Exception;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\HTTP\Client\Curl;
use Magento\Framework\Serialize\Serializer\Json;
use Test\GeoWeather\Api\ConfigInterface;

/**
 * Api request service
 */
class RequestService
{
    /**
     * Geoweather params for request
     */
    public const REQUEST_PARAMS =
        [
            't_2m:C',
            'wind_dir_10m:d',
            'wind_speed_10m:kmh',
            'relative_humidity_2m:p'
        ];

    /**
     * Request URL address
     */
    public const REQUEST_URL = 'https://api.meteomatics.com/';

    /**
     * Request URL address
     */
    public const TOKEN_URL = 'https://login.meteomatics.com/api/v1/token?';

    /**
     * Response format
     */
    public const FORMAT = 'json';

    /**
     * @var ConfigInterface
     */
    protected ConfigInterface $config;

    /**
     * @var Curl
     */
    protected Curl $curl;

    /**
     * @var Json
     */
    protected Json $serializer;

    /**
     * @param ConfigInterface $config
     * @param Curl $curl
     * @param Json $serializer
     */
    public function __construct(
      ConfigInterface $config,
      Curl $curl,
      Json $serializer
    ) {
        $this->serializer = $serializer;
        $this->curl = $curl;
        $this->config = $config;
    }

    /**
     * Get data from Weather API service
     *
     * @return array
     * @throws Exception
     */
    public function getWeatherData(): array
    {
        $curl = $this->curl;
        $curl->get($this->prepareRequest());

        if ($curl->getStatus() != 200) {
            throw new LocalizedException(__('Incorrect request response status!'));
        }

        $response = $this->curl->getBody();
        $data = $this->serializer->unserialize($response);
        $result = [];

        foreach($data['data'] as $item){
            $result[$item['parameter']] = $item['coordinates'][0]['dates'][0]['value'];
        }

        return $result;
    }

    /**
     * Get access token
     *
     * @return string
     * @throws Exception
     */
    public function getValidToken(): string
    {
        $curl = $this->curl;
        $curl->setCredentials($this->config->getUserLogin(),$this->config->getUserPassword());
        $curl->get(self::TOKEN_URL);

        if ($curl->getStatus() != 200) {
            throw new LocalizedException(__('Incorrect request response status!'));
        }

        $response  = $curl->getBody();
        $data = $this->serializer->unserialize($response);

        if(!isset($data['access_token'])) {
            throw new Exception('Cannot take access token!');
        }

        return $data['access_token'];
    }

    /**
     * Prepare url for geoweather data request
     *
     * @return string
     */
    protected function prepareRequest(): string
    {
        $position = $this->config->getPositionLatitude() . ',' . $this->config->getPositionLongitude() ;
        $result = sprintf('%s%s/%s/%s/%s/?access_token=%s',
            self::REQUEST_URL,
            $this->config->getCurrentTime(),
            implode(',',self::REQUEST_PARAMS),
            $position,
            self::FORMAT,
            $this->getValidToken());
        return $result;
    }
}
