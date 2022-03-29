<?php
namespace Ecentura\Portfolio\Model\Portfolio;

use Ecentura\Portfolio\Model\ResourceModel\Portfolio\CollectionFactory;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    protected $_loadedData;
    protected $_storeManager;
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        array $meta = [],
        array $data = [],
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        $this->collection = $collectionFactory->create();
        $this->_storeManager = $storeManager;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->_loadedData)) {
            return $this->_loadedData;
        }
        $items = $this->collection->getItems();
//        echo "<pre>";
//        print_r($items->getData()); die();
        foreach ($items as $item) {
            if ($item->getThumbnail()) {
                $thumbnail['thumbnail'][0]['name'] = $item->getThumbnail();
                $thumbnail['thumbnail'][0]['url'] = $this->getMediaUrl()."encentura/tmp/feature/".$item->getThumbnail();
                $fullData = $item->getData();
                $this->_loadedData[$item->getId()] = array_merge($fullData, $thumbnail);
            }

            if($item->getImage()) {
                $arrImage = explode(",",$item->getImage());
                foreach ($arrImage as $key => $arrImageItem){
                    $img['image'][$key]['name'] = $arrImageItem;
                    $img['image'][$key]['url'] = $this->getMediaUrl()."encentura/tmp/feature/".$arrImageItem;
                }
                $this->_loadedData[$item->getId()] = array_merge($this->_loadedData[$item->getId()], $img);
            }
        }
        return $this->_loadedData;

    }

    public function getMediaUrl()
    {
        return $this ->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
    }
}
