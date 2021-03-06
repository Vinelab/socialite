<?php

namespace Vinelab\Socialite;

use InvalidArgumentException;
use Illuminate\Support\Manager;
use Vinelab\Socialite\Providers\GoogleProvider;
use Vinelab\Socialite\Providers\GithubProvider;
use Vinelab\Socialite\Providers\TwitterProvider;
use Vinelab\Socialite\Providers\LinkedInProvider;
use Vinelab\Socialite\Providers\FacebookProvider;
use Vinelab\Socialite\Providers\BitbucketProvider;
use Vinelab\Socialite\Providers\InstagramProvider;
use League\OAuth1\Client\Server\Twitter as TwitterServer;
use League\OAuth1\Client\Server\Bitbucket as BitbucketServer;

class SocialiteManager extends Manager implements Contracts\Factory
{
    /**
     * Get a driver instance.
     *
     * @param  string  $driver
     * @return mixed
     */
    public function with($driver)
    {
        return $this->driver($driver);
    }

    /**
     * Create an instance of the specified driver.
     *
     * @return \Vinelab\Socialite\OAuth\OAuth2\AbstractProvider
     */
    protected function createInstagramDriver()
    {
        $config = $this->app['config']['services.instagram'];

        return $this->buildProvider(
            InstagramProvider::class, $config
        );
    }

    /**
     * Create an instance of the specified driver.
     *
     * @return \Vinelab\Socialite\OAuth\OAuth2\AbstractProvider
     */
    protected function createGithubDriver()
    {
        $config = $this->app['config']['services.github'];

        return $this->buildProvider(
            GithubProvider::class, $config
        );
    }

    /**
     * Create an instance of the specified driver.
     *
     * @return \Vinelab\Socialite\OAuth\OAuth2\AbstractProvider
     */
    protected function createFacebookDriver()
    {
        $config = $this->app['config']['services.facebook'];

        return $this->buildProvider(
            FacebookProvider::class, $config
        );
    }

    /**
     * Create an instance of the specified driver.
     *
     * @return \Vinelab\Socialite\OAuth\OAuth2\AbstractProvider
     */
    protected function createGoogleDriver()
    {
        $config = $this->app['config']['services.google'];

        return $this->buildProvider(
            GoogleProvider::class, $config
        );
    }

    /**
     * Create an instance of the specified driver.
     *
     * @return \Vinelab\Socialite\OAuth\OAuth2\AbstractProvider
     */
    protected function createLinkedinDriver()
    {
        $config = $this->app['config']['services.linkedin'];

        return $this->buildProvider(
          LinkedInProvider::class, $config
        );
    }

    /**
     * Build an OAuth 2 provider instance.
     *
     * @param  string  $provider
     * @param  array  $config
     * @return \Vinelab\Socialite\OAuth\OAuth2\AbstractProvider
     */
    public function buildProvider($provider, $config)
    {
        return new $provider(
            $this->app['request'], $config['client_id'],
            $config['client_secret'], $config['redirect']
        );
    }

    /**
     * Create an instance of the specified driver.
     *
     * @return \Vinelab\Socialite\OAuth\OAuth1\AbstractProvider
     */
    protected function createTwitterDriver()
    {
        $config = $this->app['config']['services.twitter'];

        return new TwitterProvider(
            $this->app['request'], new TwitterServer($this->formatConfig($config)),
            $config['client_id'], $config['client_secret']
        );
    }

    /**
     * Create an instance of the specified driver.
     *
     * @return \Vinelab\Socialite\OAuth\OAuth1\AbstractProvider
     */
    protected function createBitbucketDriver()
    {
        $config = $this->app['config']['services.bitbucket'];

        return new BitbucketProvider(
            $this->app['request'], new BitbucketServer($this->formatConfig($config))
        );
    }

    /**
     * Format the Twitter server configuration.
     *
     * @param  array  $config
     * @return array
     */
    public function formatConfig(array $config)
    {
        return [
            'identifier' => $config['client_id'],
            'secret' => $config['client_secret'],
            'callback_uri' => $config['redirect'],
        ];
    }

    /**
     * Get the default driver name.
     *
     * @throws \InvalidArgumentException
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        throw new InvalidArgumentException('No Socialite driver was specified.');
    }
}
