<?php
/**
 * Copyright © Byte8 Ltd. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace Byte8\ProfileNotification\Model\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Byte8\ProfileNotification\Api\NotificationManagementInterface;

/**
 * Severity Source Model
 */
class Severity implements OptionSourceInterface
{
    /**
     * Get options array
     *
     * @return array
     */
    public function toOptionArray(): array
    {
        return [
            ['value' => NotificationManagementInterface::SEVERITY_DEBUG, 'label' => __('Debug')],
            ['value' => NotificationManagementInterface::SEVERITY_NOTICE, 'label' => __('Notice')],
            ['value' => NotificationManagementInterface::SEVERITY_WARNING, 'label' => __('Warning')],
            ['value' => NotificationManagementInterface::SEVERITY_ERROR, 'label' => __('Error')],
            ['value' => NotificationManagementInterface::SEVERITY_CRITICAL, 'label' => __('Critical')]
        ];
    }
}