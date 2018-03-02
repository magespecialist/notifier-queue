<?php
/**
 * Copyright © MageSpecialist - Skeeller srl. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace MSP\NotifierQueue\Model;

/**
 * Send queued messages (Service Provider Interface - SPI)
 *
 * @api
 */
interface SendQueueInterface
{
    /**
     * Send queued messages
     */
    public function execute();
}
