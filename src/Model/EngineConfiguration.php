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

use SocialData\Connector\Youtube\Form\Admin\Type\YoutubeEngineType;
use SocialDataBundle\Connector\ConnectorEngineConfigurationInterface;

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
