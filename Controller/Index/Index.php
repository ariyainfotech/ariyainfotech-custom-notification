<?php
/**
 * Copyright © Yuvraj Raulji All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace AriyaInfoTech\Notification\Controller\Index;

class Index extends \Magento\Framework\App\Action\Action
{

    protected $resultPageFactory;
	
	protected $_notificationHelper;

    /**
     * Constructor
     *
     * @param \Magento\Framework\App\Action\Context  $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
		\AriyaInfoTech\Notification\Helper\Data $notificationHelper
    ) {
        $this->resultPageFactory = $resultPageFactory;
		$this->_notificationHelper = $notificationHelper;
        parent::__construct($context);
    }

    /**
     * Execute view action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
		$notificationEnableDisable = $this->_notificationHelper->getConfigValue('notification/general/enable');
        if($notificationEnableDisable == 1){
            if($this->_notificationHelper->getCurrentCustomerId()):
    			return $this->resultPageFactory->create();
    		endif;
            return $this->_redirect('customer/account');
        }elseif($notificationEnableDisable == 0){
            return $this->_redirect('customer/account');
        }
    }
}