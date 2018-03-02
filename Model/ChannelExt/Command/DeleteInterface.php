<?php
/**
 * Automatically created by MageSpecialist CodeMonkey
 * https://github.com/magespecialist/m2-MSP_CodeMonkey
 */

declare(strict_types=1);

namespace MSP\NotifierQueue\Model\ChannelExt\Command;

use Magento\Framework\Exception\CouldNotDeleteException;

/**
 * Delete ChannelExt by channelExtId command (Service Provider Interface - SPI)
 *
 * Separate command interface to which Repository proxies initial Delete call, could be considered as SPI - Interfaces
 * that you should extend and implement to customize current behaviour, but NOT expected to be used (called) in the code
 * of business logic directly
 *
 * @see \MSP\NotifierQueueApi\Api\ChannelExtRepositoryInterface
 * @api
 */
interface DeleteInterface
{
    /**
     * Delete ChannelExt data by given channelExtId
     *
     * @param int $channelExtId
     * @return void
     * @throws CouldNotDeleteException
     */
    public function execute(int $channelExtId);
}
