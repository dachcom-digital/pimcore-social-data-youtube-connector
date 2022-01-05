<?php

namespace SocialData\Connector\Youtube\Client;

use SocialData\Connector\Youtube\Model\EngineConfiguration;

class YoutubeClient
{
    public function getClient(EngineConfiguration $configuration): \Google_Client
    {
        $client = new \Google_Client();
        $client->setApplicationName('Pimcore Social Data | Youtube Connector');
        $client->setDeveloperKey($configuration->getApiKey());

        return $client;
    }
}
