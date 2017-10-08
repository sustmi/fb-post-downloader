<?php
declare(strict_types=1);

namespace App\Command;

use App\Model\Downloader\PostDownloader;
use App\Model\Page\Page;
use App\Model\Page\PageRepository;
use App\Model\Post\Doctrine\DoctrinePostStorageFactory;
use App\Model\Post\Facebook\FacebookPostSourceFactory;
use Facebook\Exceptions\FacebookResponseException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Throwable;

class DownloadNewPostsCommand extends Command
{
    /**
     * @var PageRepository
     */
    private $pageRepository;

    /**
     * @var FacebookPostSourceFactory
     */
    private $facebookPostSourceFactory;

    /**
     * @var DoctrinePostStorageFactory
     */
    private $doctrinePostStorageFactory;

    /**
     * @var PostDownloader
     */
    private $postDownloader;

    public function __construct(
        PageRepository $pageRepository,
        FacebookPostSourceFactory $facebookPostSourceFactory,
        DoctrinePostStorageFactory $doctrinePostStorageFactory,
        PostDownloader $postDownloader
    ) {
        $this->pageRepository = $pageRepository;
        $this->facebookPostSourceFactory = $facebookPostSourceFactory;
        $this->doctrinePostStorageFactory = $doctrinePostStorageFactory;
        $this->postDownloader = $postDownloader;

        parent::__construct();
    }


    protected function configure()
    {
        $this
            ->setName('app:download-new-posts')
            ->setDescription('Downloads new posts for all pages');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $pages = $this->pageRepository->getAllPages();

        foreach ($pages as $page) {
            $output->writeln(sprintf('Downloading posts for page "%s"...', $page->getId()));

            try {
                $newPostsDownloaded = $this->downloadNewPostsForPage($page);

                $output->writeln(sprintf('Downloaded %d new posts.', $newPostsDownloaded));
            } catch (Throwable $throwable) {
                $output->writeln('Error: ' . $throwable->getMessage());
            }

            $output->write("\n");
        }
    }

    private function downloadNewPostsForPage(Page $page)
    {
        $postSource = $this->facebookPostSourceFactory->createForPage($page);
        $postStorage = $this->doctrinePostStorageFactory->createForPage($page);

        return $this->postDownloader->downloadNewPosts(
            $postSource,
            $postStorage,
            200
        );
    }
}