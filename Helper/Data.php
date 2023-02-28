<?php
/**
 * Copyright © Yuvraj Raulji All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace AriyaInfoTech\Notification\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

class Data extends AbstractHelper
{
	protected $_notificationModel;
	
	protected $_customerSession;
	
	protected $_storeManager;
	
	protected $_notificationCollection;
	
	protected $_timezone;
	
	protected $_customerRepository;
	
	protected $_priceFormate;
	
    /**
     * @param \Magento\Framework\App\Helper\Context $context
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
		\Psr\Log\LoggerInterface $logger,
		\Magento\Customer\Model\Session $customerSession,
		\Magento\Store\Model\StoreManagerInterface $storeManager,
		\AriyaInfoTech\Notification\Model\Notification $notificationModel,
		\Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezone,
		\Magento\Customer\Api\CustomerRepositoryInterface $customerRepository,
		\Magento\Framework\Pricing\Helper\Data $priceFormate,
		\AriyaInfoTech\Notification\Model\ResourceModel\Notification\CollectionFactory $notificationCollection
    ) {
		$this->_notificationModel = $notificationModel;
		$this->_logger = $logger;
		$this->_customerSession = $customerSession;
		$this->_storeManager= $storeManager;
		$this->_notificationCollection = $notificationCollection;
		$this->_customerRepository = $customerRepository;
		$this->_timezone = $timezone;
		$this->_priceFormate = $priceFormate;
        parent::__construct($context);
    }

    /**
     * @return bool
     */
    public function isEnabled(){
        return true;
    }
	
	public function setNotification($data){
		try{
			$this->_notificationModel->setData($data);
			$this->_notificationModel->save();
			return true;
		}catch (\Exception $e){
			$this->_logger->error("Notification_Data setNotification : ".$e->getMessage());
			return false;
		}
	}
	
	public function getCurrentCustomerId(){
		if($this->_customerSession->isLoggedIn()){
			return $this->_customerSession->getCustomer()->getId();
		}
		return false;
	}
	
	/**
     * Get Current Code identifier
     * @return  varchar
    */
	public function getCurrentStoreCode(){
		return $this->_storeManager->getGroup()->getCode();
	}
	
	/**
     * Get Current store identifier
     *
     * @return  int
    */
	public function getCurrentStoreId(){
		return $this->_storeManager->getStore()->getId();
	}
	
	/**
     * Get Current Wensite Id identifier
     * @return  int
    */
	public function getCurrentWebsiteId(){
		return $this->_storeManager->getStore()->getWebsiteId();
	}
	
	/* 
	* Item Details Collection
	*/
	public function getNotificationCollection(){
		try{
			return $this->_notificationCollection->create();
		}catch (\Exception $e){
			$this->_logger->error("AriyaInfoTech\Nofi getNotificationCollection : ".$e->getMessage());
			return false;
		}
	}
	
	public function setDateFormate($yourdate){
		return $this->_timezone->date(new \DateTime($yourdate))->format('d M Y');
	}
	
	public function getPendingShowNotification(){
		try{
			if($this->getCurrentCustomerId()):
				$customerId = $this->getCurrentCustomerId();
				$notificationcollection = $this->getNotificationCollection();
				$notificationcollection->addFieldToFilter('customer_id', $customerId);
				$notificationcollection->addFieldToFilter('status', '0');
				return $notificationcollection->count();
			endif;
		}catch(\Exception $e){
			return false;
		}
		return false;
	}
	
	/*
	* get customer Id to get Email Id
	*/
	public function getCustomerIdToEmailId($customerId){
		try{
			$customerData = $this->customerIdToDetails($customerId);
			if($customerData){
				return $customerData->getEmail();	
			}
			return false;
		}catch (\Exception $e){
			$this->_logger->error("Helper_Data_notification getCustomerIdToEmailId : ".$e->getMessage());
			return false;
		}	
	}
	
	public function customerIdToDetails($getId){
		try{
			return $this->_customerRepository->getById($getId);
		}catch (\Exception $e){
			$this->_logger->error("Helper_Data_notification customerIdToDetails : ".$e->getMessage());
			return false;
		}
	}
	
	public function setPriceFormate($price){
		return $this->_priceFormate->currency($price, true, false);
	}

	const XML_PATH_NOTIFICATION = 'notification/';

	public function getConfigValue($field, $storeId = null){
		return $this->scopeConfig->getValue($field, ScopeInterface::SCOPE_STORE, $storeId);
	}

	public function getGeneralConfig($code, $storeId = null){
		return $this->getConfigValue(self::XML_PATH_NOTIFICATION .'general/'. $code, $storeId);
	}
}

