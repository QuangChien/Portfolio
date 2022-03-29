<?php
namespace Ecentura\Portfolio\Model\ResourceModel\PortfolioCategory;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected function _construct()
    {
        $this->_init('Ecentura\Portfolio\Model\PortfolioCategory', 'Ecentura\Portfolio\Model\ResourceModel\PortfolioCategory');
    }
}
