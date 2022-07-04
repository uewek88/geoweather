<?php

namespace Test\GeoWeather\Api;

/**
 * Interface of config model
 */
interface ConfigInterface
{
    /**
     * Path to user login value
     */
    public const XML_USER_LOGIN = 'api/configuration/user_login';

    /**
     * Path to user password value
     */
    public const XML_USER_PASSWORD = 'api/configuration/user_password';

    /**
     * Path to token url value
     */
    public const XML_TOKEN_URL = 'api/configuration/token_url';

    /**
     * Path to request url value
     */
    public const XML_REQUEST_URL = 'api/configuration/request_url';

    /**
     * Path to position latitude value
     */
    public const XML_LATITUDE = 'api/configuration/lat';

    /**
     * Path to request url value
     */
    public const XML_LONGITDE = 'api/configuration/lon';
}
