<?php
/**
 * Copyright © MageSpecialist - Skeeller srl. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace MSP\NotifierQueue\Plugin\Model;

use MSP\Notifier\Model\SendMessage;
use MSP\NotifierApi\Api\IsEnabledInterface;
use MSP\NotifierQueue\Model\EnqueueMessageInterface;
use MSP\NotifierQueue\Model\QueueBypass;

class SendMessagePlugin
{
    /**
     * @var EnqueueMessageInterface
     */
    private $enqueueMessage;

    /**
     * @var QueueBypass
     */
    private $bypass;

    /**
     * @var IsEnabledInterface
     */
    private $isEnabled;

    /**
     * SendMessagePlugin constructor.
     * @param EnqueueMessageInterface $enqueueMessage
     * @param IsEnabledInterface $isEnabled
     * @param QueueBypass $bypass
     */
    public function __construct(
        EnqueueMessageInterface $enqueueMessage,
        IsEnabledInterface $isEnabled,
        QueueBypass $bypass
    ) {
        $this->enqueueMessage = $enqueueMessage;
        $this->bypass = $bypass;
        $this->isEnabled = $isEnabled;
    }

    /**
     * @param SendMessage $subject
     * @param \Closure $procede
     * @param string $channelCode
     * @param string $message
     * @return bool
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @throws \InvalidArgumentException
     */
    public function aroundExecute(
        SendMessage $subject,
        \Closure $procede,
        string $channelCode,
        string $message
    ): bool {

        if (!$this->isEnabled->execute()) {
            return false;
        }

        if ($this->bypass->isActive()) {
            return $procede($channelCode, $message);
        }

        $this->enqueueMessage->execute($channelCode, $message);
        return true;
    }
}
