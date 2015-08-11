<?php

namespace Vinelab\Socialite\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Vinelab\Socialite\SocialiteManager
 */
class Socialite extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Vinelab\Socialite\Contracts\Factory';
    }
}
