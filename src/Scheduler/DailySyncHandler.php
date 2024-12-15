<?php

namespace App\Scheduler;

use Symfony\Component\Scheduler\Pool;
use Symfony\Component\Scheduler\RecurringTask;
use Symfony\Component\Scheduler\Task\CommandTask;
use Symfony\Contracts\Service\Attribute\Required;
use app\Command\SyncProductsCommand;

class DailySyncHandler
{
    public function __invoke(SyncProductsCommand $command)
    {

    }
}