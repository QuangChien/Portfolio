<?php

namespace Ecentura\Portfolio\Controller\Adminhtml\Comment;

use Magento\Backend\App\Action;
use Ecentura\Portfolio\Model\ResourceModel\Comment\CollectionFactory;
use Ecentura\Portfolio\Model\CommentFactory;
use Magento\Ui\Component\MassAction\Filter;
use Magento\Backend\Model\View\Result\RedirectFactory;

class Delete extends Action
{
    private $_commentFactory;
    private $_filter;
    private $_collectionFactory;
    private $_resultRedirect;

    public function __construct(
        Action\Context $context,
        CommentFactory $commentFactory,
        Filter $filter,
        CollectionFactory $collectionFactory,
        RedirectFactory $redirectFactory
    )
    {
        parent::__construct($context);
        $this->_commentFactory = $commentFactory;
        $this->_filter = $filter;
        $this->_collectionFactory = $collectionFactory;
        $this->_resultRedirect = $redirectFactory;
    }

    public function execute()
    {
        $collection = $this->_filter->getCollection($this->_collectionFactory->create());
        $total = 0;
        $err = 0;
        foreach ($collection->getItems() as $item) {
            $deleteComment = $this->_commentFactory->create()->load($item->getData('comment_id'));
            try {
                $deleteComment->delete();
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
        return $this->_resultRedirect->create()->setPath('ecentura_portfolio/comment/index');
    }
}
