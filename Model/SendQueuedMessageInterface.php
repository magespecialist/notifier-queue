<?php
/**
 * Copyright © MageSpecialist - Skeeller srl. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace MSP\NotifierQueue\Model;

/**
 * Send queued message (Service Provider Interface - SPI)
 *
 * @api
 */
interface SendQueuedMessageInterface
{
    /**
     * Send a queued message and return true on success
     * @param int $queueId
     * @return bool
     */
    public function execute(int $queueId): bool;
}
