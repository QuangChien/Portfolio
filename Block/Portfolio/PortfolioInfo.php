<?php

namespace Ecentura\Portfolio\Block\Portfolio;

use Magento\Framework\App\ResponseInterface;
use Ecentura\Portfolio\Model\ResourceModel\Portfolio\CollectionFactory as PortfolioCollectionFactory;

class PortfolioInfo extends \Magento\Framework\View\Element\Template
{
    protected $_portfolioCollection;
    protected $_portfolioJoinData;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        PortfolioCollectionFactory $portfolioCollection
    )
    {
        $this->_portfolioCollection = $portfolioCollection;
        parent::__construct($context);
    }

    public function getPortfolioJoinCateItem()
    {
        //get id in path
        $id = $this->getRequest()->getParam('id') ? $this->getRequest()->getParam('id') : '';

        //if isset id in path
        if ($id) {
            //create object collection => join with Category table to get Category name
            $portfolioJoinCates = $this->_portfolioCollection->create()->joinPortfolioWithCate();

            //foreach data table after join, only get object have id = id in path
            foreach ($portfolioJoinCates as $key => $portfolioJoinCate) {
                if ($portfolioJoinCate->getId() == $id) {
                    $this->_portfolioJoinData = $portfolioJoinCate;
                }
            }

            //if do not data in datatabase => die()
            if ($this->_portfolioJoinData == null) {
                die();
            }

            return $this->_portfolioJoinData;
        } else {
            //if !isset id in path=>die()
            die();
        }
    }
}
