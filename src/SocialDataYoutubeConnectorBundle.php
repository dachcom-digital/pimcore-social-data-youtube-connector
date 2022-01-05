<?php

namespace SocialData\Connector\Youtube;

use Pimcore\Extension\Bundle\AbstractPimcoreBundle;
use Pimcore\Extension\Bundle\Traits\PackageVersionTrait;

class SocialDataYoutubeConnectorBundle extends AbstractPimcoreBundle
{
    use PackageVersionTrait;

    public const PACKAGE_NAME = 'dachcom-digital/social-data-youtube-connector';

    protected function getComposerPackageName(): string
    {
        return self::PACKAGE_NAME;
    }

    public function getCssPaths(): array
    {
        return [
            '/bundles/socialdatayoutubeconnector/css/admin.css'
        ];
    }

    public function getJsPaths(): array
    {
        return [
            '/bundles/socialdatayoutubeconnector/js/connector/youtube-connector.js',
            '/bundles/socialdatayoutubeconnector/js/feed/youtube-feed.js',
        ];
    }
}
