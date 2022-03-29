<?php
namespace Ecentura\Portfolio\Controller\Portfolio;

class CommentSave extends \Magento\Framework\App\Action\Action
{
    protected $_customerSession;
    protected $_commentFactory;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Customer\Model\Session $customerSession,
        \Ecentura\Portfolio\Model\CommentFactory $commentFactory
    )
    {
        $this->_customerSession = $customerSession;
        $this->_commentFactory = $commentFactory;
        return parent::__construct($context);
    }

    public function getCustomerId()
    {
        return $this->_customerSession->getCustomer()->getId(); //Print current customer ID

    }

    public function execute()
    {
        //if isset data submit
        if($this->getRequest()->isPost()){
            //get data submit
            $commentData = $this->getRequest()->getParams();

            //get customer id current loging
            $commentData['customer_id'] = $this->getCustomerId();
            try {
                //save
                $this->_commentFactory->create()->setData($commentData)->save();
                $this->messageManager->addSuccessMessage("Success!");
            } catch (\Exception $exception) {
                $this->messageManager->addErrorMessage(__("Error"));
            }
            return $this->redirectPortfolioItem();
        }else{
            return $this->redirectPortfolioItem();

        }
    }

    //redirect to page Referer
    public function redirectPortfolioItem()
    {
        $redirect = $this->resultRedirectFactory->create();
        $redirect->setRefererUrl();
        return $redirect;
    }
}
