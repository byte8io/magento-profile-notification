<?php
/**
 * Copyright © Byte8 Ltd. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace Byte8\ProfileNotification\Model\ResourceModel\Notification;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Byte8\ProfileNotification\Model\Notification;
use Byte8\ProfileNotification\Model\ResourceModel\Notification as NotificationResource;

/**
 * Notification Collection
 */
class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'notification_id';

    /**
     * @var string
     */
    protected $_eventPrefix = 'byte8_profile_notification_collection';

    /**
     * @var string
     */
    protected $_eventObject = 'notification_collection';

    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init(Notification::class, NotificationResource::class);
    }
}