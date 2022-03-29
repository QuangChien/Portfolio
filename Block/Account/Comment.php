<?php

namespace Ecentura\Portfolio\Block\Account;

class Comment extends \Magento\Framework\View\Element\Template
{
    protected $_collectionFactory;
    protected $_customerSession;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Customer\Model\Session $session,
        \Ecentura\Portfolio\Model\ResourceModel\Comment\CollectionFactory $collectionFactory
    )
    {
        $this->_collectionFactory = $collectionFactory;
        $this->_customerSession = $session;
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

    //get Id Customer current login
    public function getCustomerId()
    {
        //if isset customer is logining => get id customer
        if($this->checkLogin()){
            return $this->_customerSession->getCustomer()->getId();
        }else{
            return 0;
        }
    }

    //get all comment of account is logining
    public function getCommentData()
    {
        $comments = $this->_collectionFactory->create()->joinDataWithPortfolio($this->getCustomerId());
        return $comments;
    }

}
