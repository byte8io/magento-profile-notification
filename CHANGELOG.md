# Changelog — byte8/module-profile-notification

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

> **Vendor migration note:** This package is the Byte8 successor to
> `softcommerce/module-profile-notification`. Versioning is continuous: the line below picks up
> from `1.0.0` and the breaking `3.0.0` release marks the SoftCommerce → Byte8
> rebrand. Releases up to and including `1.0.0` were published under the
> `softcommerceltd` organisation; their compare links point there.

## [Unreleased]

## [3.0.1] - 2026-11-16
### Fixed
- move notification cleanup cron off the 02:00 slot

## [3.0.0] - 2026-06-13
### BREAKING CHANGES
- Rebrand SoftCommerce → Byte8: Composer vendor moved to `byte8/*`, PHP namespace root moved to `Byte8\`

## [1.0.0] - 2024-12-29

### Added
- Initial release of the Profile Notification System
- Core notification management service with severity levels (Debug, Notice, Warning, Error, Critical)
- Service-level tracking via `ServiceNotificationPlugin`
- Entity-level tracking via `ProcessorNotificationPlugin`
- Message storage observer for capturing profile messages
- Database tables for notifications and process summaries
- Admin UI grids for viewing notifications and summaries
- Email notification system with configurable alerts
- Cron jobs for cleanup and batch email sending
- Repository pattern implementation for data access
- Comprehensive logging with context preservation
- Performance metrics tracking (execution time, memory usage)
- Bulk actions for notifications (mark as read, delete)
- Retention policy with automatic cleanup
- LESS-based styling with proper scoping

### Security
- Sanitization of sensitive data in logs
- Proper ACL resources for admin access
- SQL injection prevention in repository layer

### Technical
- Compatible with Magento 2.4.x
- Requires PHP 8.1+
- Depends on SoftCommerce Profile module
- Uses Magento coding standards
- Full PHPDoc documentation

## [Upcoming]

### Planned Features
- REST API endpoints for external access
- Webhook support for third-party integrations
- Dashboard widget for quick notification overview
- Export functionality for notifications
- Advanced notification rules engine
- Real-time notification push via WebSocket
- Integration with external monitoring tools
- Custom notification channels (Slack, Teams)
- Notification templates for common scenarios
- Performance analytics dashboard

### Improvements
- Async notification processing option
- Notification aggregation for similar errors
- Smart notification grouping
- Enhanced search capabilities
- Notification archiving
- Multi-language support for notifications
- Custom severity levels
- Notification priorities
- Rate limiting for high-volume scenarios

[Unreleased]: https://github.com/byte8io/magento-profile-notification/compare/v3.0.0...HEAD
[3.0.0]: https://github.com/byte8io/magento-profile-notification/releases/tag/v3.0.0
