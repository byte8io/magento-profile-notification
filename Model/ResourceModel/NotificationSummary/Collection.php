<?php
/**
 * Copyright © Byte8 Ltd. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace Byte8\ProfileNotification\Model\ResourceModel\NotificationSummary;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Byte8\ProfileNotification\Model\NotificationSummary;
use Byte8\ProfileNotification\Model\ResourceModel\NotificationSummary as NotificationSummaryResource;

/**
 * Notification Summary Collection
 */
class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'summary_id';

    /**
     * @var string
     */
    protected $_eventPrefix = 'byte8_profile_notification_summary_collection';

    /**
     * @var string
     */
    protected $_eventObject = 'notification_summary_collection';

    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init(NotificationSummary::class, NotificationSummaryResource::class);
    }
}