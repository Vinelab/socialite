<?php

namespace Vinelab\Socialite\OAuth;

trait AppAuthProviderTrait
{
    /**
     * Fetch a post from the specified social network.
     *
     * @param string $id
     *
     * @return array
     */
    public function post($id)
    {
        try {
            $response = $this->getHttpClient()->get($this->getPostUrl($id), [
                'query' => $this->getPostFields()
            ]);

            return json_decode($response->getBody(), true);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            return json_decode($e->getResponse()->getBody(), true);
        }
    }

    /**
     * Get the fields that should be sent as authorization parameters.
     *
     * @return array
     */
    abstract protected function getPostFields();

    /**
     * Get the graph URL to fetch the post at the given ID.
     *
     * @param string $id
     *
     * @return string
     */
    abstract protected function getPostUrl($id);
}
