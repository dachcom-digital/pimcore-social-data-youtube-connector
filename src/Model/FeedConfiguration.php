<?php

namespace SocialData\Connector\Youtube\Model;

use SocialDataBundle\Connector\ConnectorFeedConfigurationInterface;
use SocialData\Connector\Youtube\Form\Admin\Type\YoutubeFeedType;

class FeedConfiguration implements ConnectorFeedConfigurationInterface
{
    /**
     * @var string
     */
    protected $fetchType;

    /**
     * @var string
     */
    protected $fetchValue;

    /**
     * @var int
     */
    protected $limit;

    /**
     * {@inheritdoc}
     */
    public static function getFormClass()
    {
        return YoutubeFeedType::class;
    }

    /**
     * @param string|null $fetchType
     */
    public function setFetchType(?string $fetchType)
    {
        $this->fetchType = $fetchType;
    }

    /**
     * @return string|null
     */
    public function getFetchType()
    {
        return $this->fetchType;
    }

    /**
     * @param string|null $fetchValue
     */
    public function setFetchValue(?string $fetchValue)
    {
        $this->fetchValue = $fetchValue;
    }

    /**
     * @return string|null
     */
    public function getFetchValue()
    {
        return $this->fetchValue;
    }

    /**
     * @param int|null $limit
     */
    public function setLimit(?int $limit)
    {
        $this->limit = $limit;
    }

    /**
     * @return int|null
     */
    public function getLimit()
    {
        return $this->limit;
    }
}
