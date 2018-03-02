<?php
/**
 * Automatically created by MageSpecialist CodeMonkey
 * https://github.com/magespecialist/m2-MSP_CodeMonkey
 */

declare(strict_types=1);

namespace MSP\NotifierQueue\Model\Queue\Command;

use Magento\Framework\Exception\CouldNotSaveException;
use Psr\Log\LoggerInterface;

/**
 * @inheritdoc
 */
class Save implements SaveInterface
{
    /**
     * @var \MSP\NotifierQueue\Model\ResourceModel\Queue
     */
    private $resource;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @param \MSP\NotifierQueue\Model\ResourceModel\Queue $resource
     * @param LoggerInterface $logger
     */
    public function __construct(
        \MSP\NotifierQueue\Model\ResourceModel\Queue $resource,
        LoggerInterface $logger
    ) {
        $this->resource = $resource;
        $this->logger = $logger;
    }

    /**
     * @inheritdoc
     */
    public function execute(\MSP\NotifierQueueApi\Api\Data\QueueInterface $queue): int
    {
        try {
            $this->resource->save($queue);
            return (int) $queue->getId();
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
            throw new CouldNotSaveException(__('Could not save Queue'), $e);
        }
    }
}
