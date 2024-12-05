<?php

/*
 * This source file is available under two different licenses:
 *   - GNU General Public License version 3 (GPLv3)
 *   - DACHCOM Commercial License (DCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 * @copyright  Copyright (c) DACHCOM.DIGITAL AG (https://www.dachcom-digital.com)
 * @license    GPLv3 and DCL
 */

namespace SocialData\Connector\Youtube\Model;

use SocialData\Connector\Youtube\Form\Admin\Type\YoutubeFeedType;
use SocialDataBundle\Connector\ConnectorFeedConfigurationInterface;

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
