<?php
declare(strict_types=1);

namespace App\Command;

use App\Model\Page\PageRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AddPageCommand extends Command
{
    /**
     * @var PageRepository
     */
    private $pageRepository;

    public function __construct(PageRepository $pageRepository) {
        $this->pageRepository = $pageRepository;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('app:add-page')
            ->setDescription('Add new page to the list')
            ->addArgument('pageId', InputArgument::REQUIRED, 'ID of the Facebook Page');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $pageId = $input->getArgument('pageId');

        if ($this->pageRepository->findById($pageId) !== null) {
            $this->pageRepository->addPage($pageId);
            $output->writeln(sprintf('Page "%s" added.', $pageId));
        } else {
            $output->writeln(sprintf('Page "%s" already exists.', $pageId));
        }
    }
}