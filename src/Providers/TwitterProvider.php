<?php

namespace Vinelab\Socialite\Providers;

use Illuminate\Http\Request;
use InvalidArgumentException;
use League\OAuth1\Client\Server\Server;
use Vinelab\Socialite\OAuth\OAuth1\User;
use Vinelab\Socialite\OAuth\OAuth1\AbstractProvider;

class TwitterProvider extends AbstractProvider
{
    /**
     * The API version.
     *
     * @var string
     */
    protected $version = '1.1';

    /**
     * The base Twitter API URL.
     *
     * @var string
     */
    protected $apiUrl = 'https://api.twitter.com';

    /**
     * Create a new provider instance.
     *
     * @param  Request  $request
     * @param  Server  $server
     * @return void
     */
    public function __construct(Request $request, Server $server, $clientId, $clientSecret)
    {
        parent::__construct($request, $server);

        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
    }

    /**
     * {@inheritdoc}
     */
    public function user()
    {
        if (! $this->hasNecessaryVerifier()) {
            throw new InvalidArgumentException('Invalid request. Missing OAuth verifier.');
        }

        $user = $this->server->getUserDetails($token = $this->getToken());

        $instance = (new User)->setRaw(array_merge($user->extra, $user->urls))
                ->setToken($token->getIdentifier(), $token->getSecret());

        return $instance->map([
            'id' => $user->uid, 'nickname' => $user->nickname,
            'name' => $user->name, 'email' => $user->email, 'avatar' => $user->imageUrl,
            'avatar_original' => str_replace('_normal', '', $user->imageUrl),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function post($id)
    {
        $response = $this->getHttpClient()->get($this->getPostUrl($id), [
            'headers' => [
                'Authorization' => 'Bearer '.$this->getBearerToken(),
                'Content-Type' => 'application/x-www-form-urlencoded',
            ],
        ]);

        return json_decode($response->getBody(), true);
    }

    /**
     * {@inheritdoc}
     */
    protected function getPostUrl($id, $fields = [])
    {
        return $this->apiUrl.'/'.$this->version.'/statuses/show/'.$id.'.json';
    }

    /**
     * Get an application Bearer token.
     *
     * @return string
     */
    protected function getBearerToken()
    {
        $response = $this->getHttpClient()->post($this->getBearerTokenUrl(), [
            'query' => [
                'grant_type' => 'client_credentials',
            ],
            'headers' => [
                'Authorization' => 'Basic '.$this->getBrearerTokenCredentials(),
                'Content-Type' => 'application/x-www-form-urlencoded;charset=UTF-8',
            ],
        ]);

        return $this->parseBearerToken($response);
    }

    /**
     * Get the URL to call for fetching a bearer token.
     *
     * @return string
     */
    protected function getBearerTokenUrl()
    {
        return $this->apiUrl.'/oauth2/token';
    }

    /**
     * Parse the given Bearer token response.
     *
     * @param string $response
     *
     * @return string
     */
    protected function parseBearerToken($response)
    {
        return json_decode($response->getBody(), true)['access_token'];
    }

    /**
     * Get the credentials for a Bearer token request.
     *
     * @return string
     */
    protected function getBrearerTokenCredentials()
    {
        $key = urlencode($this->clientId);
        $secret = urlencode($this->clientSecret);

        return base64_encode(sprintf('%s:%s', $key, $secret));
    }

}
