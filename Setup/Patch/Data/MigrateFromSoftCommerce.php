<?php
/**
 * Copyright © Byte8 Ltd. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace Byte8\ProfileNotification\Setup\Patch\Data;

use Byte8\Profile\Setup\Patch\Data\MigrateFromSoftCommerce as ProfileMigration;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

/**
 * Migrates DML data for profile notification from SoftCommerce to Byte8.
 *
 * Table renames (DDL) are handled separately by the Schema Patch:
 * @see \Byte8\ProfileNotification\Setup\Patch\Schema\MigrateTablesFromSoftCommerce
 */
class MigrateFromSoftCommerce implements DataPatchInterface
{
    private const OLD_MODULE = 'SoftCommerce_ProfileNotification';
    private const NEW_MODULE = 'Byte8_ProfileNotification';

    public function __construct(
        private ModuleDataSetupInterface $moduleDataSetup
    ) {
    }

    /**
     * @inheritDoc
     */
    public function apply(): self
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        $this->migrateSetupModule();
        $this->migrateSetupPatches();
        $this->migrateAclRules();

        $this->moduleDataSetup->getConnection()->endSetup();

        return $this;
    }

    private function migrateSetupModule(): void
    {
        $connection = $this->moduleDataSetup->getConnection();
        $tableName = $this->moduleDataSetup->getTable('setup_module');

        $exists = $connection->fetchOne(
            $connection->select()
                ->from($tableName, ['COUNT(*)'])
                ->where('module = ?', self::OLD_MODULE)
        );

        if (!$exists) {
            return;
        }

        $newExists = $connection->fetchOne(
            $connection->select()
                ->from($tableName, ['COUNT(*)'])
                ->where('module = ?', self::NEW_MODULE)
        );

        if ($newExists) {
            $connection->delete($tableName, ['module = ?' => self::OLD_MODULE]);
        } else {
            $connection->update(
                $tableName,
                ['module' => self::NEW_MODULE],
                ['module = ?' => self::OLD_MODULE]
            );
        }
    }

    private function migrateSetupPatches(): void
    {
        $connection = $this->moduleDataSetup->getConnection();

        $patchTables = [
            $this->moduleDataSetup->getTable('setup_patch_data'),
            $this->moduleDataSetup->getTable('setup_patch_schema'),
        ];

        $oldNamespace = 'SoftCommerce\\ProfileNotification\\';
        $newNamespace = 'Byte8\\ProfileNotification\\';

        foreach ($patchTables as $tableName) {
            if (!$connection->isTableExists($tableName)) {
                continue;
            }

            $connection->update(
                $tableName,
                ['patch_name' => new \Zend_Db_Expr(sprintf(
                    "REPLACE(patch_name, '%s', '%s')",
                    addslashes($oldNamespace),
                    addslashes($newNamespace)
                ))],
                ['patch_name LIKE ?' => addslashes($oldNamespace) . '%']
            );
        }
    }

    private function migrateAclRules(): void
    {
        $connection = $this->moduleDataSetup->getConnection();
        $tableName = $this->moduleDataSetup->getTable('authorization_rule');

        if (!$connection->isTableExists($tableName)) {
            return;
        }

        $connection->update(
            $tableName,
            ['resource_id' => new \Zend_Db_Expr(sprintf(
                "REPLACE(resource_id, '%s', '%s')",
                self::OLD_MODULE,
                self::NEW_MODULE
            ))],
            ['resource_id LIKE ?' => self::OLD_MODULE . '::%']
        );
    }

    /**
     * @inheritDoc
     */
    public static function getDependencies(): array
    {
        return [
            ProfileMigration::class,
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
