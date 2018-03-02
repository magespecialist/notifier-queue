<?php
/**
 * Copyright © MageSpecialist - Skeeller srl. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace MSP\NotifierQueue\Model;

/**
 * This class handles the SendMessage plugin bypass
 *
 * @see \MSP\NotifierQueue\Plugin\Model\SendMessagePlugin
 */
class QueueBypass
{
    private $bypass = false;

    /**
     * Enable or disable enqueue plugin bypass
     * @param bool $bypass
     */
    public function setStatus(bool $bypass)
    {
        $this->bypass = $bypass;
    }

    /**
     * Return true if enqueue plugin should be disabled
     * @return bool
     */
    public function isActive()
    {
        return $this->bypass;
    }
}
