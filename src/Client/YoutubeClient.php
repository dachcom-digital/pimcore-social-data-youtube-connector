<?php

namespace SocialData\Connector\Youtube\Client;

use SocialData\Connector\Youtube\Model\EngineConfiguration;

class YoutubeClient
{
    /**
     * @param EngineConfiguration $configuration
     *
     * @return \Google_Client
     */
    public function getClient(EngineConfiguration $configuration)
    {
        $client = new \Google_Client();
        $client->setApplicationName('Pimcore Social Data | Youtube Connector');
        $client->setDeveloperKey($configuration->getApiKey());

        return $client;
    }
}
