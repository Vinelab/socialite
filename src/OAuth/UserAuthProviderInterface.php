<?php

namespace Vinelab\Socialite\OAuth;

interface UserAuthProviderInterface
{
    /**
     * Redirect the user to the authentication page for the provider.
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirect();

    /**
     * Get the User instance for the authenticated user.
     *
     * @return \Vinelab\Socialite\Two\User
     */
    public function user();
}
