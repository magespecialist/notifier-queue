<?php
/**
 * Copyright © MageSpecialist - Skeeller srl. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace MSP\NotifierQueue\Model\Source\Channel;

use Magento\Framework\Option\ArrayInterface;

class ImmediateSend implements ArrayInterface
{
    /**
     * @inheritdoc
     */
    public function toOptionArray()
    {
        return [
            ['value' => 1, 'label' => __('Immediate')],
            ['value' => 0, 'label' => __('Asynchronous')],
        ];
    }
}
