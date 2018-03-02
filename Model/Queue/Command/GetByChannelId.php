<?php
/**
 * Automatically created by MageSpecialist CodeMonkey
 * https://github.com/magespecialist/m2-MSP_CodeMonkey
 */

declare(strict_types=1);

namespace MSP\NotifierQueue\Model\Queue\Command;

use Magento\Framework\Exception\NoSuchEntityException;

/**
 * @inheritdoc
 */
class GetByChannelId implements GetByChannelIdInterface
{
    /**
     * @var \MSP\NotifierQueue\Model\ResourceModel\Queue
     */
    private $resource;

    /**
     * @var \MSP\NotifierQueueApi\Api\Data\QueueInterfaceFactory
     */
    private $factory;

    /**
     * @param \MSP\NotifierQueue\Model\ResourceModel\Queue $resource
     * @param \MSP\NotifierQueueApi\Api\Data\QueueInterfaceFactory $factory
     */
    public function __construct(
        \MSP\NotifierQueue\Model\ResourceModel\Queue $resource,
        \MSP\NotifierQueueApi\Api\Data\QueueInterfaceFactory $factory
    ) {
        $this->resource = $resource;
        $this->factory = $factory;
    }

    /**
     * @inheritdoc
     */
    public function execute(int $channelId): \MSP\NotifierQueueApi\Api\Data\QueueInterface
    {
        /** @var \MSP\NotifierQueueApi\Api\Data\QueueInterface $queue */
        $queue = $this->factory->create();
        $this->resource->load(
            $queue,
            $channelId,
            \MSP\NotifierQueueApi\Api\Data\QueueInterface::CHANNEL_ID
        );

        if (null === $queue->getId()) {
            throw new NoSuchEntityException(__('Queue with channelId "%value" does not exist', [
                'value' => $channelId
            ]));
        }

        return $queue;
    }
}
