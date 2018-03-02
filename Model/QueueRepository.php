<?php
/**
 * Automatically created by MageSpecialist CodeMonkey
 * https://github.com/magespecialist/m2-MSP_CodeMonkey
 */

declare(strict_types=1);

namespace MSP\NotifierQueue\Model;

use Magento\Framework\Api\SearchCriteriaInterface;
use MSP\NotifierQueue\Model\Queue\Command\DeleteInterface;
use MSP\NotifierQueue\Model\Queue\Command\GetInterface;
use MSP\NotifierQueue\Model\Queue\Command\GetListInterface;
use MSP\NotifierQueue\Model\Queue\Command\SaveInterface;

/**
 * @SuppressWarnings(PHPMD.ShortVariable)
 * @SuppressWarnings(PHPMD.LongVariable)
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class QueueRepository implements \MSP\NotifierQueueApi\Api\QueueRepositoryInterface
{
    /**
     * @var \MSP\NotifierQueue\Model\Queue\Command\SaveInterface
     */
    private $commandSave;

    /**
     * @var \MSP\NotifierQueue\Model\Queue\Command\GetInterface
     */
    private $commandGet;

    /**
     * @var \MSP\NotifierQueue\Model\Queue\Command\DeleteInterface
     */
    private $commandDeleteById;

    /**
     * @var \MSP\NotifierQueue\Model\Queue\Command\GetListInterface
     */
    private $commandGetList;

    /**
     * @param \MSP\NotifierQueue\Model\Queue\Command\SaveInterface $commandSave
     * @param \MSP\NotifierQueue\Model\Queue\Command\GetInterface $commandGet
     * @param \MSP\NotifierQueue\Model\Queue\Command\DeleteInterface $commandDeleteById
     * @param \MSP\NotifierQueue\Model\Queue\Command\GetListInterface $commandGetList
     */
    public function __construct(
        SaveInterface $commandSave,
        GetInterface $commandGet,
        DeleteInterface $commandDeleteById,
        GetListInterface $commandGetList
    ) {
        $this->commandSave = $commandSave;
        $this->commandGet = $commandGet;
        $this->commandDeleteById = $commandDeleteById;
        $this->commandGetList = $commandGetList;
    }

    /**
     * @inheritdoc
     */
    public function save(\MSP\NotifierQueueApi\Api\Data\QueueInterface $queue): int
    {
        return $this->commandSave->execute($queue);
    }

    /**
     * @inheritdoc
     */
    public function get(int $queueId): \MSP\NotifierQueueApi\Api\Data\QueueInterface
    {
        return $this->commandGet->execute($queueId);
    }

    /**
     * @inheritdoc
     */
    public function deleteById(int $queueId)
    {
        $this->commandDeleteById->execute($queueId);
    }

    /**
     * @inheritdoc
     */
    public function getList(
        SearchCriteriaInterface $searchCriteria = null
    ): \MSP\NotifierQueueApi\Api\QueueSearchResultsInterface {
        return $this->commandGetList->execute($searchCriteria);
    }
}
