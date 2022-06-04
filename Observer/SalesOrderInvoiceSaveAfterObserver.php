<?php

namespace AriyaInfoTech\Notification\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Session\SessionManager;
use Magento\Quote\Model\QuoteRepository;

class SalesOrderInvoiceSaveAfterObserver implements ObserverInterface
{
	 /**
     * @var eventManager
     */
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
			$event = $observer->getInvoice();
			$invoice = $observer->getEvent()->getInvoice();
			$invoiceId = $observer->getInvoice()->getId();
			$invoiceIncrementId = $observer->getInvoice()->getIncrementId();
			$order = $observer->getInvoice()->getOrder();
			$lastOrderId = $order->getId();
			$customerId = $order->getCustomerId();
			$order_id = $order->getEntityId();
			$websiteid = $this->_notificationHelper->getCurrentWebsiteId();
			$store_code = $this->_notificationHelper->getCurrentStoreCode();
			
			$message = 'Your Invoice #'.$invoiceIncrementId.' has been created.';
			$data = array("type"=>'invoice',"message"=>$message,"message_label"=>'Invoice Created',"status"=>'0',"customer_id"=>$customerId,"store_code"=>$store_code,"website_id"=>$websiteid,"order_id"=>$order_id);
			$this->_notificationHelper->setNotification($data);
		}catch(\Exception $e){
		}
		return $this;
	}
}