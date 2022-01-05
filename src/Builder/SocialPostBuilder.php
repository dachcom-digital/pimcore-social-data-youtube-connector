<?php

namespace SocialData\Connector\Youtube\Builder;

use Carbon\Carbon;
use SocialData\Connector\Youtube\Client\YoutubeClient;
use SocialDataBundle\Dto\BuildConfig;
use SocialData\Connector\Youtube\Model\EngineConfiguration;
use SocialData\Connector\Youtube\Model\FeedConfiguration;
use SocialDataBundle\Connector\SocialPostBuilderInterface;
use SocialDataBundle\Dto\FetchData;
use SocialDataBundle\Dto\FilterData;
use SocialDataBundle\Dto\TransformData;
use SocialDataBundle\Exception\BuildException;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SocialPostBuilder implements SocialPostBuilderInterface
{
    protected YoutubeClient $youtubeClient;

    public function __construct(YoutubeClient $youtubeClient)
    {
        $this->youtubeClient = $youtubeClient;
    }

    public function configureFetch(BuildConfig $buildConfig, OptionsResolver $resolver): void
    {
        // nothing to configure so far.
    }

    public function fetch(FetchData $data): void
    {
        $options = $data->getOptions();
        $buildConfig = $data->getBuildConfig();

        $engineConfiguration = $buildConfig->getEngineConfiguration();
        $feedConfiguration = $buildConfig->getFeedConfiguration();

        if (!$engineConfiguration instanceof EngineConfiguration) {
            return;
        }

        if (!$feedConfiguration instanceof FeedConfiguration) {
            return;
        }

        $fetchType = $feedConfiguration->getFetchType();

        if (empty($fetchType) || !in_array($fetchType, ['channel', 'playlist'])) {
            throw new BuildException(sprintf('Invalid or empty fetch type "%s"', $fetchType));
        }

        $limit = is_numeric($feedConfiguration->getLimit()) ? $feedConfiguration->getLimit() : 1;

        $client = $this->youtubeClient->getClient($engineConfiguration);

        $items = [];
        if ($fetchType === 'channel') {
            $items = $this->getChannelItems($client, $feedConfiguration->getFetchValue(), $limit);
        } elseif ($fetchType === 'playlist') {
            $items = $this->getPlaylistItems($client, $feedConfiguration->getFetchValue(), $limit);
        }

        if (count($items) === 0) {
            return;
        }

        if (count($items) > $limit) {
            $items = array_slice($items, 0, $limit);
        }

        $data->setFetchedEntities($items);
    }

    public function configureFilter(BuildConfig $buildConfig, OptionsResolver $resolver): void
    {
        // nothing to configure so far.
    }

    public function filter(FilterData $data): void
    {
        $element = $data->getTransferredData();

        if (!is_array($element)) {
            return;
        }

        if (empty($element['id'])) {
            return;
        }

        // @todo: check if feed has some filter (filter for hashtag for example)

        $data->setFilteredElement($element);
        $data->setFilteredId($element['id']);
    }

    public function configureTransform(BuildConfig $buildConfig, OptionsResolver $resolver): void
    {
        // nothing to configure so far.
    }

    public function transform(TransformData $data): void
    {
        $element = $data->getTransferredData();
        $socialPost = $data->getSocialPostEntity();

        if (!is_array($element)) {
            return;
        }

        if (is_string($element['publishedAt'])) {
            $creationTime = Carbon::createFromFormat('Y-m-d\TH:i:sP', $element['publishedAt']);
        } else {
            $creationTime = Carbon::now();
        }

        $socialPost->setSocialCreationDate($creationTime);
        $socialPost->setTitle($element['title']);
        $socialPost->setContent($element['description']);
        $socialPost->setUrl($element['url']);
        $socialPost->setMediaUrl($element['url']);

        if (is_string($element['thumbnail'])) {
            $socialPost->setPosterUrl($element['thumbnail']);
        }

        $data->setTransformedElement($socialPost);
    }

    /**
     * @throws BuildException
     */
    protected function getChannelItems(\Google_Client $client, string $channelId, int $limit): array
    {
        $items = [];
        $service = new \Google_Service_YouTube($client);

        $params = [
            'channelId'  => $channelId,
            'maxResults' => $limit > 50 ? 50 : $limit,
            'order'      => 'date',
            'type'       => 'video'
        ];

        $nextPageToken = 'INIT';
        while (!empty($nextPageToken)) {

            if ($nextPageToken !== 'INIT') {
                $params['pageToken'] = $nextPageToken;
            }

            try {
                $response = $service->search->listSearch('snippet', $params);
            } catch (\Google_Service_Exception $e) {
                throw new BuildException(sprintf('fetch google service error: %s [endpoint: %s]', implode(', ', array_map(static function ($e) {
                    return $e['message'];
                }, $e->getErrors())), 'listSearch'));
            } catch (\Throwable $e) {
                throw new BuildException(sprintf('fetch error: %s [endpoint: %s]', $e->getMessage(), 'listPlaylistItems'));
            }

            if (!$response instanceof \Google_Service_YouTube_SearchListResponse) {
                break;
            }

            $items = array_merge($items, $response->getItems());
            $nextPageToken = $response->getNextPageToken();

            if (count($items) >= $limit) {
                break;
            }
        }

        if (!is_array($items)) {
            return [];
        }

        $parsedItems = [];

        /** @var \Google_Service_YouTube_SearchResult $item */
        foreach ($items as $item) {

            $resource = $item->getId();
            $snippet = $item->getSnippet();

            $thumbnail = null;
            $maxResThumbnail = $this->getThumbnail($snippet->getThumbnails());
            if ($maxResThumbnail instanceof \Google_Service_YouTube_Thumbnail) {
                $thumbnail = $maxResThumbnail->getUrl();
            }

            $parsedItems[] = [
                'id'          => $resource->getVideoId(),
                'title'       => $snippet->getTitle(),
                'description' => $snippet->getDescription(),
                'publishedAt' => $snippet->getPublishedAt(),
                'url'         => sprintf('https://youtu.be/%s', $resource->getVideoId()),
                'thumbnail'   => $thumbnail
            ];
        }

        return $parsedItems;
    }

    /**
     * @throws BuildException
     */
    protected function getPlaylistItems(\Google_Client $client, string $playlistId, int $limit): array
    {
        $items = [];
        $service = new \Google_Service_YouTube($client);

        $params = [
            'playlistId' => $playlistId,
            'maxResults' => $limit > 50 ? 50 : $limit
        ];

        $nextPageToken = 'INIT';
        while (!empty($nextPageToken)) {

            if ($nextPageToken !== 'INIT') {
                $params['pageToken'] = $nextPageToken;
            }

            try {
                $response = $service->playlistItems->listPlaylistItems('snippet', $params);
            } catch (\Google_Service_Exception $e) {
                throw new BuildException(sprintf('fetch google service error: %s [endpoint: %s]', implode(', ', array_map(static function ($e) {
                    return $e['message'];
                }, $e->getErrors())), 'listPlaylistItems'));
            } catch (\Throwable $e) {
                throw new BuildException(sprintf('fetch error: %s [endpoint: %s]', $e->getMessage(), 'listPlaylistItems'));
            }

            if (!$response instanceof \Google_Service_YouTube_PlaylistItemListResponse) {
                break;
            }

            $items = array_merge($items, $response->getItems());
            $nextPageToken = $response->getNextPageToken();

            if (count($items) >= $limit) {
                break;
            }
        }

        if (!is_array($items)) {
            return [];
        }

        $parsedItems = [];

        /** @var \Google_Service_YouTube_PlaylistItem $item */
        foreach ($items as $item) {

            $snippet = $item->getSnippet();

            $thumbnail = null;
            $maxResThumbnail = $this->getThumbnail($snippet->getThumbnails());
            if ($maxResThumbnail instanceof \Google_Service_YouTube_Thumbnail) {
                $thumbnail = $maxResThumbnail->getUrl();
            }

            $parsedItems[] = [
                'id'          => $snippet->getResourceId()->getVideoId(),
                'title'       => $snippet->getTitle(),
                'description' => $snippet->getDescription(),
                'publishedAt' => $snippet->getPublishedAt(),
                'url'         => sprintf('https://youtu.be/%s', $snippet->getResourceId()->getVideoId()),
                'thumbnail'   => $thumbnail
            ];
        }

        return $parsedItems;
    }

    protected function getThumbnail(\Google_Service_YouTube_ThumbnailDetails $thumbnailDetails): ?\Google_Service_YouTube_Thumbnail
    {
        if ($thumbnailDetails->getMaxres() !== null) {
            return $thumbnailDetails->getMaxres();
        }

        if ($thumbnailDetails->getHigh() !== null) {
            return $thumbnailDetails->getHigh();
        }

        if ($thumbnailDetails->getMedium() !== null) {
            return $thumbnailDetails->getMedium();
        }

        if ($thumbnailDetails->getStandard() !== null) {
            return $thumbnailDetails->getStandard();
        }

        return $thumbnailDetails->getDefault();
    }

}
