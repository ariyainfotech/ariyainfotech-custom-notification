<?php
/**
 * Copyright © Yuvraj Raulji All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace AriyaInfoTech\Notification\Model\Data;

use AriyaInfoTech\Notification\Api\Data\NotificationInterface;

class Notification extends \Magento\Framework\Api\AbstractExtensibleObject implements NotificationInterface
{

    /**
     * Get notification_id
     * @return string|null
     */
    public function getNotificationId()
    {
        return $this->_get(self::NOTIFICATION_ID);
    }

    /**
     * Set notification_id
     * @param string $notificationId
     * @return \AriyaInfoTech\Notification\Api\Data\NotificationInterface
     */
    public function setNotificationId($notificationId)
    {
        return $this->setData(self::NOTIFICATION_ID, $notificationId);
    }

    /**
     * Get type
     * @return string|null
     */
    public function getType()
    {
        return $this->_get(self::TYPE);
    }

    /**
     * Set type
     * @param string $type
     * @return \AriyaInfoTech\Notification\Api\Data\NotificationInterface
     */
    public function setType($type)
    {
        return $this->setData(self::TYPE, $type);
    }

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \AriyaInfoTech\Notification\Api\Data\NotificationExtensionInterface|null
     */
    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * Set an extension attributes object.
     * @param \AriyaInfoTech\Notification\Api\Data\NotificationExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \AriyaInfoTech\Notification\Api\Data\NotificationExtensionInterface $extensionAttributes
    ) {
        return $this->_setExtensionAttributes($extensionAttributes);
    }

    /**
     * Get message
     * @return string|null
     */
    public function getMessage()
    {
        return $this->_get(self::MESSAGE);
    }

    /**
     * Set message
     * @param string $message
     * @return \AriyaInfoTech\Notification\Api\Data\NotificationInterface
     */
    public function setMessage($message)
    {
        return $this->setData(self::MESSAGE, $message);
    }

    /**
     * Get created_at
     * @return string|null
     */
    public function getCreatedAt()
    {
        return $this->_get(self::CREATED_AT);
    }

    /**
     * Set created_at
     * @param string $createdAt
     * @return \AriyaInfoTech\Notification\Api\Data\NotificationInterface
     */
    public function setCreatedAt($createdAt)
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }

    /**
     * Get update_at
     * @return string|null
     */
    public function getUpdateAt()
    {
        return $this->_get(self::UPDATE_AT);
    }

    /**
     * Set update_at
     * @param string $updateAt
     * @return \AriyaInfoTech\Notification\Api\Data\NotificationInterface
     */
    public function setUpdateAt($updateAt)
    {
        return $this->setData(self::UPDATE_AT, $updateAt);
    }

    /**
     * Get status
     * @return string|null
     */
    public function getStatus()
    {
        return $this->_get(self::STATUS);
    }

    /**
     * Set status
     * @param string $status
     * @return \AriyaInfoTech\Notification\Api\Data\NotificationInterface
     */
    public function setStatus($status)
    {
        return $this->setData(self::STATUS, $status);
    }

    /**
     * Get customer_id
     * @return string|null
     */
    public function getCustomerId()
    {
        return $this->_get(self::CUSTOMER_ID);
    }

    /**
     * Set customer_id
     * @param string $customerId
     * @return \AriyaInfoTech\Notification\Api\Data\NotificationInterface
     */
    public function setCustomerId($customerId)
    {
        return $this->setData(self::CUSTOMER_ID, $customerId);
    }
}

