<?php

namespace Ecentura\Portfolio\Block\Portfolio;

use Ecentura\Portfolio\Model\ResourceModel\PortfolioCategory\CollectionFactory;
use Ecentura\Portfolio\Model\ResourceModel\Portfolio\CollectionFactory as PortfolioCollectionFactory;
use Magento\Store\Model\ScopeInterface;

class PortfolioList extends \Magento\Framework\View\Element\Template
{
    protected $_portfolioCategoyCollection;
    protected $_portfolioCollection;
    protected $_scopeConfig;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        CollectionFactory $collectionPortfolioCategoryFactory,
        PortfolioCollectionFactory $collectionPortfolioFactory,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    )
    {
        $this->_portfolioCategoyCollection = $collectionPortfolioCategoryFactory;
        $this->_portfolioCollection = $collectionPortfolioFactory;
        $this->_scopeConfig = $scopeConfig;
        parent::__construct($context);
    }

    //get all Category
    public function getAllPortfolioCategory()
    {
        return $this->_portfolioCategoyCollection->create()->getData();
    }


    //get All Portfolio by Category
    public function getAllPortfolioByCategory($categoryId)
    {
        return $this->_portfolioCollection->create()->addFieldToFilter('portfolio_category_id', $categoryId);

    }

    //get path pub/media
    public function getMediaUrl()
    {
        return $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
    }

    //get Data from System Configuration
    public function getConfigValue($path)
    {
        return $this->_scopeConfig->getValue($path, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }
}
