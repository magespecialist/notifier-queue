<?php
/**
 * Automatically created by MageSpecialist CodeMonkey
 * https://github.com/magespecialist/m2-MSP_CodeMonkey
 */

declare(strict_types=1);

namespace MSP\NotifierQueue\Model\ResourceModel\Queue;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 */
class Collection extends AbstractCollection
{
    protected $_idFieldName = \MSP\NotifierQueueApi\Api\Data\QueueInterface::ID;

    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init(
            \MSP\NotifierQueue\Model\Queue::class,
            \MSP\NotifierQueue\Model\ResourceModel\Queue::class
        );
    }
}
