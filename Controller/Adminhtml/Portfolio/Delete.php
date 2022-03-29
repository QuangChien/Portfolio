<?php

namespace Ecentura\Portfolio\Controller\Adminhtml\Portfolio;

use Magento\Backend\App\Action;
use Ecentura\Portfolio\Model\ResourceModel\Portfolio\CollectionFactory;
use Ecentura\Portfolio\Model\PortfolioFactory;
use Magento\Ui\Component\MassAction\Filter;
use Magento\Backend\Model\View\Result\RedirectFactory;

class Delete extends Action
{
    private $_portfolioFactory;
    private $_filter;
    private $_collectionFactory;
    private $_resultRedirect;

    public function __construct(
        Action\Context $context,
        PortfolioFactory $portfolioFactory,
        Filter $filter,
        CollectionFactory $collectionFactory,
        RedirectFactory $redirectFactory
    )
    {
        parent::__construct($context);
        $this->_portfolioFactory = $portfolioFactory;
        $this->_filter = $filter;
        $this->_collectionFactory = $collectionFactory;
        $this->_resultRedirect = $redirectFactory;
    }

    public function execute()
    {
        // get all portfolio is selected
        $collection = $this->_filter->getCollection($this->_collectionFactory->create());
        $total = 0;
        $err = 0;

        //foreach and delete all portfolio selected
        foreach ($collection->getItems() as $item) {
            $deletePortfolio = $this->_portfolioFactory->create()->load($item->getData('portfolio_id'));
            try {
                $deletePortfolio->delete();

                // $total + 1 => get total portfolio show for user
                $total++;
            } catch (LocalizedException $exception) {
                $err++;
            }
        }

        if ($total) {
            $this->messageManager->addSuccessMessage(
                __('A total of %1 record(s) have been deleted.', $total)
            );
        }

        if ($err) {
            $this->messageManager->addErrorMessage(
                __(
                    'A total of %1 record(s) haven\'t been deleted. Please see server logs for more details.',
                    $err
                )
            );
        }
        return $this->redirectToIndex();
    }

    //redirect to portfolio index
    public function redirectToIndex()
    {
        return $this->_resultRedirect->create()->setPath('ecentura_portfolio/portfoliocategory/index');
    }

    //Check quyen (ACL)
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Ecentura_Portfolio::portfolio');
    }
}
