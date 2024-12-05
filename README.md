# Pimcore Social Data - YouTube Connector
[![Software License](https://img.shields.io/badge/license-GPLv3-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Software License](https://img.shields.io/badge/license-DCL-white.svg?style=flat-square&color=%23ff5c5c)](LICENSE.md)
[![Latest Release](https://img.shields.io/packagist/v/dachcom-digital/social-data-youtube-connector.svg?style=flat-square)](https://packagist.org/packages/dachcom-digital/social-data-youtube-connector)
[![Tests](https://img.shields.io/github/actions/workflow/status/dachcom-digital/pimcore-social-data-youtube-connector/.github/workflows/codeception.yml?branch=master&style=flat-square&logo=github&label=codeception)](https://github.com/dachcom-digital/pimcore-social-data-youtube-connector/actions?query=workflow%3ACodeception+branch%3Amaster)
[![PhpStan](https://img.shields.io/github/actions/workflow/status/dachcom-digital/pimcore-social-data-youtube-connector/.github/workflows/php-stan.yml?branch=master&style=flat-square&logo=github&label=phpstan%20level%204)](https://github.com/dachcom-digital/pimcore-social-data-youtube-connector/actions?query=workflow%3A"PHP+Stan"+branch%3Amaster)

This Connector allows you to fetch social posts from YouTube. 

![image](https://user-images.githubusercontent.com/700119/96834100-b52d3280-1441-11eb-9049-a2165c7f2770.png)

### Release Plan
| Release | Supported Pimcore Versions | Supported Symfony Versions | Release Date | Maintained     | Branch                                                                                   |
|---------|----------------------------|----------------------------|--------------|----------------|------------------------------------------------------------------------------------------|
| **3.x** | `11.0`                     | `6.2`                      | 07.11.2023   | Feature Branch | master                                                                                   |
| **2.x** | `10.1` - `10.6`            | `5.4`                      | 05.01.2022   | Unsupported    | [2.x](https://github.com/dachcom-digital/pimcore-social-data-youtube-connector/tree/2.x) |
| **1.x** | `6.0` - `6.9`              | `3.4`, `^4.4`              | 22.10.2020   | Unsupported    | [1.x](https://github.com/dachcom-digital/pimcore-social-data-youtube-connector/tree/1.x) |

## Installation

### I. Add Dependency
```json
"require" : {
    "dachcom-digital/social-data" : "~3.1.0",
    "dachcom-digital/social-data-youtube-connector" : "~3.1.0",
}
```

Add Bundle to `bundles.php`:
```php
return [
    SocialData\Connector\Youtube\SocialDataYoutubeConnectorBundle::class => ['all' => true],
];
```

### Install Assets
```bash
bin/console assets:install public --relative --symlink
```

## Enable Connector

```yaml
# config/packages/social_data.yaml
social_data:
    social_post_data_class: SocialPost
    available_connectors:
        -   connector_name: youtube
```

## YouTube Backoffice
Some hints to set up your YouTube app:
- Create API Key on https://console.cloud.google.com/apis/credentials
- Enable YouTube API v3: https://console.developers.google.com/apis/api/youtube.googleapis.com/overview

## Connector Configuration
![image](https://user-images.githubusercontent.com/700119/96833921-70a19700-1441-11eb-9180-5bed8e1e843f.png)

Now head back to the backend (`System` => `Social Data` => `Connector Configuration`) and checkout the YouTube tab.
- Click on `Install`
- Click on `Enable`

## Connection
YouTube is auto connected after a valid API Key has been set.

## Feed Configuration

| Name         | Description                                                                   |
|--------------|-------------------------------------------------------------------------------|
| `Fetch Type` | Choose the fetch type. Values: `Client ID` or `Playlist ID`                   |
| `Value`      | The client id or playlist id                                                  |
| `Limit`      | Define a limit to restrict the amount of social posts to import (Default: 50) |

## Third-Party Requirements
To use this connector, this bundle requires some additional packages:
- [google/apiclient](https://github.com/googleapis/google-api-php-client): Required for Google API (Mostly already installed within a PIMCORE installation)

***

## Upgrade Info
Before updating, please [check our upgrade notes!](UPGRADE.md)

## License
**DACHCOM.DIGITAL AG**, Löwenhofstrasse 15, 9424 Rheineck, Schweiz  
[dachcom.com](https://www.dachcom.com), dcdi@dachcom.ch  
Copyright © 2024 DACHCOM.DIGITAL. All rights reserved.  

For licensing details please visit [LICENSE.md](LICENSE.md)  