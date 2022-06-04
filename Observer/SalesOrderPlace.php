<?php

namespace AriyaInfoTech\Notification\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\ObjectManager;

class SalesOrderPlace implements \Magento\Framework\Event\ObserverInterface
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
			/* @var $order \Magento\Sales\Model\Order */
			$order = $observer->getEvent()->getData('order');
			$lastOrderId = $observer->getOrder()->getId();
			$websiteid = $this->_notificationHelper->getCurrentWebsiteId();
			$store_code = $this->_notificationHelper->getCurrentStoreCode();
			$customerId = $order->getCustomerId();
			$incrementId = $order->getIncrementId();
			$quote_id = $order->getQuoteId();
			$message = 'Your Order #'.$incrementId.' has been placed successully.';
			$data = array("type"=>'order_place',"message"=>$message,"message_label"=>'Order Placed',"status"=>'0',"customer_id"=>$customerId,"store_code"=>$store_code,"website_id"=>$websiteid,"quote_id"=>$quote_id);
			$this->_notificationHelper->setNotification($data);
		}catch (\Exception $e){
			
		}
		return $this;
	}
}