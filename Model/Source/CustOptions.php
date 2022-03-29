<?php

namespace Ecentura\Portfolio\Model\Source;

class CustOptions implements \Magento\Framework\Option\ArrayInterface
{

    protected $_portfolioCategory;

    public function __construct(
        \Ecentura\Portfolio\Model\ResourceModel\PortfolioCategory\CollectionFactory $collection
    )
    {
        $this->_portfolioCategory = $collection;
    }

    public function toOptionArray()
    {

        $collection = $this->_portfolioCategory->create()->getData();
//        echo "<pre>";
//        print_r($collection); die();
        $itemArray = array('value' => '', 'label' => '--Please Select--');
        //
        $portfolioCategoryArray = array();
        $portfolioCategoryArray[] = $itemArray;
        foreach ($collection as $itemArrayPortfolio)
        {
            $portfolioCategoryArray[] = array('value' => $itemArrayPortfolio['portfolio_category_id'], 'label' => $itemArrayPortfolio['portfolio_category_name']);

        }
        return $portfolioCategoryArray;
    }
}

?>
