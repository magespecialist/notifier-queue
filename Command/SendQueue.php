<?php
/**
 * Copyright © MageSpecialist - Skeeller srl. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace MSP\NotifierQueue\Command;

use Magento\Framework\ObjectManagerInterface;
use MSP\NotifierQueue\Model\SendQueueInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SendQueue extends Command
{
    /**
     * @var ObjectManagerInterface
     */
    private $objectManager;

    /**
     * SendMessage constructor.
     * @param ObjectManagerInterface $objectManager
     */
    public function __construct(
        ObjectManagerInterface $objectManager
    ) {
        parent::__construct();
        $this->objectManager = $objectManager;
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
        // @codingStandardsIgnoreStart
        // Must use object manager here
        /** @var SendQueueInterface $sendQueue */
        $sendQueue = $this->objectManager->get(SendQueueInterface::class);
        // @codingStandardsIgnoreEnd

        $sendQueue->execute();
        $output->writeln("Queue flushed");
    }
}
