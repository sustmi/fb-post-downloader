<?php
declare(strict_types=1);

namespace App\Command;

use App\Model\Downloader\PostDownloader;
use App\Model\Page\Page;
use App\Model\Page\PageRepository;
use App\Model\Post\Doctrine\DoctrineLocalPostRepositoryFactory;
use App\Model\Post\Facebook\FacebookRemotePostRepositoryFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DownloadNewPostsCommand extends Command
{
    /**
     * @var PageRepository
     */
    private $pageRepository;

    /**
     * @var FacebookRemotePostRepositoryFactory
     */
    private $facebookRemotePostRepositoryFactory;

    /**
     * @var DoctrineLocalPostRepositoryFactory
     */
    private $doctrineLocalPostRepositoryFactory;

    /**
     * @var PostDownloader
     */
    private $postDownloader;

    public function __construct(
        PageRepository $pageRepository,
        FacebookRemotePostRepositoryFactory $facebookRemotePostRepositoryFactory,
        DoctrineLocalPostRepositoryFactory $doctrineLocalPostRepositoryFactory,
        PostDownloader $postDownloader
    ) {
        $this->pageRepository = $pageRepository;
        $this->facebookRemotePostRepositoryFactory = $facebookRemotePostRepositoryFactory;
        $this->doctrineLocalPostRepositoryFactory = $doctrineLocalPostRepositoryFactory;
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

            $newPostsDownloaded = $this->downloadNewPostsForPage($page);

            $output->writeln(sprintf('Downloaded %d new posts.', $newPostsDownloaded));
        }
    }

    private function downloadNewPostsForPage(Page $page)
    {
        $remotePostRepository = $this->facebookRemotePostRepositoryFactory->createForPage($page);
        $localPostRepository = $this->doctrineLocalPostRepositoryFactory->createForPage($page);

        return $this->postDownloader->downloadNewPosts(
            $remotePostRepository,
            $localPostRepository,
            200
        );
    }
}