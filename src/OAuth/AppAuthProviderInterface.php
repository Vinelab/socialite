<?php

namespace Vinelab\Socialite\OAuth;

interface AppAuthProviderInterface
{
    /**
     * Fetch a post from the specified social network.
     *
     * @param string $id
     *
     * @return array
     */
    public function post($id, $fields = []);
}
