<?php
/**
 * Copyright © Yuvraj Raulji All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace AriyaInfoTech\Notification\Model;

use AriyaInfoTech\Notification\Api\Data\NotificationInterfaceFactory;
use AriyaInfoTech\Notification\Api\Data\NotificationSearchResultsInterfaceFactory;
use AriyaInfoTech\Notification\Api\NotificationRepositoryInterface;
use AriyaInfoTech\Notification\Model\ResourceModel\Notification as ResourceNotification;
use AriyaInfoTech\Notification\Model\ResourceModel\Notification\CollectionFactory as NotificationCollectionFactory;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\ExtensibleDataObjectConverter;
use Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Store\Model\StoreManagerInterface;

class NotificationRepository implements NotificationRepositoryInterface
{

    protected $resource;

    private $collectionProcessor;

    protected $extensibleDataObjectConverter;
    protected $notificationFactory;

    protected $extensionAttributesJoinProcessor;

    protected $dataObjectProcessor;

    protected $dataObjectHelper;

    protected $searchResultsFactory;

    protected $dataNotificationFactory;

    protected $notificationCollectionFactory;

    private $storeManager;


    /**
     * @param ResourceNotification $resource
     * @param NotificationFactory $notificationFactory
     * @param NotificationInterfaceFactory $dataNotificationFactory
     * @param NotificationCollectionFactory $notificationCollectionFactory
     * @param NotificationSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     * @param CollectionProcessorInterface $collectionProcessor
     * @param JoinProcessorInterface $extensionAttributesJoinProcessor
     * @param ExtensibleDataObjectConverter $extensibleDataObjectConverter
     */
    public function __construct(
        ResourceNotification $resource,
        NotificationFactory $notificationFactory,
        NotificationInterfaceFactory $dataNotificationFactory,
        NotificationCollectionFactory $notificationCollectionFactory,
        NotificationSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager,
        CollectionProcessorInterface $collectionProcessor,
        JoinProcessorInterface $extensionAttributesJoinProcessor,
        ExtensibleDataObjectConverter $extensibleDataObjectConverter
    ) {
        $this->resource = $resource;
        $this->notificationFactory = $notificationFactory;
        $this->notificationCollectionFactory = $notificationCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataNotificationFactory = $dataNotificationFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->storeManager = $storeManager;
        $this->collectionProcessor = $collectionProcessor;
        $this->extensionAttributesJoinProcessor = $extensionAttributesJoinProcessor;
        $this->extensibleDataObjectConverter = $extensibleDataObjectConverter;
    }

    /**
     * {@inheritdoc}
     */
    public function save(
        \AriyaInfoTech\Notification\Api\Data\NotificationInterface $notification
    ) {
        /* if (empty($notification->getStoreId())) {
            $storeId = $this->storeManager->getStore()->getId();
            $notification->setStoreId($storeId);
        } */
        
        $notificationData = $this->extensibleDataObjectConverter->toNestedArray(
            $notification,
            [],
            \AriyaInfoTech\Notification\Api\Data\NotificationInterface::class
        );
        
        $notificationModel = $this->notificationFactory->create()->setData($notificationData);
        
        try {
            $this->resource->save($notificationModel);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the notification: %1',
                $exception->getMessage()
            ));
        }
        return $notificationModel->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function get($notificationId)
    {
        $notification = $this->notificationFactory->create();
        $this->resource->load($notification, $notificationId);
        if (!$notification->getId()) {
            throw new NoSuchEntityException(__('Notification with id "%1" does not exist.', $notificationId));
        }
        return $notification->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->notificationCollectionFactory->create();
        
        $this->extensionAttributesJoinProcessor->process(
            $collection,
            \AriyaInfoTech\Notification\Api\Data\NotificationInterface::class
        );
        
        $this->collectionProcessor->process($criteria, $collection);
        
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        
        $items = [];
        foreach ($collection as $model) {
            $items[] = $model->getDataModel();
        }
        
        $searchResults->setItems($items);
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(
        \AriyaInfoTech\Notification\Api\Data\NotificationInterface $notification
    ) {
        try {
            $notificationModel = $this->notificationFactory->create();
            $this->resource->load($notificationModel, $notification->getNotificationId());
            $this->resource->delete($notificationModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the Notification: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($notificationId)
    {
        return $this->delete($this->get($notificationId));
    }
}

