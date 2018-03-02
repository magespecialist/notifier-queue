<?php
/**
 * Copyright © MageSpecialist - Skeeller srl. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace MSP\NotifierQueue\Model;

/**
 * Interface CleanQueueInterface
 * @api
 */
interface CleanQueueInterface
{
    /**
     * Clean old sent messages
     * @return void
     */
    public function execute();
}
