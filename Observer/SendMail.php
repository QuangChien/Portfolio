<?php

namespace Ecentura\Portfolio\Observer;

use Magento\Framework\Event\Observer;
use Magento\Shipping\Controller\Adminhtml\Order\Shipment\Save;
use Ecentura\Portfolio\Helper\Data;

class SendMail implements \Magento\Framework\Event\ObserverInterface
{
    private $_data;

    public function __construct(
        Data $data
    ) {
        $this->_data = $data;
    }

    public function execute(Observer $observer)
    {
        $shipment = $observer->getEvent()->getShipment();
        $order = $shipment->getOrder();
        $customerEmail = $order->getCustomerEmail();
        $tracks = $shipment->getTracksCollection()->getItems();

        if (!empty($tracks)) {
            $this->_data->sendMail($customerEmail, $tracks);
        }
    }
}
