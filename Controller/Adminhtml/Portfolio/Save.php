<?php

namespace Ecentura\Portfolio\Controller\Adminhtml\Portfolio;

use Ecentura\Portfolio\Model\PortfolioFactory;
use Magento\Backend\App\Action;

class Save extends Action
{
    private $_portfolioFactory;
    protected $data;

    public function __construct(
        Action\Context $context,
        PortfolioFactory $portfolioFactory
    )
    {
        parent::__construct($context);
        $this->_portfolioFactory = $portfolioFactory;
    }

    public function execute()
    {
        //get data submit
        $this->data = $this->getRequest()->getPostValue();

        //get id submit: if isset id => add, !isset id => edit(return id = null)
        $id = !empty($this->data['portfolio_id']) ? $this->data['portfolio_id'] : null;

        //save data submit in 1 array
        $newData = [
            'client' => $this->data['client'],
            'project' => $this->data['project'],
            'skill' => $this->data['skill'],
            'status' => $this->data['status'],
            'content' => $this->data['content'],
            'portfolio_category_id' => $this->data['portfolio_category_id'],

            //if isset thumbnail =>get thumbnail name, else => return string empty
            'thumbnail' => isset($this->data['thumbnail'][0]) ? $this->data['thumbnail'][0]['name'] : '',

//          //get Image Name
            'image' => $this->getImageName()
        ];

        //create object model
        $portfolio = $this->_portfolioFactory->create();

        //if isset id => load object by id
        if ($id) {
            $portfolio->load($id);
        }
        try {
            //save data
            $portfolio->addData($newData);
            $portfolio->save();
            $this->messageManager->addSuccessMessage(__('Save Success'));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__($e->getMessage()));
        }

        return $this->redirectToIndex();
    }

    public function redirectToIndex()
    {
        return $this->resultRedirectFactory->create()->setPath('ecentura_portfolio/portfolio/index');
    }

    public function getImageName()
    {
        //if compare image upload < 2 && >=1(upload 1 image) get name of this image
        if (empty($data['image']) && count($this->data['image']) < 2) {
            $image = $this->data['image'][0]['name'];
        } else {
            $imageArr = [];
            //if compare image upload >= 2 =>forearch array to save name in $imageArr
            foreach ($this->data['image'] as $imageItem) {
                array_push($imageArr, $imageItem['name']);
            }

            //join all value in array $imageArr to string
            $image = implode(",", $imageArr);
        }

        return $image;
    }

    //Check rule (ACL)
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Ecentura_Portfolio::portfolio');
    }
}
