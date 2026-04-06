<?php
/**
 * Copyright © Byte8 Ltd. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace Byte8\ProfileNotification\Model;

use Magento\Framework\Api\SearchResults;
use Byte8\ProfileNotification\Api\Data\NotificationSearchResultsInterface;

/**
 * Notification search results implementation
 */
class NotificationSearchResults extends SearchResults implements NotificationSearchResultsInterface
{
}