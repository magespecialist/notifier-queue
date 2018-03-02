<?php
/**
 * Copyright © MageSpecialist - Skeeller srl. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace MSP\NotifierQueue\Model;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Stdlib\DateTime\DateTime;
use MSP\NotifierApi\Api\ChannelRepositoryInterface;
use MSP\NotifierApi\Api\SendMessageInterface;
use MSP\NotifierQueueApi\Api\Data\QueueInterface;
use MSP\NotifierQueueApi\Api\QueueRepositoryInterface;

class SendQueuedMessage implements SendQueuedMessageInterface
{
    /**
     * @var QueueRepositoryInterface
     */
    private $queueRepository;

    /**
     * @var QueueBypass
     */
    private $queueBypass;

    /**
     * @var SendMessageInterface
     */
    private $sendMessage;

    /**
     * @var DateTime
     */
    private $dateTime;

    /**
     * @var ChannelRepositoryInterface
     */
    private $channelRepository;

    /**
     * SendQueuedMessage constructor.
     * @param QueueRepositoryInterface $queueRepository
     * @param ChannelRepositoryInterface $channelRepository
     * @param SendMessageInterface $sendMessage
     * @param QueueBypass $queueBypass
     * @param DateTime $dateTime
     */
    public function __construct(
        QueueRepositoryInterface $queueRepository,
        ChannelRepositoryInterface $channelRepository,
        SendMessageInterface $sendMessage,
        QueueBypass $queueBypass,
        DateTime $dateTime
    ) {
        $this->queueRepository = $queueRepository;
        $this->queueBypass = $queueBypass;
        $this->sendMessage = $sendMessage;
        $this->dateTime = $dateTime;
        $this->channelRepository = $channelRepository;
    }

    /**
     * Handle successful send
     * @param QueueInterface $queuedMessage
     */
    private function handleSuccess(QueueInterface $queuedMessage)
    {
        $queuedMessage->setStatus(QueueStatus::STATUS_SUCCESS);
        $queuedMessage->setSentAt($this->dateTime->date());
    }

    /**
     * Handle failed send
     * @param QueueInterface $queuedMessage
     */
    private function handleFailure(QueueInterface $queuedMessage)
    {
        try {
            $channel = $this->channelRepository->getByCode($queuedMessage->getChannelCode());

            $createdAtTs = $this->dateTime->timestamp($queuedMessage->getCreatedAt());
            $retryForSeconds = $channel->getExtensionAttributes()->getRetryFor() * 60;

            $stopSendingTs = $createdAtTs + $retryForSeconds;

            if ($stopSendingTs < $this->dateTime->timestamp()) {
                $queuedMessage->setStatus(QueueStatus::STATUS_FAILURE);
            } else {
                $queuedMessage->setStatus(QueueStatus::STATUS_PENDING);
            }
        } catch (NoSuchEntityException $e) {
            $queuedMessage->setStatus(QueueStatus::STATUS_FAILURE);
        }
    }

    /**
     * @inheritdoc
     */
    public function execute(int $queueId): bool
    {
        $queuedMessage = $this->queueRepository->get($queueId);
        if ((int) $queuedMessage->getStatus() !== QueueStatus::STATUS_PENDING) {
            return false;
        }

        $this->queueBypass->setStatus(true);
        $queuedMessage->setSendTrials($queuedMessage->getSendTrials() + 1);

        try {
            $this->sendMessage->execute($queuedMessage->getChannelCode(), $queuedMessage->getMessage());
            $this->handleSuccess($queuedMessage);
            $res = true;
        } catch (\Exception $e) {
            $this->handleFailure($queuedMessage);
            $res = false;
        }

        $this->queueRepository->save($queuedMessage);
        $this->queueBypass->setStatus(false);

        return $res;
    }
}
