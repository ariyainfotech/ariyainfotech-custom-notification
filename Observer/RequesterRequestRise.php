<?php
namespace AriyaInfoTech\Notification\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class RequesterRequestRise implements ObserverInterface
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
	
    public function execute(Observer $observer)
    {
        $request = $observer->getEvent()->getRequest();
        
		$requestid = $request['request_id'];
		$approval_id = $request['approval_id'];
		$requester_id = $request['requester_id'];
		$quote_id= $request['quote_id'];
		$approvalids = explode(',',$approval_id);
		
		$websiteid = $this->_notificationHelper->getCurrentWebsiteId();
		$store_code = $this->_notificationHelper->getCurrentStoreCode();
		
		$message = 'Your Request #'.$requestid.' has been created.';
		$data = array("type"=>'request',"message"=>$message,"message_label"=>'Order Request',"status"=>'0',"customer_id"=>$requester_id,"store_code"=>$store_code,"website_id"=>$websiteid,"request_id"=>$requestid,"quote_id"=>$quote_id);
		$this->_notificationHelper->setNotification($data);
		foreach($approvalids as $approvalid):
			$message = 'New Request #'.$requestid.' Received';
			$data = array("type"=>'request',"message"=>$message,"message_label"=>'Order Request',"status"=>'0',"customer_id"=>$approvalid,"store_code"=>$store_code,"website_id"=>$websiteid,"request_id"=>$requestid,"quote_id"=>$quote_id);
			$this->_notificationHelper->setNotification($data);
		endforeach;

        return $this;
    }
}