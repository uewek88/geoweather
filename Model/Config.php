<?php
declare(strict_types=1);

namespace Test\GeoWeather\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
use Test\GeoWeather\Api\ConfigInterface;

/**
 * Configuration service
 */
class Config implements ConfigInterface
{
    /**
     * @var ScopeConfigInterface
     */
    private ScopeConfigInterface $scopeConfig;

    /**
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Get latitude of target position
     *
     * @return string|null
     */
    public function getPositionLatitude(): ?string
    {
        return $this->scopeConfig->getValue(self::XML_LATITUDE, ScopeInterface::SCOPE_STORE);
    }

    /**
     * Get longitude of target position
     *
     * @return string|null
     */
    public function getPositionLongitude(): ?string
    {
        return $this->scopeConfig->getValue(self::XML_LONGITDE, ScopeInterface::SCOPE_STORE);
    }


    /**
     * Get user login for token request
     *
     * @return string|null
     */
    public function getUserLogin(): ?string
    {
        return $this->scopeConfig->getValue(self::XML_USER_LOGIN, ScopeInterface::SCOPE_STORE);
    }

    /**
     * Get user password for token request
     *
     * @return string|null
     */
    public function getUserPassword(): ?string
    {
        return $this->scopeConfig->getValue(self::XML_USER_PASSWORD, ScopeInterface::SCOPE_STORE);
    }

    /**
     * Return correct time string for request
     *
     * @return string
     */
    public function getCurrentTime(): string
    {
        return date('Y-m-d\TH:i:sP');
    }

    /**
     * Prepare and return position data
     *
     * @return string|null
     */
    public function preparePositionString(): ?string
    {   return sprintf('Position latitude - %s , position longitude - %s',
        $this->getPositionLatitude(),$this->getPositionLongitude());
    }
}
