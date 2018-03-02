<?php
/**
 * Copyright © MageSpecialist - Skeeller srl. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace MSP\NotifierQueue\Model\Channel\Validator;

use MSP\Notifier\Model\Channel\Validator\ChannelValidatorInterface;
use MSP\NotifierApi\Api\Data\ChannelInterface;

class ChannelExtValidator implements ChannelValidatorInterface
{
    /**
     * Execute validation. Return true on success or trigger an exception on failure
     * @param ChannelInterface $channel
     * @return bool
     * @throws \InvalidArgumentException
     */
    public function execute(ChannelInterface $channel): bool
    {
        $ext = $channel->getExtensionAttributes();

        if (($ext->getRetryFor() !== null) && ($ext->getRetryFor() < 1)) {
            throw new \InvalidArgumentException('' . __('Retry period should be greater than 0'));
        }

        return true;
    }
}
