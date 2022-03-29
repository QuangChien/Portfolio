<?php
namespace Ecentura\Portfolio\Block\Portfolio;

use Magento\Framework\View\Element\Template;

class CustomHead extends Template
{
    protected $_scopeConfig;
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    )
    {
        $this->_scopeConfig = $scopeConfig;
        parent::__construct($context);
    }

    //get value system configuration
    public function getConfigValue($path)
    {
        return $this->_scopeConfig->getValue($path, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }
}
