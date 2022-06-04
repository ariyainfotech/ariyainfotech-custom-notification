<?php
/**
 * Copyright © Yuvraj Raulji All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace AriyaInfoTech\Notification\Model\ResourceModel\Notification;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    /**
     * @var string
     */
    protected $_idFieldName = 'notification_id';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            \AriyaInfoTech\Notification\Model\Notification::class,
            \AriyaInfoTech\Notification\Model\ResourceModel\Notification::class
        );
    }
}

