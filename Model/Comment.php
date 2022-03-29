<?php
namespace Ecentura\Portfolio\Model;
class Comment extends \Magento\Framework\Model\AbstractModel
{
    protected function _construct()
    {
        $this->_init('Ecentura\Portfolio\Model\ResourceModel\Comment');
    }
}
