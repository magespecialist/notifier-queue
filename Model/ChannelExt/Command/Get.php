<?php
/**
 * Automatically created by MageSpecialist CodeMonkey
 * https://github.com/magespecialist/m2-MSP_CodeMonkey
 */

declare(strict_types=1);

namespace MSP\NotifierQueue\Model\ChannelExt\Command;

use Magento\Framework\Exception\NoSuchEntityException;

/**
 * @inheritdoc
 */
class Get implements GetInterface
{
    /**
     * @var \MSP\NotifierQueue\Model\ResourceModel\ChannelExt
     */
    private $resource;

    /**
     * @var \MSP\NotifierQueueApi\Api\Data\ChannelExtInterfaceFactory
     */
    private $factory;

    /**
     * @param \MSP\NotifierQueue\Model\ResourceModel\ChannelExt $resource
     * @param \MSP\NotifierQueueApi\Api\Data\ChannelExtInterfaceFactory $factory
     */
    public function __construct(
        \MSP\NotifierQueue\Model\ResourceModel\ChannelExt $resource,
        \MSP\NotifierQueueApi\Api\Data\ChannelExtInterfaceFactory $factory
    ) {
        $this->resource = $resource;
        $this->factory = $factory;
    }

    /**
     * @inheritdoc
     */
    public function execute(int $channelExtId): \MSP\NotifierQueueApi\Api\Data\ChannelExtInterface
    {
        /** @var \MSP\NotifierQueueApi\Api\Data\ChannelExtInterface $channelExt */
        $channelExt = $this->factory->create();
        $this->resource->load(
            $channelExt,
            $channelExtId,
            \MSP\NotifierQueueApi\Api\Data\ChannelExtInterface::ID
        );

        if (null === $channelExt->getId()) {
            throw new NoSuchEntityException(__('ChannelExt with id "%value" does not exist.', [
                'value' => $channelExtId
            ]));
        }

        return $channelExt;
    }
}
