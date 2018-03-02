<?php
/**
 * Copyright © MageSpecialist - Skeeller srl. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace MSP\NotifierQueue\Model;

use Magento\Framework\Stdlib\DateTime\DateTime;
use MSP\NotifierApi\Api\AdapterRepositoryInterface;
use MSP\NotifierApi\Api\ChannelRepositoryInterface;
use MSP\NotifierQueueApi\Api\Data\QueueInterface;
use MSP\NotifierQueueApi\Api\Data\QueueInterfaceFactory;
use MSP\NotifierQueueApi\Api\QueueRepositoryInterface;

class EnqueueMessage implements EnqueueMessageInterface
{
    /**
     * @var QueueRepositoryInterface
     */
    private $queueRepository;

    /**
     * @var QueueInterfaceFactory
     */
    private $queueInterfaceFactory;

    /**
     * @var ChannelRepositoryInterface
     */
    private $channelRepository;

    /**
     * @var DateTime
     */
    private $dateTime;

    /**
     * @var SendQueuedMessageInterface
     */
    private $sendQueuedMessage;

    /**
     * @var AdapterRepositoryInterface
     */
    private $adapterRepository;

    /**
     * EnqueueMessage constructor.
     * @param ChannelRepositoryInterface $channelRepository
     * @param QueueRepositoryInterface $queueRepository
     * @param SendQueuedMessageInterface $sendQueuedMessage
     * @param QueueInterfaceFactory $queueInterfaceFactory
     * @param AdapterRepositoryInterface $adapterRepository
     * @param DateTime $dateTime
     * @SuppressWarnings(PHPMD.LongVariables)
     */
    public function __construct(
        ChannelRepositoryInterface $channelRepository,
        QueueRepositoryInterface $queueRepository,
        SendQueuedMessageInterface $sendQueuedMessage,
        QueueInterfaceFactory $queueInterfaceFactory,
        AdapterRepositoryInterface $adapterRepository,
        DateTime $dateTime
    ) {
        $this->queueRepository = $queueRepository;
        $this->queueInterfaceFactory = $queueInterfaceFactory;
        $this->channelRepository = $channelRepository;
        $this->dateTime = $dateTime;
        $this->sendQueuedMessage = $sendQueuedMessage;
        $this->adapterRepository = $adapterRepository;
    }

    /**
     * @inheritdoc
     */
    public function execute(string $channelCode, string $message): int
    {
        /** @var QueueInterface $queue */
        $queue = $this->queueInterfaceFactory->create();
        $channel = $this->channelRepository->getByCode($channelCode);

        $adapter = $this->adapterRepository->getAdapterByCode($channel->getAdapterCode());
        $adapter->validateMessage($message);

        $queue->setSendTrials(0);
        $queue->setChannelCode($channel->getCode());
        $queue->setCreatedAt($this->dateTime->date());
        $queue->setMessage($message);
        $queue->setStatus(QueueStatus::STATUS_PENDING);

        $queueId = $this->queueRepository->save($queue);

        // Immediately send message
        // We queue it anyway to use retries in case in failure
        if ($channel->getExtensionAttributes()->getImmediateSend()) {
            $this->sendQueuedMessage->execute($queueId);
        }

        return $queueId;
    }
}
