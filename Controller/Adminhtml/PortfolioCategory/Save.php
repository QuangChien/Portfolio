<?php

namespace Ecentura\Portfolio\Controller\Adminhtml\PortfolioCategory;

use Ecentura\Portfolio\Model\PortfolioCategoryFactory;
use Magento\Backend\App\Action;

class Save extends Action
{
    private $_portfolioCategoryFactory;

    public function __construct(
        Action\Context $context,
        PortfolioCategoryFactory $portfolioCategoryFactory
    ) {
        parent::__construct($context);
        $this->_portfolioCategoryFactory = $portfolioCategoryFactory;
    }

    public function execute()
    {
        //get data submit
        $data = $this->getRequest()->getPostValue();

        //get id submit
        $id = !empty($data['portfolio_category_id']) ? $data['portfolio_category_id'] : null;

        //save data submit in 1 array
        $newData = [
            'portfolio_category_name' => $data['portfolio_category_name'],
        ];

        //create object model
       $portfolioCategory = $this->_portfolioCategoryFactory->create();

        //if isset id => load object by id
        if ($id) {
            $portfolioCategory->load($id);
        }
        try {
            //save data
            $portfolioCategory->addData($newData);
            $portfolioCategory->save();
            $this->messageManager->addSuccessMessage(__('Save Success'));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__($e->getMessage()));
        }

        //redirect to Portfoli Index
        return $this->redirectToIndex();
    }

    public function redirectToIndex()
    {
        return $this->resultRedirectFactory->create()->setPath('ecentura_portfolio/portfoliocategory/index');
    }

    //Check role (ACL)
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Ecentura_Portfolio::portfolio');
    }
}
