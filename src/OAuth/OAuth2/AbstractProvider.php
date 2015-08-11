<?php

namespace Vinelab\Socialite\OAuth\OAuth2;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use GuzzleHttp\ClientInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Vinelab\Socialite\OAuth\AbstractProvider as BaseProvider;
use Vinelab\Socialite\Contracts\Provider as ProviderContract;

abstract class AbstractProvider extends BaseProvider
{
    /**
     * The HTTP request instance.
     *
     * @var Request
     */
    protected $request;

    /**
     * The client ID.
     *
     * @var string
     */
    protected $clientId;

    /**
     * The client secret.
     *
     * @var string
     */
    protected $clientSecret;

    /**
     * The type of the encoding in the query.
     *
     * @var int Can be either PHP_QUERY_RFC3986 or PHP_QUERY_RFC1738.
     */
    protected $encodingType = PHP_QUERY_RFC1738;

    /**
     * Create a new provider instance.
     *
     * @param  Request  $request
     * @param  string  $clientId
     * @param  string  $clientSecret
     * @return void
     */
    public function __construct(Request $request, $clientId, $clientSecret)
    {
        $this->request = $request;
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
    }

    /**
     * Get the authentication URL for the provider.
     *
     * @param  string  $url
     * @param  string  $state
     * @return string
     */
    protected function buildAuthUrlFromBase($url, $state)
    {
        return $url.'?'.http_build_query($this->getCodeFields($state), '', '&', $this->encodingType);
    }

    /**
     * Set the request instance.
     *
     * @param  Request  $request
     * @return $this
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;

        return $this;
    }
}
