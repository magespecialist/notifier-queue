<?php
/**
 * Copyright © MageSpecialist - Skeeller srl. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace MSP\NotifierQueue\Setup\Operation;

use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\SchemaSetupInterface;

class CreateQueueTable
{
    const TABLE_NAME_QUEUE = 'msp_notifier_queue';

    /**
     * @param SchemaSetupInterface $setup
     * @return void
     * @throws \Zend_Db_Exception
     */
    public function execute(SchemaSetupInterface $setup)
    {
        $table = $setup->getConnection()->newTable(
            $setup->getTable(self::TABLE_NAME_QUEUE)
        )->setComment(
            'MSP Notifier Queue Table'
        );

        $table = $this->addFields($table);
        $table = $this->addIndexes($setup, $table);

        $setup->getConnection()->createTable($table);
    }

    /**
     * Add fields
     * @param Table $table
     * @return Table
     * @throws \Zend_Db_Exception
     */
    private function addFields(Table $table): Table
    {
        $table
            ->addColumn(
                'queue_id',
                Table::TYPE_INTEGER,
                null,
                [
                    'identity' => true,
                    'unsigned' => true,
                    'nullable' => false,
                    'primary' => true,
                ],
                'Queue ID'
            )
            ->addColumn(
                'created_at',
                Table::TYPE_DATETIME,
                null,
                [
                    'nullable' => false,
                ],
                'Created at'
            )
            ->addColumn(
                'sent_at',
                Table::TYPE_DATETIME,
                null,
                [
                    'nullable' => true,
                ],
                'Sent at'
            )
            ->addColumn(
                'retry_for',
                Table::TYPE_INTEGER,
                null,
                [
                    'nullable' => false,
                    'unsigned' => true,
                ],
                'Retry for'
            )
            ->addColumn(
                'status',
                Table::TYPE_INTEGER,
                null,
                [
                    'nullable' => false,
                ],
                'Send status'
            )
            ->addColumn(
                'channel_code',
                Table::TYPE_TEXT,
                null,
                [
                    'nullable' => false,
                ],
                'Channel code'
            )
            ->addColumn(
                'message',
                Table::TYPE_TEXT,
                null,
                [
                    'nullable' => false,
                ],
                'Message content'
            );

        return $table;
    }

    /**
     * Add indexes
     * @param SchemaSetupInterface $setup
     * @param Table $table
     * @return Table
     * @throws \Zend_Db_Exception
     */
    private function addIndexes(SchemaSetupInterface $setup, Table $table): Table
    {
        $table
            ->addIndex(
                $setup->getIdxName(
                    self::TABLE_NAME_QUEUE,
                    ['status'],
                    AdapterInterface::INDEX_TYPE_INDEX
                ),
                [['name' => 'status']],
                ['type' => AdapterInterface::INDEX_TYPE_INDEX]
            );

        return $table;
    }
}
