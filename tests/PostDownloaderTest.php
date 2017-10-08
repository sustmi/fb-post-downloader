<?php
declare(strict_types=1);

namespace App\Tests;

use App\Model\Downloader\PostDownloader;
use App\Model\Post\Post;
use DateTime;
use PHPUnit\Framework\TestCase;

class PostDownloaderTest extends TestCase
{
    public function testReturnsNumberOfDownloadedPosts()
    {
        $remotePosts = [
            new Post('101', new DateTime('2017-01-01 11:00:00')),
            new Post('102', new DateTime('2017-01-01 12:00:00')),
            new Post('103', new DateTime('2017-01-01 13:00:00')),
        ];

        $remotePostRepository = new TestRemoteRepository($remotePosts);
        $postStorage = new TestPostStorage([]);

        $postDownloader = new PostDownloader();
        $downloadedPostsCount = $postDownloader->downloadNewPosts(
            $remotePostRepository,
            $postStorage,
            10
        );

        $this->assertEquals(count($remotePosts), $downloadedPostsCount);
    }

    public function testLimitsNumberOfDownloadedPosts()
    {
        $remotePosts = [
            new Post('101', new DateTime('2017-01-01 11:00:00')),
            new Post('102', new DateTime('2017-01-01 12:00:00')),
            new Post('103', new DateTime('2017-01-01 13:00:00')),
        ];

        $remotePostRepository = new TestRemoteRepository($remotePosts);
        $postStorage = new TestPostStorage([]);

        $postDownloader = new PostDownloader();
        $postDownloader->downloadNewPosts(
            $remotePostRepository,
            $postStorage,
            2
        );

        $this->assertCount(2, $postStorage->getPosts());
    }

    public function testDownloadsOnlyNewPosts()
    {
        $remotePosts = [
            new Post('101', new DateTime('2017-01-01 11:00:00')),
            new Post('102', new DateTime('2017-01-01 12:00:00')),
            new Post('103', new DateTime('2017-01-01 13:00:00')),
            new Post('104', new DateTime('2017-01-01 14:00:00')),
            new Post('105', new DateTime('2017-01-01 15:00:00')),
        ];

        $localPosts = [
            new Post('200', new DateTime('2017-01-01 12:30:00')),
        ];

        $remotePostRepository = new TestRemoteRepository($remotePosts);
        $postStorage = new TestPostStorage($localPosts);

        $postDownloader = new PostDownloader();
        $postDownloader->downloadNewPosts(
            $remotePostRepository,
            $postStorage,
            10
        );

        $this->assertEquals(
            ['200', '103', '104', '105'],
            array_map(
                function (Post $post) {
                    return $post->getId();
                },
                $postStorage->getPosts()
            )
        );
    }
}
