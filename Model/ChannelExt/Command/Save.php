<?php
/**
 * Automatically created by MageSpecialist CodeMonkey
 * https://github.com/magespecialist/m2-MSP_CodeMonkey
 */

declare(strict_types=1);

namespace MSP\NotifierQueue\Model\ChannelExt\Command;

use Magento\Framework\Exception\CouldNotSaveException;
use Psr\Log\LoggerInterface;

/**
 * @inheritdoc
 */
class Save implements SaveInterface
{
    /**
     * @var \MSP\NotifierQueue\Model\ResourceModel\ChannelExt
     */
    private $resource;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @param \MSP\NotifierQueue\Model\ResourceModel\ChannelExt $resource
     * @param LoggerInterface $logger
     */
    public function __construct(
        \MSP\NotifierQueue\Model\ResourceModel\ChannelExt $resource,
        LoggerInterface $logger
    ) {
        $this->resource = $resource;
        $this->logger = $logger;
    }

    /**
     * @inheritdoc
     */
    public function execute(\MSP\NotifierQueueApi\Api\Data\ChannelExtInterface $channelExt): int
    {
        try {
            $this->resource->save($channelExt);
            return (int) $channelExt->getId();
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
            throw new CouldNotSaveException(__('Could not save ChannelExt'), $e);
        }
    }
}
