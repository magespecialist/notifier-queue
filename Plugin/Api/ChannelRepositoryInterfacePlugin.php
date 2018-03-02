<?php
/**
 * Copyright © MageSpecialist - Skeeller srl. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace MSP\NotifierQueue\Plugin\Api;

use MSP\NotifierApi\Api\ChannelRepositoryInterface;
use MSP\NotifierApi\Api\Data\ChannelInterface;
use MSP\NotifierQueue\Model\ChannelExtPersist;

class ChannelRepositoryInterfacePlugin
{
    /**
     * @var ChannelExtPersist
     */
    private $channelExtPersist;

    /**
     * ChannelRepositoryInterfacePlugin constructor.
     * @param ChannelExtPersist $channelExtPersist
     * @SuppressWarnings(PHPMD.LongVariables)
     */
    public function __construct(
        ChannelExtPersist $channelExtPersist
    ) {
        $this->channelExtPersist = $channelExtPersist;
    }

    /**
     * @param ChannelRepositoryInterface $subject
     * @param ChannelInterface $result
     * @return ChannelInterface
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterGet(ChannelRepositoryInterface $subject, ChannelInterface $result)
    {
        $this->channelExtPersist->load($result);
        return $result;
    }

    /**
     * @param ChannelRepositoryInterface $subject
     * @param ChannelInterface $result
     * @return ChannelInterface
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterGetByCode(ChannelRepositoryInterface $subject, ChannelInterface $result)
    {
        $this->channelExtPersist->load($result);
        return $result;
    }

    /**
     * @param ChannelRepositoryInterface $subject
     * @param \Closure $procede
     * @param ChannelInterface $channel
     * @return int
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function aroundSave(
        ChannelRepositoryInterface $subject,
        \Closure $procede,
        ChannelInterface $channel
    ): int {
        $channelId = $procede($channel);
        $channel->setId($channelId);
        $this->channelExtPersist->save($channel);
        return (int) $channelId;
    }
}
