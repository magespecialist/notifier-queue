<?php
/**
 * Automatically created by MageSpecialist CodeMonkey
 * https://github.com/magespecialist/m2-MSP_CodeMonkey
 */

declare(strict_types=1);

namespace MSP\NotifierQueue\Model\ChannelExt\Command;

use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchCriteriaInterface;

/**
 * @inheritdoc
 */
class GetList implements GetListInterface
{
    /**
     * @var \MSP\NotifierQueue\Model\ResourceModel\ChannelExt\CollectionFactory
     */
    private $collectionFactory;

    /**
     * @var \MSP\NotifierQueueApi\Api\ChannelExtSearchResultsInterfaceFactory
     */
    private $searchResultsFactory;

    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * @param \MSP\NotifierQueue\Model\ResourceModel\ChannelExt\CollectionFactory $collectionFactory
     * @param \MSP\NotifierQueueApi\Api\ChannelExtSearchResultsInterfaceFactory $searchResultsFactory
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @SuppressWarnings(PHPMD.LongVariable)
     */
    public function __construct(
        \MSP\NotifierQueue\Model\ResourceModel\ChannelExt\CollectionFactory $collectionFactory,
        \MSP\NotifierQueueApi\Api\ChannelExtSearchResultsInterfaceFactory $searchResultsFactory,
        SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    private function addFilterGroupToCollection(
        \Magento\Framework\Api\Search\FilterGroup $filterGroup,
        \MSP\NotifierQueue\Model\ResourceModel\ChannelExt\Collection $collection
    ) {
        $fields = [];
        $conditions = [];
        foreach ($filterGroup->getFilters() as $filter) {
            $condition = $filter->getConditionType() ?: 'eq';
            $fields[] = $filter->getField();

            $conditions[] = [$condition => $filter->getValue()];
        }

        if ($fields) {
            $collection->addFieldToFilter($fields, $conditions);
        }
    }

    private function applySearchCriteriaToCollection(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria,
        \MSP\NotifierQueue\Model\ResourceModel\ChannelExt\Collection $collection
    ) {
        $this->applySearchCriteriaFiltersToCollection($searchCriteria, $collection);
        $this->applySearchCriteriaSortOrdersToCollection($searchCriteria, $collection);
        $this->applySearchCriteriaPagingToCollection($searchCriteria, $collection);
    }

    private function applySearchCriteriaFiltersToCollection(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria,
        \MSP\NotifierQueue\Model\ResourceModel\ChannelExt\Collection $collection
    ) {
        foreach ($searchCriteria->getFilterGroups() as $group) {
            $this->addFilterGroupToCollection($group, $collection);
        }
    }

    private function applySearchCriteriaSortOrdersToCollection(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria,
        \MSP\NotifierQueue\Model\ResourceModel\ChannelExt\Collection $collection
    ) {
        $sortOrders = $searchCriteria->getSortOrders();
        if ($sortOrders) {
            foreach ($sortOrders as $sortOrder) {
                if ($sortOrder->getField()) {
                    $isAscending = $sortOrder->getDirection() == \Magento\Framework\Api\SortOrder::SORT_ASC;
                    $collection->addOrder($sortOrder->getField(), $isAscending ? 'ASC' : 'DESC');
                }
            }
        }
    }

    private function applySearchCriteriaPagingToCollection(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria,
        \MSP\NotifierQueue\Model\ResourceModel\ChannelExt\Collection $collection
    ) {
        $collection->setCurPage($searchCriteria->getCurrentPage());
        $collection->setPageSize($searchCriteria->getPageSize());
    }

    /**
     * @inheritdoc
     */
    public function execute(
        SearchCriteriaInterface $searchCriteria = null
    ): \MSP\NotifierQueueApi\Api\ChannelExtSearchResultsInterface {
        /** @var \MSP\NotifierQueue\Model\ResourceModel\ChannelExt\Collection $collection */
        $collection = $this->collectionFactory->create();

        if (null === $searchCriteria) {
            $searchCriteria = $this->searchCriteriaBuilder->create();
        } else {
            $this->applySearchCriteriaToCollection($searchCriteria, $collection);
        }

        /** @var \MSP\NotifierQueueApi\Api\ChannelExtSearchResultsInterface $searchResult */
        $searchResult = $this->searchResultsFactory->create();
        $searchResult->setItems($collection->getItems());
        $searchResult->setTotalCount($collection->getSize());
        $searchResult->setSearchCriteria($searchCriteria);

        return $searchResult;
    }
}
