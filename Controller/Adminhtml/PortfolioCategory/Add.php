<?php

namespace Ecentura\Portfolio\Controller\Adminhtml\PortfolioCategory;

use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action;

class Add extends \Magento\Backend\App\Action
{
    protected $_pageFactory;

    public function __construct(
        Action\Context $context,
        PageFactory $pageFactory
    )
    {
        $this->_pageFactory = $pageFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->getConfig()->getTitle()->prepend(__('Portfolio Category'));
        return $resultPage;
    }

    //Check rule (ACL)
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Ecentura_Portfolio::portfolio');
    }
}
