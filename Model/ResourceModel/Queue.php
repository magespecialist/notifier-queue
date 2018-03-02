<?php
/**
 * Automatically created by MageSpecialist CodeMonkey
 * https://github.com/magespecialist/m2-MSP_CodeMonkey
 */

declare(strict_types=1);

namespace MSP\NotifierQueue\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;
use Magento\Framework\Stdlib\DateTime\DateTime;
use MSP\NotifierQueueApi\Api\Data\QueueInterface;

/**
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 */
class Queue extends AbstractDb
{
    const TABLE_NAME = 'msp_notifier_queue';
    const ONE_DAY = 86400;

    /**
     * @var DateTime
     */
    private $dateTime;

    public function __construct(
        Context $context,
        DateTime $dateTime,
        string $connectionName = null
    ) {
        parent::__construct($context, $connectionName);
        $this->dateTime = $dateTime;
    }

    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init(
            self::TABLE_NAME,
            QueueInterface::ID
        );
    }

    /**
     * Clean old messages from DB
     * @param int $days
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function cleanOldMessages($days = 7)
    {
        $days = max($days, 1);

        $connection = $this->getConnection();

        $clearDate = $this->dateTime->date(
            'Y-m-d H:i:s',
            $this->dateTime->timestamp() - ((int) $days) * self::ONE_DAY
        );

        $connection->delete(
            $this->getMainTable(),
            QueueInterface::CREATED_AT . ' < ' . $connection->quote($clearDate)
        );
    }
}
