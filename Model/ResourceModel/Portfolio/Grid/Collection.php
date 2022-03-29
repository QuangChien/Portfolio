<?php

namespace Ecentura\Portfolio\Model\ResourceModel\Portfolio\Grid;

use Magento\Framework\Data\Collection\Db\FetchStrategyInterface as FetchStrategy;
use Magento\Framework\Data\Collection\EntityFactoryInterface as EntityFactory;
use Magento\Framework\Event\ManagerInterface as EventManager;
use Magento\Framework\View\Element\UiComponent\DataProvider\SearchResult;
use Psr\Log\LoggerInterface as Logger;

class Collection extends SearchResult
{
    protected $_idFieldName = 'id';

    public function __construct(
        EntityFactory $entityFactory,
        Logger $logger,
        FetchStrategy $fetchStrategy,
        EventManager $eventManager,
        $mainTable = 'portfolio',
        $resourceModel = 'Ecentura\Portfolio\Model\ResourceModel\Portfolio',
        $identifierName = null,
        $connectionName = null
    ) {
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $mainTable, $resourceModel, $identifierName, $connectionName);
    }

    /**
     * @return Collection|void
     */
    protected function _initSelect()
    {
        parent::_initSelect();

        // Join the 2nd Table
        $this->getSelect()
            ->joinLeft(
                ['portfolioCate' => $this->getConnection()->getTableName('portfolio_category')],
                'main_table.portfolio_category_id = portfolioCate.portfolio_category_id',
                ['portfolio_category_name' => 'portfolioCate.portfolio_category_name']
            );
    }
}
