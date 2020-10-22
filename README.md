# Pimcore Social Data - Youtube Connector

This Connector allows you to fetch social posts from Youtube. 
Before you start be sure you've checked out the [Setup Instructions](../00_Setup.md).

![image](https://user-images.githubusercontent.com/700119/96834100-b52d3280-1441-11eb-9049-a2165c7f2770.png)


#### Requirements
* [Pimcore Social Data Bundle](https://github.com/dachcom-digital/pimcore-social-data)

## Installation

### I. Add Dependency
```json
"require" : {
    "dachcom-digital/social-data-youtube-connector" : "~1.0.0",
}
```

### II. Register Connector Bundle
```php
// src/AppKernel.php
use Pimcore\Kernel;
use Pimcore\HttpKernel\BundleCollection\BundleCollection;

class AppKernel extends Kernel
{
    public function registerBundlesToCollection(BundleCollection $collection)
    {
        $collection->addBundle(new SocialData\Connector\Youtube\SocialDataYoutubeConnectorBundle());
    }
}
```

### III. Install Assets
```bash
bin/console assets:install web --relative --symlink
```

## Third-Party Requirements
To use this connector, this bundle requires some additional packages:
- [google/apiclient](https://github.com/googleapis/google-api-php-client): Required for Google API (Mostly already installed within a Pimcore Installation)

## Enable Connector

```yaml
# app/config/config.yml
social_data:
    social_post_data_class: SocialPost
    available_connectors:
        -   connector_name: youtube
```

## Connector Configuration
![image](https://user-images.githubusercontent.com/700119/96833921-70a19700-1441-11eb-9180-5bed8e1e843f.png)

Now head back to the backend (`System` => `Social Data` => `Connector Configuration`) and checkout the youtube tab.
- Click on `Install`
- Click on `Enable`
- Fill out the

This will guide you through the youtube token generation. 
After hitting the "Connect" button, a popup will open to guide you through youtube authentication process. 
If everything worked out fine, the connection setup is complete after the popup closes.
Otherwise, you'll receive an error message. You may then need to repeat the connection step.

## Feed Configuration

| Name | Description
|------|----------------------|
| `Fetch Type` | Choose the fetch type. Values: `Client ID` or `Playlist ID` |
| `Value` | The client id or playlist id |
| `Limit` | Define a limit to restrict the amount of social posts to import (Default: 50) |

***

## Copyright and license
Copyright: [DACHCOM.DIGITAL](http://dachcom-digital.ch)  
For licensing details please visit [LICENSE.md](LICENSE.md)  

## Upgrade Info
Before updating, please [check our upgrade notes!](UPGRADE.md)
