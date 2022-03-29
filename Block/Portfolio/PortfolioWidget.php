<?php

namespace Ecentura\Portfolio\Block\Portfolio;

use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;
use Ecentura\Portfolio\Model\ResourceModel\PortfolioCategory\CollectionFactory;
use Ecentura\Portfolio\Model\ResourceModel\Portfolio\CollectionFactory as PortfolioCollectionFactory;

class PortfolioWidget extends Template implements BlockInterface
{
    protected $_template = "portfolio/widget.phtml";

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

    //get all Portfolio Category
    public function getAllPortfolioCategory()
    {
        return $this->_portfolioCategoyCollection->create()->getData();
    }

    public function getNumberPortfoliShow()
    {
        return $this->getData('total_portfolio');
    }

    //get All Portfolio by Category
    public function getAllPortfolioByCategory($categoryId)
    {
        return $this->_portfolioCollection->create()->addFieldToFilter('portfolio_category_id', $categoryId)->setPageSize($this->getNumberPortfoliShow());

    }

    //get folder pub/media
    public function getMediaUrl()
    {
        return $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
    }

    //get value from system configuation
    public function getConfigValue($path)
    {
        return $this->_scopeConfig->getValue($path, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }
}
