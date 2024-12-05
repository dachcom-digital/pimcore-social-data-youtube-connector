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
