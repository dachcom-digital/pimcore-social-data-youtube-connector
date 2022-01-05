<?php

namespace SocialData\Connector\Youtube\Model;

use SocialDataBundle\Connector\ConnectorEngineConfigurationInterface;
use SocialData\Connector\Youtube\Form\Admin\Type\YoutubeEngineType;

class EngineConfiguration implements ConnectorEngineConfigurationInterface
{
    protected ?string $apiKey = null;

    public static function getFormClass(): string
    {
        return YoutubeEngineType::class;
    }

    public function setApiKey(string $apiKey): void
    {
        $this->apiKey = $apiKey;
    }

    public function getApiKey(): ?string
    {
        return $this->apiKey;
    }
}
