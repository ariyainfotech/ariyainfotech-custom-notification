<?php
/**
 * Copyright © Yuvraj Raulji All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace AriyaInfoTech\Notification\Block\Index;

class Index extends \Magento\Framework\View\Element\Template
{
	
	protected $_notificationHelper;
	
    /**
     * Constructor
     *
     * @param \Magento\Framework\View\Element\Template\Context  $context
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
		\AriyaInfoTech\Notification\Helper\Data $notificationHelper,
        array $data = []
    ) {
		$this->_notificationHelper = $notificationHelper;
        parent::__construct($context, $data);
    }
	
	protected function _prepareLayout(){
        parent::_prepareLayout();
        if ($this->getNotificationCollection()) {
            $pager = $this->getLayout()->createBlock(
                'Magento\Theme\Block\Html\Pager',
                'custom.history.pager'
            )->setAvailableLimit([5 => 5, 10 => 10, 15 => 15, 20 => 20])
                ->setShowPerPage(true)->setCollection(
                    $this->getNotificationCollection()
                );
            $this->setChild('pager', $pager);
            $this->getNotificationCollection()->load();
        }
        return $this;
    }
	
	public function getNotificationCollection(){
		try{
			$page = ($this->getRequest()->getParam('p')) ? $this->getRequest()->getParam('p') : 1;
			$pageSize = ($this->getRequest()->getParam('limit')) ? $this->getRequest()->getParam('limit') : 5;
			$customerId = $this->_notificationHelper->getCurrentCustomerId();
			$notificationcollection = $this->_notificationHelper->getNotificationCollection();
			$notificationcollection->addFieldToFilter('customer_id', $customerId);
			$notificationcollection->setOrder('created_at','DESC');
			$notificationcollection->setPageSize($pageSize);
			$notificationcollection->setCurPage($page);
				foreach($notificationcollection as $notification){
					$notification->setStatus('1');
				}
				$notificationcollection->save();
			return $notificationcollection;
		}catch (\Exception $e){
			return false;
		}
	}

	public function setDateFormate($date){
		return $this->_notificationHelper->setDateFormate($date);
	}

}