<?php

namespace Ecentura\Portfolio\Block\Portfolio;

class PortfolioComment extends \Magento\Framework\View\Element\Template
{
    protected $_customerSession;
    protected $_collectionFactory;
    protected $_id;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Customer\Model\Session $session,
        \Ecentura\Portfolio\Model\ResourceModel\Comment\CollectionFactory $collectionFactory
    )
    {
        $this->_customerSession = $session;
        $this->_collectionFactory = $collectionFactory;
        parent::__construct($context);
    }

    //check login
    public function checkLogin()
    {
        if ($this->_customerSession->isLoggedIn()) {
            return true;
        } else {
            return false;
        }
    }


    //get Portfolio Id
    public function getPortfolioId()
    {
        $this->_id = $this->getRequest()->getParam('id') ? $this->getRequest()->getParam('id') : '';
        if($this->_id){
            return $this->_id;
        }else{
            die();
        }
    }

    public function getCommentData()
    {
        //if isset portfolio =>get all coment belong to that portfolio
        if($this->getPortfolioId()){
            $comments = $this->_collectionFactory->create()->joinData($this->_id);
            return $comments;
        }else{
            //if !isset Portfolio Id =>die();
            die();
        }
    }
}
