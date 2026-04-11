<?php
/**
 * Copyright © Byte8 Ltd. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace Byte8\ProfileNotification\Setup\Patch\Schema;

use Byte8\Profile\Setup\Patch\Schema\MigrateTablesFromSoftCommerce as ProfileTableMigration;
use Magento\Framework\Setup\Patch\SchemaPatchInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * Renames legacy softcommerce_profile_notification* tables to byte8_profile_notification*.
 *
 * Truncates first — notification data is transient and can be large.
 * Depends on Profile table migration since notification tables have FK to byte8_profile_entity.
 */
class MigrateTablesFromSoftCommerce implements SchemaPatchInterface
{
    private const TABLE_RENAMES = [
        'softcommerce_profile_notification' => 'byte8_profile_notification',
        'softcommerce_profile_notification_summary' => 'byte8_profile_notification_summary',
    ];

    public function __construct(
        private SchemaSetupInterface $schemaSetup
    ) {
    }

    /**
     * @inheritDoc
     */
    public function apply(): self
    {
        $this->schemaSetup->startSetup();
        $connection = $this->schemaSetup->getConnection();

        // Truncate transient notification data before rename
        $connection->query('SET FOREIGN_KEY_CHECKS = 0');
        foreach (array_keys(self::TABLE_RENAMES) as $oldTable) {
            $tableName = $this->schemaSetup->getTable($oldTable);
            if ($connection->isTableExists($tableName)) {
                $connection->truncateTable($tableName);
            }
        }
        $connection->query('SET FOREIGN_KEY_CHECKS = 1');

        // Rename tables
        foreach (self::TABLE_RENAMES as $oldTable => $newTable) {
            $oldTableName = $this->schemaSetup->getTable($oldTable);
            $newTableName = $this->schemaSetup->getTable($newTable);

            if (!$connection->isTableExists($oldTableName)) {
                continue;
            }

            if ($connection->isTableExists($newTableName)) {
                $count = (int) $connection->fetchOne(
                    $connection->select()->from($newTableName, ['COUNT(*)'])
                );

                if ($count > 0) {
                    continue;
                }

                $connection->query('SET FOREIGN_KEY_CHECKS = 0');
                $connection->dropTable($newTableName);
                $connection->query(sprintf(
                    'RENAME TABLE %s TO %s',
                    $connection->quoteIdentifier($oldTableName),
                    $connection->quoteIdentifier($newTableName)
                ));
                $connection->query('SET FOREIGN_KEY_CHECKS = 1');
            } else {
                $connection->query('SET FOREIGN_KEY_CHECKS = 0');
                $connection->query(sprintf(
                    'RENAME TABLE %s TO %s',
                    $connection->quoteIdentifier($oldTableName),
                    $connection->quoteIdentifier($newTableName)
                ));
                $connection->query('SET FOREIGN_KEY_CHECKS = 1');
            }
        }

        $this->schemaSetup->endSetup();

        return $this;
    }

    /**
     * @inheritDoc
     */
    public static function getDependencies(): array
    {
        return [
            ProfileTableMigration::class,
        ];
    }

    /**
     * @inheritDoc
     */
    public function getAliases(): array
    {
        return [];
    }
}
