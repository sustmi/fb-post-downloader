<?php
declare(strict_types=1);

namespace App\Model\Post\Facebook;

use App\Model\Page\Page;

use Facebook\Facebook;

class FacebookPostSourceFactory
{
    /**
     * @var string
     */
    private $appId;

    /**
     * @var string
     */
    private $appSecret;

    public function __construct(string $appId, string $appSecret)
    {
        $this->appId = $appId;
        $this->appSecret = $appSecret;
    }

    public function createForPage(Page $page): FacebookPostSource
    {
        $facebook = new Facebook([
            'app_id' => $this->appId,
            'app_secret' => $this->appSecret,
            'default_graph_version' => 'v2.10',
            'default_access_token' => $this->appId . '|' . $this->appSecret,
        ]);

        return new FacebookPostSource(
            $page->getId(),
            $facebook
        );
    }
}