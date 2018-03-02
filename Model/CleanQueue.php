<?php
/**
 * Copyright © MageSpecialist - Skeeller srl. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace MSP\NotifierQueue\Model;

use MSP\NotifierQueue\Model\ResourceModel\Queue;

class CleanQueue implements CleanQueueInterface
{
    /**
     * @var Queue
     */
    private $queueResource;

    /**
     * @var int
     */
    private $daysHistory;

    /**
     * CleanQueue constructor.
     * @param Queue $queueResource
     * @param int $daysHistory
     */
    public function __construct(
        Queue $queueResource,
        int $daysHistory = 7
    ) {
        $this->queueResource = $queueResource;
        $this->daysHistory = $daysHistory;
    }

    /**
     * Clean old sent messages
     * @return void
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute()
    {
        $this->queueResource->cleanOldMessages($this->daysHistory);
    }
}
