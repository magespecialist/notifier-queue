<?php
/**
 * Copyright © MageSpecialist - Skeeller srl. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace MSP\NotifierQueue\Command;

use MSP\NotifierQueueApi\Api\QueueRepositoryInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CleanQueue extends Command
{
    /**
     * @var QueueRepositoryInterface
     */
    private $queueRepository;

    /**
     * SendMessage constructor.
     * @param QueueRepositoryInterface $queueRepository
     */
    public function __construct(
        QueueRepositoryInterface $queueRepository
    ) {
        parent::__construct();
        $this->queueRepository = $queueRepository;
    }

    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this->setName('msp:notifier:queue:clean');
        $this->setDescription('Clean queue from old messages');

        parent::configure();
    }

    /**
     * @inheritdoc
     * @SuppressWarnings("PHPMD.UnusedFormalParameter")
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->queueRepository->clear();
        $output->writeln("Queue cleaned from old messages");
    }
}
