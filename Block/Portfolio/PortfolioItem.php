<?php

namespace Ecentura\Portfolio\Block\Portfolio;
use Ecentura\Portfolio\Model\PortfolioFactory;

class PortfolioItem extends \Magento\Framework\View\Element\Template
{
    protected $_portfolio;
    protected $_redirect;
    protected $_response;
    protected $_storeManager;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        PortfolioFactory $portfolioFactory,
        \Magento\Framework\App\Response\Http $response,
        \Magento\Framework\App\Response\RedirectInterface $redirect,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    )
    {
        $this->_portfolio = $portfolioFactory;
        $this->_redirect = $redirect;
        $this->_response = $response;
        $this->_storeManager = $storeManager;
        parent::__construct($context);
    }

    //get path pub/media
    public function getMediaUrl()
    {
        return $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
    }


    public function getPortfolioItem()
    {
        $portfolioData = [];

        //get id in path
        $id = $this->getRequest()->getParam('id') ? $this->getRequest()->getParam('id') : '';

        //if isset id in the path
        if ($id) {
            //create object with that id
            $portfolioItem = $this->_portfolio->create()->load($id);

            //if isset data with id that then get field content and image
            if (!$portfolioItem->isEmpty()) {
                $portfolioContent = $portfolioItem->getDataByKey('content');
                $portfolioImages = $portfolioItem->getDataByKey('image');

                //split string image into 1 array
                $arrImageName = explode(",", $portfolioImages);

                $portfolioData['portfolioContent'] = $portfolioContent;
                $portfolioData['portfolioImages'] = $arrImageName;

                return $portfolioData;
            } else {
                $this->redirectToList();
            }
        } else {
            $this->redirectToList();
        }
    }

    //redirect to portfolio list
    public function redirectToList()
    {
        $this->_redirect->redirect($this->_response, 'portfolio/portfolio/portfoliolist');
    }
}
