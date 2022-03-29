<?php
namespace Ecentura\Portfolio\Controller\Portfolio;

class PortfolioItem extends \Magento\Framework\App\Action\Action
{
    protected $_pageFactory;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory
        )
    {
        $this->_pageFactory = $pageFactory;
        return parent::__construct($context);
    }

    public function execute()
    {
        //get id on path
        $id = $this->getRequest()->getParam('id');

        //if isset id => create object pageFactory
        if($id){
            return $this->_pageFactory->create();
        }else{
            //if !isset id =>redirect to page portfolio list
            return $this->redirect();
        }
    }


    public function redirect()
    {
        $redirect = $this->resultRedirectFactory->create();
        $redirect->setPath('portfolio/portfolio/portfoliolist');
        return $redirect;
    }
}
