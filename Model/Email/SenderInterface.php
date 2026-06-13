<?php
/**
 * Copyright © Byte8 Ltd. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace Byte8\ProfileNotification\Model\Email;

use Byte8\ProfileNotification\Api\Data\NotificationSummaryInterface;

/**
 * Email Sender Interface
 */
interface SenderInterface
{
    /**
     * Check if real-time critical alerts are enabled
     *
     * @return bool
     */
    public function isRealTimeCriticalEnabled(): bool;
    
    /**
     * Check if process summary emails should be sent
     *
     * @return bool
     */
    public function shouldSendProcessSummary(): bool;
    
    /**
     * Send critical alert email immediately
     *
     * @param string $message
     * @param array $context
     * @return void
     */
    public function sendCriticalAlert(string $message, array $context = []): void;
    
    /**
     * Send process summary email
     *
     * @param NotificationSummaryInterface $summary
     * @return void
     */
    public function sendProcessSummary(NotificationSummaryInterface $summary): void;
    
    /**
     * Send batch notification email
     *
     * @param array $notifications
     * @return void
     */
    public function sendBatchNotification(array $notifications): void;

    /**
     * Send the stock physical-drift report.
     *
     * Pure transport: the caller decides whether to send (its own feature flag)
     * and builds the template variables. Recipients fall back to the configured
     * notification recipients when the override is empty.
     *
     * @param array $templateVars Prepared template variables.
     * @param string[] $recipients Optional recipient override.
     * @return void
     */
    public function sendStockDriftReport(array $templateVars, array $recipients = []): void;
}