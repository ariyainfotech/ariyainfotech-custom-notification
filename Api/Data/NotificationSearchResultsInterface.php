<?php
/**
 * Copyright © Yuvraj Raulji All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace AriyaInfoTech\Notification\Api\Data;

interface NotificationSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get Notification list.
     * @return \AriyaInfoTech\Notification\Api\Data\NotificationInterface[]
     */
    public function getItems();

    /**
     * Set type list.
     * @param \AriyaInfoTech\Notification\Api\Data\NotificationInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}

