<?php
/**
 * Copyright © MageSpecialist - Skeeller srl. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace MSP\NotifierQueue\Command;

use MSP\NotifierQueue\Model\SendQueueInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SendQueue extends Command
{
    /**
     * @var SendQueueInterface
     */
    private $sendQueue;

    /**
     * SendMessage constructor.
     * @param SendQueueInterface $cleanQueue
     */
    public function __construct(
        SendQueueInterface $cleanQueue
    ) {
        parent::__construct();
        $this->sendQueue = $cleanQueue;
    }

    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this->setName('msp:notifier:queue:send');
        $this->setDescription('Send queued messages');

        parent::configure();
    }

    /**
     * @inheritdoc
     * @SuppressWarnings("PHPMD.UnusedFormalParameter")
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->sendQueue->execute();
        $output->writeln("Queue flushed");
    }
}
