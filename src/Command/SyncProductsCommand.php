<?php

namespace App\Command;

use App\Service\ProductSyncService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(
    name: 'app:sync-products',
)]
class SyncProductsCommand extends Command
{
    protected static $defaultName = 'app:sync-products';

    private ProductSyncService $productSyncService;

    public function __construct(ProductSyncService $productSyncService)
    {
        parent::__construct();
        $this->productSyncService = $productSyncService;
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Synchronizuje produkty z externího API.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $io->title('Synchronizace produktů začne...');

        try {
            $result = $this->productSyncService->sync();
            $io->success(sprintf(
                'Synchronizace byla úspěšná! Celkem synchronizováno: %d produktů, aktualizováno: %d produktů.',
                $result['total'],
                $result['updated']
            ));
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $io->error('Došlo k chybě při synchronizaci: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}