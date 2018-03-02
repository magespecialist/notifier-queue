<?php
/**
 * Copyright © MageSpecialist - Skeeller srl. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace MSP\NotifierQueue\Model;

use MSP\NotifierApi\Api\IsEnabledInterface;
use MSP\NotifierQueue\Model\ResourceModel\Queue\Collection;
use MSP\NotifierQueue\Model\ResourceModel\Queue\CollectionFactory;
use MSP\NotifierQueueApi\Api\Data\QueueInterface;

class SendQueue implements SendQueueInterface
{
    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * @var SendQueuedMessageInterface
     */
    private $sendQueuedMessage;

    /**
     * @var IsEnabledInterface
     */
    private $isEnabled;

    /**
     * SendQueue constructor.
     * @param CollectionFactory $collectionFactory
     * @param SendQueuedMessageInterface $sendQueuedMessage
     * @param IsEnabledInterface $isEnabled
     */
    public function __construct(
        CollectionFactory $collectionFactory,
        SendQueuedMessageInterface $sendQueuedMessage,
        IsEnabledInterface $isEnabled
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->sendQueuedMessage = $sendQueuedMessage;
        $this->isEnabled = $isEnabled;
    }

    /**
     * Send queued messages
     */
    public function execute()
    {
        if ($this->isEnabled->execute()) {
            /** @var Collection $collection */
            $collection = $this->collectionFactory->create();
            $collection
                ->addFieldToFilter(QueueInterface::STATUS, QueueStatus::STATUS_PENDING);

            foreach ($collection as $message) {
                $this->sendQueuedMessage->execute($message->getId());
            }
        }
    }
}
