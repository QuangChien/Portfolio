<?php
namespace Ecentura\Portfolio\Controller\Account\Comment;

use Magento\Framework\App\ResponseInterface;

class Delete extends \Magento\Framework\App\Action\Action
{
    protected $_commentFactory;
    protected $_customerSession;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Customer\Model\Session $session,
        \Ecentura\Portfolio\Model\CommentFactory $commentFactory
    )
    {
        $this->_commentFactory = $commentFactory;
        $this->_customerSession = $session;
        return parent::__construct($context);


    }

    public function execute()
    {
        //nếu mà đã login
        if($this->checkLogin()){
            //lấy id
            $id = $this->getRequest()->getParam('id');

            //nếu có id thì load đối tượng có id đó
            if($id){
                $comment = $this->_commentFactory->create()->load($id);

                //nếu comment load được không rỗng và trường Customer_id = id của tài khoản đang login thì được phép xóa
                if(!$comment->isEmpty() && $comment->getCustomerId() == $this->getCustomerId()){
                    try {
                        $comment->delete();
                        $this->messageManager->addSuccessMessage("Delete successfully!");
                    } catch (\Exception $e) {
                        $this->messageManager->addErrorMessage(__("Error Delete!"));
                    }
                }else{
                    $this->messageManager->addErrorMessage(__("Error Delete!"));
                    return $this->redirect();
                }
            }else{
                return $this->redirect();
            }
        }else{
            return $this->redirect();
        }

        return $this->redirect();
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

    //lấy customer hiện tại
    public function getCustomerId()
    {
        if($this->checkLogin()){
            return $this->_customerSession->getCustomer()->getId();
        }else{
            return false;
        }
    }

    public function redirect()
    {
        $redirect = $this->resultRedirectFactory->create();
        $redirect->setRefererUrl();
        return $redirect;
    }
}
