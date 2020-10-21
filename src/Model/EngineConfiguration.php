<?php

namespace SocialData\Connector\Youtube\Model;

use SocialDataBundle\Connector\ConnectorEngineConfigurationInterface;
use SocialData\Connector\Youtube\Form\Admin\Type\YoutubeEngineType;

class EngineConfiguration implements ConnectorEngineConfigurationInterface
{
    /**
     * @var string
     */
    protected $apiKey;

    /**
     * {@inheritdoc}
     */
    public static function getFormClass()
    {
        return YoutubeEngineType::class;
    }

    /**
     * @param string $apiKey
     */
    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * @return string
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }
}
