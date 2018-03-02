<?php
/**
 * Automatically created by MageSpecialist CodeMonkey
 * https://github.com/magespecialist/m2-MSP_CodeMonkey
 */

declare(strict_types=1);

namespace MSP\NotifierQueue\Model\ChannelExt\Command;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\CouldNotDeleteException;
use Psr\Log\LoggerInterface;

/**
 * @inheritdoc
 */
class Delete implements DeleteInterface
{
    /**
     * @var \MSP\NotifierQueue\Model\ResourceModel\ChannelExt
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
     * @param \MSP\NotifierQueue\Model\ResourceModel\ChannelExt $resource
     * @param GetInterface $commandGet
     * @param LoggerInterface $logger
     */
    public function __construct(
        \MSP\NotifierQueue\Model\ResourceModel\ChannelExt $resource,
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
    public function execute(int $channelExtId)
    {
        /** @var \MSP\NotifierQueueApi\Api\Data\ChannelExtInterface $channelExt */
        try {
            $channelExt = $this->commandGet->execute($channelExtId);
        } catch (NoSuchEntityException $e) {
            return;
        }

        try {
            $this->resource->delete($channelExt);
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
            throw new CouldNotDeleteException(__('Could not delete ChannelExt'), $e);
        }
    }
}
