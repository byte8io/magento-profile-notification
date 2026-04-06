<?php
/**
 * Copyright © Byte8 Ltd. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace Byte8\ProfileNotification\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Notification Summary Resource Model
 */
class NotificationSummary extends AbstractDb
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'byte8_profile_notification_summary_resource';

    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init('byte8_profile_notification_summary', 'summary_id');
    }

    /**
     * Load summary by process ID
     *
     * @param string $processId
     * @return array
     */
    public function loadByProcessId(string $processId): array
    {
        $connection = $this->getConnection();
        $select = $connection->select()
            ->from($this->getMainTable())
            ->where('process_id = ?', $processId);
        
        return $connection->fetchRow($select) ?: [];
    }
}