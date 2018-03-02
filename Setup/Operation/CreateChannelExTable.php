<?php
/**
 * Copyright © MageSpecialist - Skeeller srl. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace MSP\NotifierQueue\Setup\Operation;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\SchemaSetupInterface;

class CreateChannelExTable
{
    const TABLE_NAME_QUEUE_CHANNEL_EX = 'msp_notifier_queue_channel_ex';

    /**
     * @param SchemaSetupInterface $setup
     * @return void
     * @throws \Zend_Db_Exception
     */
    public function execute(SchemaSetupInterface $setup)
    {
        $table = $setup->getConnection()->newTable(
            $setup->getTable(self::TABLE_NAME_QUEUE_CHANNEL_EX)
        )->setComment(
            'MSP Notifier Queue Table extension attributes for channel'
        );

        $table = $this->addFields($table);
        $table = $this->addForeignKey($setup, $table);

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
                'msp_notifier_queue_channel_ex_id',
                Table::TYPE_INTEGER,
                null,
                [
                    'identity' => true,
                    'unsigned' => true,
                    'nullable' => false,
                    'primary' => true,
                ],
                'ID'
            )
            ->addColumn(
                'channel_id',
                Table::TYPE_INTEGER,
                null,
                [
                    'nullable' => false,
                    'unsigned' => true,
                ],
                'Channel ID'
            )
            ->addColumn(
                'immediate_send',
                Table::TYPE_BOOLEAN,
                null,
                [
                    'nullable' => false,
                ],
                'Immediate send'
            )
            ->addColumn(
                'send_trials',
                Table::TYPE_INTEGER,
                null,
                [
                    'nullable' => false,
                    'unsigned' => true,
                ],
                'Send trials'
            );

        return $table;
    }

    /**
     * Add fields
     * @param SchemaSetupInterface $setup
     * @param Table $table
     * @return Table
     * @throws \Zend_Db_Exception
     */
    private function addForeignKey(SchemaSetupInterface $setup, Table $table): Table
    {
        $table
            ->addForeignKey(
                $setup->getFkName(
                    $setup->getTable(self::TABLE_NAME_QUEUE_CHANNEL_EX),
                    'channel_id',
                    $setup->getTable('msp_notifier_channel'),
                    'channel_id'
                ),
                'channel_id',
                $setup->getTable('msp_notifier_channel'),
                'channel_id',
                Table::ACTION_CASCADE
            );

        return $table;
    }
}
