<?php
namespace Ecentura\Portfolio\Model\ResourceModel;

class PortfolioCategory extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context
    )
    {
        parent::__construct($context);
    }

    protected function _construct()
    {
        $this->_init('portfolio_category', 'portfolio_category_id');
    }

}
