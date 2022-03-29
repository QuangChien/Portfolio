<?php
namespace Ecentura\Portfolio\Controller\Adminhtml\PortfolioCategory;

use Magento\Backend\App\Action;
use Ecentura\Portfolio\Model\ResourceModel\PortfolioCategory\CollectionFactory;
use Ecentura\Portfolio\Model\PortfolioCategoryFactory;
use Magento\Ui\Component\MassAction\Filter;
use Magento\Backend\Model\View\Result\RedirectFactory;

class Delete extends Action
{
    private $_portfolioCategoryFactory;
    private $_filter;
    private $_collectionFactory;
    private $_resultRedirect;

    public function __construct(
        Action\Context $context,
        PortfolioCategoryFactory $portfolioCategoryFactory,
        Filter $filter,
        CollectionFactory $collectionFactory,
        RedirectFactory $redirectFactory
    )
    {
        parent::__construct($context);
        $this->_portfolioCategoryFactory = $portfolioCategoryFactory;
        $this->_filter = $filter;
        $this->_collectionFactory = $collectionFactory;
        $this->_resultRedirect = $redirectFactory;
    }

    public function execute()
    {
        // get all portfolio category is selected
        $collection = $this->_filter->getCollection($this->_collectionFactory->create());
        $total = 0;
        $err = 0;

        //foreach and delete all portfolio category selected
        foreach ($collection->getItems() as $item) {
            $deleteportfolioCategory = $this->_portfolioCategoryFactory->create()->load($item->getData('portfolio_category_id'));
            try {
                $deleteportfolioCategory->delete();
                // $total + 1 => get total portfolio category show for user
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

        // $total + 1 => get total portfolio category show for user
        return $this->redirectToIndex();
    }

    public function redirectToIndex()
    {
        return $this->_resultRedirect->create()->setPath('ecentura_portfolio/portfoliocategory/index');
    }

    //Check rule (ACL)
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Ecentura_Portfolio::portfolio');
    }
}
