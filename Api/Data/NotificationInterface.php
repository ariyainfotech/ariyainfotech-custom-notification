<?php
/**
 * Copyright © Yuvraj Raulji All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace AriyaInfoTech\Notification\Api\Data;

interface NotificationInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{

    const MESSAGE = 'message';
    const UPDATE_AT = 'update_at';
    const STATUS = 'status';
    const CREATED_AT = 'created_at';
    const TYPE = 'type';
    const CUSTOMER_ID = 'customer_id';
    const NOTIFICATION_ID = 'notification_id';

    /**
     * Get notification_id
     * @return string|null
     */
    public function getNotificationId();

    /**
     * Set notification_id
     * @param string $notificationId
     * @return \AriyaInfoTech\Notification\Api\Data\NotificationInterface
     */
    public function setNotificationId($notificationId);

    /**
     * Get type
     * @return string|null
     */
    public function getType();

    /**
     * Set type
     * @param string $type
     * @return \AriyaInfoTech\Notification\Api\Data\NotificationInterface
     */
    public function setType($type);

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \AriyaInfoTech\Notification\Api\Data\NotificationExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * Set an extension attributes object.
     * @param \AriyaInfoTech\Notification\Api\Data\NotificationExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \AriyaInfoTech\Notification\Api\Data\NotificationExtensionInterface $extensionAttributes
    );

    /**
     * Get message
     * @return string|null
     */
    public function getMessage();

    /**
     * Set message
     * @param string $message
     * @return \AriyaInfoTech\Notification\Api\Data\NotificationInterface
     */
    public function setMessage($message);

    /**
     * Get created_at
     * @return string|null
     */
    public function getCreatedAt();

    /**
     * Set created_at
     * @param string $createdAt
     * @return \AriyaInfoTech\Notification\Api\Data\NotificationInterface
     */
    public function setCreatedAt($createdAt);

    /**
     * Get update_at
     * @return string|null
     */
    public function getUpdateAt();

    /**
     * Set update_at
     * @param string $updateAt
     * @return \AriyaInfoTech\Notification\Api\Data\NotificationInterface
     */
    public function setUpdateAt($updateAt);

    /**
     * Get status
     * @return string|null
     */
    public function getStatus();

    /**
     * Set status
     * @param string $status
     * @return \AriyaInfoTech\Notification\Api\Data\NotificationInterface
     */
    public function setStatus($status);

    /**
     * Get customer_id
     * @return string|null
     */
    public function getCustomerId();

    /**
     * Set customer_id
     * @param string $customerId
     * @return \AriyaInfoTech\Notification\Api\Data\NotificationInterface
     */
    public function setCustomerId($customerId);
}

