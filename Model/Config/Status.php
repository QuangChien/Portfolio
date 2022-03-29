<?php
namespace Ecentura\Portfolio\Model\Config;

class Status implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @return array[]
     */
    public function toOptionArray()
    {
        return [
            ['value' => 1, 'label' => __('Published')],
            ['value' => 0, 'label' => __('Pending')]
        ];
    }
}
