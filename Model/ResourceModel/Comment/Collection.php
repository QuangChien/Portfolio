<?php

namespace Ecentura\Portfolio\Model\ResourceModel\Comment;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected function _construct()
    {
        $this->_init('Ecentura\Portfolio\Model\Comment', 'Ecentura\Portfolio\Model\ResourceModel\Comment');
    }

    public function joinData($portfolioId)
    {
        $this->getSelect()->join(array('customer' => $this->getTable("customer_entity")),
            'main_table.customer_id = customer.entity_id',
            ['customer_firstname' => 'customer.firstname', 'customer_lastname' => 'customer.lastname'])->where('main_table.portfolio_id = ' . $portfolioId);

        return $this;
    }

    public function joinDataWithPortfolio($customerId)
    {
        $this->getSelect()->join(array('portfolio' => $this->getTable("portfolio")),
            'main_table.portfolio_id = portfolio.portfolio_id',
            ['portfolio_id' => 'portfolio.portfolio_id'])->where('main_table.customer_id = ' . $customerId);

        return $this;
    }
}
