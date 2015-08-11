<?php

namespace Vinelab\Socialite\Contracts;

interface Factory
{
    /**
     * Get an OAuth provider implementation.
     *
     * @param  string  $driver
     * @return \Vinelab\Socialite\Contracts\Provider
     */
    public function driver($driver = null);
}
