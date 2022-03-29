<?php
namespace Ecentura\Portfolio\Model;
class Portfolio extends \Magento\Framework\Model\AbstractModel
{
    protected function _construct()
    {
        $this->_init('Ecentura\Portfolio\Model\ResourceModel\Portfolio');
    }
}
