<?php
namespace Ecentura\Portfolio\Model\ResourceModel\Portfolio;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $portfolioTable;
    protected $portfolioCateTable;

    protected function _construct()
    {
        $this->_init('Ecentura\Portfolio\Model\Portfolio', 'Ecentura\Portfolio\Model\ResourceModel\Portfolio');
    }

    public function joinPortfolioWithCate()
    {
        $this->portfolioTable = "main_table";
        $this->portfolioCateTable = $this->getTable("portfolio_category");
        $this->getSelect()
            ->join(array('portfolioCate' => $this->portfolioCateTable),
                $this->portfolioTable . '.portfolio_category_id = portfolioCate.portfolio_category_id',
                array('*')
            );

        return $this;
    }

//    protected function _initSelect()
//    {
//        parent::_initSelect();
//        $this->portfolioTable = "main_table";
//        $this->portfolioCateTable = $this->getTable("portfolio_category");
//        $this->getSelect()
//            ->join(array('portfolioCate' => $this->portfolioCateTable),
//                $this->portfolioTable . '.portfolio_category_id = portfolioCate.portfolio_category_id',
//                array('*')
//            );
//
//        return $this;
//        $this->getSelect()->join(
//            ['portfolioCate' => $this->getTable("portfolio_category")],
//            'main_table.portfolio_category_id = portfolioCate.portfolio_category_id',
//            ['portfolio_category_name'=>'portfolioCate.portfolio_category_name']
//        );
//        $this->addFilterToMap('portfolio_category_name', 'portfolioCate.portfolio_category_name');
//        return $this;
//    }
}
