<?php

namespace SocialData\Connector\Youtube\Model;

use SocialDataBundle\Connector\ConnectorFeedConfigurationInterface;
use SocialData\Connector\Youtube\Form\Admin\Type\YoutubeFeedType;

class FeedConfiguration implements ConnectorFeedConfigurationInterface
{
    protected ?string $fetchType = null;
    protected ?string $fetchValue = null;
    protected ?int $limit = null;

    public static function getFormClass(): string
    {
        return YoutubeFeedType::class;
    }

    public function setFetchType(?string $fetchType): void
    {
        $this->fetchType = $fetchType;
    }

    public function getFetchType(): ?string
    {
        return $this->fetchType;
    }

    public function setFetchValue(?string $fetchValue): void
    {
        $this->fetchValue = $fetchValue;
    }

    public function getFetchValue(): ?string
    {
        return $this->fetchValue;
    }

    public function setLimit(?int $limit): void
    {
        $this->limit = $limit;
    }

    public function getLimit(): ?int
    {
        return $this->limit;
    }
}
