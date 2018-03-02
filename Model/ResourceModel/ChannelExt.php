<?php
/**
 * Automatically created by MageSpecialist CodeMonkey
 * https://github.com/magespecialist/m2-MSP_CodeMonkey
 */

declare(strict_types=1);

namespace MSP\NotifierQueue\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 */
class ChannelExt extends AbstractDb
{
    const TABLE_NAME = 'msp_notifier_queue_channel_ex';

    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init(
            self::TABLE_NAME,
            \MSP\NotifierQueueApi\Api\Data\ChannelExtInterface::ID
        );
    }
}
