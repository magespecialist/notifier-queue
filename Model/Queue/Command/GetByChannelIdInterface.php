<?php
/**
 * Automatically created by MageSpecialist CodeMonkey
 * https://github.com/magespecialist/m2-MSP_CodeMonkey
 */

declare(strict_types=1);

namespace MSP\NotifierQueue\Model\Queue\Command;

use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Get Queue by channelId command (Service Provider Interface - SPI)
 *
 * Separate command interface to which Repository proxies initial Get call, could be considered as SPI - Interfaces
 * that you should extend and implement to customize current behaviour, but NOT expected to be used (called) in the code
 * of business logic directly
 *
 * @see \MSP\NotifierQueueApi\Api\QueueRepositoryInterface
 * @api
 */
interface GetByChannelIdInterface
{
    /**
     * Get Queue data by given channelId
     *
     * @param int $channelId
     * @return \MSP\NotifierQueueApi\Api\Data\QueueInterface
     * @throws NoSuchEntityException
     */
    public function execute(int $channelId): \MSP\NotifierQueueApi\Api\Data\QueueInterface;
}
