<?php
namespace AriyaInfoTech\Notification\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class BudgetRequest implements ObserverInterface
{
	protected $_eventManager;
	
	protected $_notificationHelper;
	
	public function __construct(
        \Magento\Framework\Event\Manager $eventManager,
		\AriyaInfoTech\Notification\Helper\Data $notificationHelper,
		\Psr\Log\LoggerInterface $logger
	) {
        $this->_eventManager = $eventManager;
		$this->logger = $logger;
		$this->_notificationHelper = $notificationHelper;
	}	
	
    public function execute(Observer $observer){
		try {
			$BudgetDetails = $observer->getEvent()->getBudgetdetails();
			$budget_amount = $BudgetDetails['budget_amount'];
			$budget_type = $BudgetDetails['budget_type'];
			$requester_id = $BudgetDetails['requester_id'];
			$approval_id = $BudgetDetails['approval_id'];
			
			$approvalids = explode(',',$approval_id);
			$budprice = $this->_notificationHelper->setPriceFormate($budget_amount);
			$emailid = $this->_notificationHelper->getCustomerIdToEmailId($requester_id);
			$websiteid = $this->_notificationHelper->getCurrentWebsiteId();
			$store_code = $this->_notificationHelper->getCurrentStoreCode();
			
			$message = 'You have added '.$budprice.' '.$budget_type.' Budget Request.';
			$data = array("type"=>'budget',"message"=>$message,"message_label"=>'Budget Increase Request',"status"=>'0',"customer_id"=>$requester_id,"store_code"=>$store_code,"website_id"=>$websiteid,"is_requester"=>'yes');
			$this->_notificationHelper->setNotification($data);
			foreach($approvalids as $ids):
				$messages = $emailid.' has been added new '.$budprice.' '.$budget_type.' Budget Request.';
				$data2 = array("type"=>'budget',"message"=>$messages,"message_label"=>'Budget Increase Request',"status"=>'0',"customer_id"=>$ids,"store_code"=>$store_code,"website_id"=>$websiteid,"is_requester"=>'no','requester_id'=>$requester_id);
				$this->_notificationHelper->setNotification($data2);
			endforeach;
		} catch (\Exception $e) {
            $this->logger->critical($e->getMessage());
        }
		return $this;
    }
}