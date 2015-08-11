<?php

namespace Vinelab\Socialite\OAuth;

abstract class AbstractProvider
{
    /**
     * Get a fresh instance of the Guzzle HTTP client.
     *
     * @return \GuzzleHttp\Client
     */
    protected function getHttpClient()
    {
        return new \GuzzleHttp\Client;
    }
}
