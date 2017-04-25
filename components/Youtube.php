<?php

namespace app\components;

use Google_Client;
use Google_Service_YouTube;
use Google_Service_YouTube_ResourceId;
use Google_Service_YouTube_SearchListResponse;
use Google_Service_YouTube_SearchResult;
use Google_Service_YouTube_VideoSnippet;
use yii;

class Youtube extends yii\base\Component {

    public $apiKey;

    private $service;

    public function init() {
        parent::init();

        $client = new Google_Client();
        $client->setDeveloperKey($this->apiKey);

        $this->service = new Google_Service_YouTube($client);
    }

    public function searchVideo($q, $maxResults=10) {
        /** @var Google_Service_YouTube_SearchListResponse $data */
        $data = $this->service->search->listSearch('id,snippet',
            array(
            'q' => $q,
            'maxResults' => $maxResults,
            )
        );
        $result = array();
        $items = $data->getItems();
        foreach ($items as $item) {
            /** @var Google_Service_YouTube_SearchResult $item */
            /** @var Google_Service_YouTube_ResourceId $video */
            /** @var Google_Service_YouTube_VideoSnippet $snippet */
            $video = $item->getId();
            $snippet = $item->getSnippet();
            if ($video->getKind() == 'youtube#video') {
                $result[] = array('id' => $video->getVideoId(), 'title' => $snippet->getTitle());
            }
        }

        return $result;
    }

}
