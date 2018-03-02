<?php
/**
 * Automatically created by MageSpecialist CodeMonkey
 * https://github.com/magespecialist/m2-MSP_CodeMonkey
 */

declare(strict_types=1);

namespace MSP\NotifierQueue\Model;

use Magento\Framework\Api\SearchCriteriaInterface;

/**
 * @SuppressWarnings(PHPMD.ShortVariable)
 * @SuppressWarnings(PHPMD.LongVariable)
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class ChannelExtRepository implements \MSP\NotifierQueueApi\Api\ChannelExtRepositoryInterface
{
    /**
     * @var \MSP\NotifierQueue\Model\ChannelExt\Command\SaveInterface
     */
    private $commandSave;

    /**
     * @var \MSP\NotifierQueue\Model\ChannelExt\Command\GetInterface
     */
    private $commandGet;
    /**
     * @var \MSP\NotifierQueue\Model\ChannelExt\Command\GetByChannelIdInterface
     */
    private $commandGetByChannelId;

    /**
     * @var \MSP\NotifierQueue\Model\ChannelExt\Command\DeleteInterface
     */
    private $commandDeleteById;

    /**
     * @var \MSP\NotifierQueue\Model\ChannelExt\Command\GetListInterface
     */
    private $commandGetList;

    /**
     * @param \MSP\NotifierQueue\Model\ChannelExt\Command\SaveInterface $commandSave
     * @param \MSP\NotifierQueue\Model\ChannelExt\Command\GetInterface $commandGet
     * @param \MSP\NotifierQueue\Model\ChannelExt\Command\GetByChannelIdInterface $commandGetByChannelId
     * @param \MSP\NotifierQueue\Model\ChannelExt\Command\DeleteInterface $commandDeleteById
     * @param \MSP\NotifierQueue\Model\ChannelExt\Command\GetListInterface $commandGetList
     */
    public function __construct(
        \MSP\NotifierQueue\Model\ChannelExt\Command\SaveInterface $commandSave,
        \MSP\NotifierQueue\Model\ChannelExt\Command\GetInterface $commandGet,
        \MSP\NotifierQueue\Model\ChannelExt\Command\GetByChannelIdInterface $commandGetByChannelId,
        \MSP\NotifierQueue\Model\ChannelExt\Command\DeleteInterface $commandDeleteById,
        \MSP\NotifierQueue\Model\ChannelExt\Command\GetListInterface $commandGetList
    ) {
        $this->commandSave = $commandSave;
        $this->commandGet = $commandGet;
        $this->commandGetByChannelId = $commandGetByChannelId;
        $this->commandDeleteById = $commandDeleteById;
        $this->commandGetList = $commandGetList;
    }

    /**
     * @inheritdoc
     */
    public function save(\MSP\NotifierQueueApi\Api\Data\ChannelExtInterface $channelExt): int
    {
        return $this->commandSave->execute($channelExt);
    }

    /**
     * @inheritdoc
     */
    public function get(int $channelExtId): \MSP\NotifierQueueApi\Api\Data\ChannelExtInterface
    {
        return $this->commandGet->execute($channelExtId);
    }

    /**
     * @inheritdoc
     */
    public function getByChannelId(int $channelId): \MSP\NotifierQueueApi\Api\Data\ChannelExtInterface
    {
        return $this->commandGetByChannelId->execute($channelId);
    }

    /**
     * @inheritdoc
     */
    public function deleteById(int $channelExtId)
    {
        $this->commandDeleteById->execute($channelExtId);
    }

    /**
     * @inheritdoc
     */
    public function getList(
        SearchCriteriaInterface $searchCriteria = null
    ): \MSP\NotifierQueueApi\Api\ChannelExtSearchResultsInterface {
        return $this->commandGetList->execute($searchCriteria);
    }
}
