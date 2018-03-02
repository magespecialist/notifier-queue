<?php
/**
 * Copyright © MageSpecialist - Skeeller srl. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace MSP\NotifierQueue\Model;

use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Enqueue message and do not send immediately (Service Provider Interface - SPI)
 *
 * @api
 */
interface EnqueueMessageInterface
{
    /**
     * Enqueue message and return queue ID
     * @param string $channelCode
     * @param string $message
     * @throws NoSuchEntityException
     * @throws \InvalidArgumentException
     * @return int
     */
    public function execute(string $channelCode, string $message): int;
}
