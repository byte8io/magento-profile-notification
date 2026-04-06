<?php
/**
 * Copyright © Byte8 Ltd. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace Byte8\ProfileNotification\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Notification Resource Model
 */
class Notification extends AbstractDb
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'byte8_profile_notification_resource';

    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init('byte8_profile_notification', 'notification_id');
    }
}