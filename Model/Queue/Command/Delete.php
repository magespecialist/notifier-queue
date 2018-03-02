<?php
/**
 * Automatically created by MageSpecialist CodeMonkey
 * https://github.com/magespecialist/m2-MSP_CodeMonkey
 */

declare(strict_types=1);

namespace MSP\NotifierQueue\Model\Queue\Command;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\CouldNotDeleteException;
use Psr\Log\LoggerInterface;

/**
 * @inheritdoc
 */
class Delete implements DeleteInterface
{
    /**
     * @var \MSP\NotifierQueue\Model\ResourceModel\Queue
     */
    private $resource;

    /**
     * @var GetInterface
     */
    private $commandGet;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @param \MSP\NotifierQueue\Model\ResourceModel\Queue $resource
     * @param GetInterface $commandGet
     * @param LoggerInterface $logger
     */
    public function __construct(
        \MSP\NotifierQueue\Model\ResourceModel\Queue $resource,
        GetInterface $commandGet,
        LoggerInterface $logger
    ) {
        $this->resource = $resource;
        $this->commandGet = $commandGet;
        $this->logger = $logger;
    }

    /**
     * @inheritdoc
     */
    public function execute(int $queueId)
    {
        /** @var \MSP\NotifierQueueApi\Api\Data\QueueInterface $queue */
        try {
            $queue = $this->commandGet->execute($queueId);
        } catch (NoSuchEntityException $e) {
            return;
        }

        try {
            $this->resource->delete($queue);
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
            throw new CouldNotDeleteException(__('Could not delete Queue'), $e);
        }
    }
}
