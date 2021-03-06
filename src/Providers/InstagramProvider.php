<?php

namespace Vinelab\Socialite\Providers;

use Vinelab\Socialite\OAuth\AppAuthProviderTrait;
use Vinelab\Socialite\OAuth\OAuth2\AbstractProvider;
use Vinelab\Socialite\OAuth\AppAuthProviderInterface;

class InstagramProvider extends AbstractProvider implements AppAuthProviderInterface
{
    use AppAuthProviderTrait;

    /**
     * The API version.
     *
     * @var string
     */
    protected $version = 'v1';

    /**
     * The API's URL.
     *
     * @var string
     */
    protected $apiUrl = 'https://api.instagram.com';

    /**
     * {@inheritdoc}
     */
    protected function getPostUrl($url, $fields = [])
    {
        return $this->apiUrl.'/oembed?url='.$url;
    }

    /**
     * {@inheritdoc}
     */
    protected function getPostFields()
    {
        return [];
    }
}
