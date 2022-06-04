<?php
/**
 * Copyright © Yuvraj Raulji All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace AriyaInfoTech\Notification\Model;

use AriyaInfoTech\Notification\Api\Data\NotificationInterface;
use AriyaInfoTech\Notification\Api\Data\NotificationInterfaceFactory;
use Magento\Framework\Api\DataObjectHelper;

class Notification extends \Magento\Framework\Model\AbstractModel
{

    protected $dataObjectHelper;

    protected $notificationDataFactory;

    protected $_eventPrefix = 'ariyainfotech_notification_notification';

    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param NotificationInterfaceFactory $notificationDataFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param \AriyaInfoTech\Notification\Model\ResourceModel\Notification $resource
     * @param \AriyaInfoTech\Notification\Model\ResourceModel\Notification\Collection $resourceCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        NotificationInterfaceFactory $notificationDataFactory,
        DataObjectHelper $dataObjectHelper,
        \AriyaInfoTech\Notification\Model\ResourceModel\Notification $resource,
        \AriyaInfoTech\Notification\Model\ResourceModel\Notification\Collection $resourceCollection,
        array $data = []
    ) {
        $this->notificationDataFactory = $notificationDataFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * Retrieve notification model with notification data
     * @return NotificationInterface
     */
    public function getDataModel()
    {
        $notificationData = $this->getData();
        
        $notificationDataObject = $this->notificationDataFactory->create();
        $this->dataObjectHelper->populateWithArray(
            $notificationDataObject,
            $notificationData,
            NotificationInterface::class
        );
        
        return $notificationDataObject;
    }
}

