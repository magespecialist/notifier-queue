<?php
/**
 * Copyright © MageSpecialist - Skeeller srl. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace MSP\NotifierQueue\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use MSP\NotifierQueue\Setup\Operation\CreateChannelExTable;
use MSP\NotifierQueue\Setup\Operation\CreateQueueTable;

class InstallSchema implements InstallSchemaInterface
{
    /**
     * @var CreateQueueTable
     */
    private $createQueueTable;

    /**
     * @var CreateChannelExTable
     */
    private $createChannelExTable;

    /**
     * InstallSchema constructor.
     * @param CreateQueueTable $createQueueTable
     * @param CreateChannelExTable $createChannelExTable
     */
    public function __construct(
        CreateQueueTable $createQueueTable,
        CreateChannelExTable $createChannelExTable
    ) {
        $this->createQueueTable = $createQueueTable;
        $this->createChannelExTable = $createChannelExTable;
    }

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        $this->createQueueTable->execute($setup);
        $this->createChannelExTable->execute($setup);
        $setup->endSetup();
    }
}
