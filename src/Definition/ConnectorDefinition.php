<?php

namespace SocialData\Connector\Youtube\Definition;

use SocialData\Connector\Youtube\Model\EngineConfiguration;
use SocialData\Connector\Youtube\Model\FeedConfiguration;
use SocialDataBundle\Connector\ConnectorEngineConfigurationInterface;
use SocialDataBundle\Connector\ConnectorDefinitionInterface;
use SocialDataBundle\Connector\SocialPostBuilderInterface;
use SocialDataBundle\Model\ConnectorEngineInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConnectorDefinition implements ConnectorDefinitionInterface
{
    /**
     * @var ConnectorEngineInterface|null
     */
    protected $connectorEngine;

    /**
     * @var SocialPostBuilderInterface
     */
    protected $socialPostBuilder;

    /**
     * @var array
     */
    protected $definitionConfiguration;

    /**
     * {@inheritdoc}
     */
    public function setConnectorEngine(?ConnectorEngineInterface $connectorEngine)
    {
        $this->connectorEngine = $connectorEngine;
    }

    /**
     * {@inheritdoc}
     */
    public function getConnectorEngine()
    {
        return $this->connectorEngine;
    }

    /**
     * {@inheritdoc}
     */
    public function setSocialPostBuilder(SocialPostBuilderInterface $builder)
    {
        $this->socialPostBuilder = $builder;
    }

    /**
     * {@inheritdoc}
     */
    public function getSocialPostBuilder()
    {
        return $this->socialPostBuilder;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefinitionConfiguration(array $definitionConfiguration)
    {
        $resolver = new OptionsResolver();
        $resolver->setDefaults([
            'api_connect_permission' => [
                //LinkedInSDK::R_LITEPROFILE,
                //LinkedInSDK::R_EMAILADDRESS,
                //LinkedInSDK::R_ORGANIZATION_SOCIAL,
            ]
        ]);

        $resolver->setAllowedTypes('api_connect_permission', 'string[]');

        try {
            $this->definitionConfiguration = $resolver->resolve($definitionConfiguration);
        } catch (\Throwable $e) {
            throw new \Exception(sprintf('Invalid "%s" connector configuration. %s', 'youtube', $e->getMessage()));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getDefinitionConfiguration()
    {
        return $this->definitionConfiguration;
    }

    /**
     * {@inheritdoc}
     */
    public function engineIsLoaded()
    {
        return $this->getConnectorEngine() instanceof ConnectorEngineInterface;
    }

    /**
     * {@inheritdoc}
     */
    public function isOnline()
    {
        if (!$this->engineIsLoaded()) {
            return false;
        }

        if ($this->getConnectorEngine()->isEnabled() === false) {
            return false;
        }

        if (!$this->isConnected()) {
            return false;
        }

        $configuration = $this->getConnectorEngine()->getConfiguration();
        if (!$configuration instanceof ConnectorEngineConfigurationInterface) {
            return false;
        }

        return $this->isConnected();
    }

    /**
     * {@inheritdoc}
     */
    public function beforeEnable()
    {
        // not required. just enable it.
    }

    /**
     * {@inheritdoc}
     */
    public function beforeDisable()
    {
        // not required. just disable it.
    }

    /**
     * {@inheritdoc}
     */
    public function isAutoConnected()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isConnected()
    {
        if ($this->engineIsLoaded() === false) {
            return false;
        }

        $configuration = $this->getConnectorEngine()->getConfiguration();
        if (!$configuration instanceof EngineConfiguration) {
            return false;
        }

        return $configuration->getApiKey() !== null;
    }

    /**
     * {@inheritdoc}
     */
    public function connect()
    {
        if ($this->isConnected() === false) {
            throw new \Exception('No valid API Key found. If you already tried to connect your application check your credentials again.');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function disconnect()
    {
        // @todo
    }

    /**
     * {@inheritdoc}
     */
    public function needsEngineConfiguration()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function getEngineConfigurationClass()
    {
        return EngineConfiguration::class;
    }

    /**
     * {@inheritdoc}
     */
    public function getFeedConfigurationClass()
    {
        return FeedConfiguration::class;
    }

    /**
     * {@inheritdoc}
     */
    public function getEngineConfiguration()
    {
        if (!$this->engineIsLoaded()) {
            return null;
        }

        $engineConfiguration = $this->getConnectorEngine()->getConfiguration();
        if (!$engineConfiguration instanceof ConnectorEngineConfigurationInterface) {
            return null;
        }

        return $engineConfiguration;
    }
}
