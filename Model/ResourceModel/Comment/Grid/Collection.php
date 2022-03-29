<?php

namespace Ecentura\Portfolio\Model\ResourceModel\Comment\Grid;

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
        $mainTable = 'portfolio_comment',
        $resourceModel = 'Ecentura\Portfolio\Model\ResourceModel\Comment',
        $identifierName = null,
        $connectionName = null
    )
    {
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
                ['portfolio' => $this->getConnection()->getTableName('portfolio')],
                'main_table.portfolio_id = portfolio.portfolio_id',
                ['portfolio_id' => 'portfolio.portfolio_id']
            )->joinLeft(
                ['customer' => $this->getConnection()->getTableName('customer_entity')],
                'main_table.customer_id = customer.entity_id',
                ['customer_firstname' => 'customer.firstname', 'email' => 'customer.email']);
    }
}
