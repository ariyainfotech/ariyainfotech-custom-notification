<?php

namespace AriyaInfoTech\Notification\Observer;

use Magento\Framework\Event\ObserverInterface;

class SalesOrderShipmentSaveAfterObserver implements ObserverInterface
{
	protected $_eventManager;
	protected $_notificationHelper;
		
	public function __construct(
        \Magento\Framework\Event\Manager $eventManager,
		\AriyaInfoTech\Notification\Helper\Data $notificationHelper
	) {
        $this->_eventManager = $eventManager;
		$this->_notificationHelper = $notificationHelper;
	}
	
    public function execute(\Magento\Framework\Event\Observer $observer){
		try{	
			$shipment = $observer->getEvent()->getShipment();
			$shipmentId = $shipment->getId();
			$shipmentIncId = $shipment->getIncrementId();
			$order = $shipment->getOrder();
			$customerId = $order->getCustomerId();
            $order_id = $order->getEntityId();
			$websiteid = $this->_notificationHelper->getCurrentWebsiteId();
			$store_code = $this->_notificationHelper->getCurrentStoreCode();
			
			$message = 'Your Shipment #'.$shipmentIncId.' has been Created successully.';
			$data = array("type"=>'shipment',"message"=>$message,"message_label"=>'Shipment Created',"status"=>'0',"customer_id"=>$customerId,"store_code"=>$store_code,"website_id"=>$websiteid,"order_id"=>$order_id);
			$this->_notificationHelper->setNotification($data);
			
		}catch(\Exception $e){
		    return $this;
	    }	
        return $this;
    }
}