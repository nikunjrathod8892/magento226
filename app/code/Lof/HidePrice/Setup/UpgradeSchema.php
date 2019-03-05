<?php
/**
 * Landofcoder
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the landofcoder.com license that is
 * available through the world-wide-web at this URL:
 * http://landofcoder.com/license
 * 
 * DISCLAIMER
 * 
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 * 
 * @category   Landofcoder
 * @package    Lof_HidePrice
 * @copyright  Copyright (c) 2016 Landofcoder (http://www.landofcoder.com/)
 * @license    http://www.landofcoder.com/LICENSE-1.0.html
 */

namespace Lof\HidePrice\Setup;

use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UpgradeSchemaInterface;

/**
 * @codeCoverageIgnore
 */
class UpgradeSchema implements UpgradeSchemaInterface
{
    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();

        if (version_compare($context->getVersion(), '1.0.2', '<')) {
            $tableItems = $installer->getTable('lof_hideprice_hideprice_message');

            $installer->getConnection()->addColumn(
                $tableItems,
                'hideprice_id',
                [
                    'nullable' => false,
                    'primary'  => true,
                    'type'     => \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                    'comment'  => 'Hide Price ID'
                ]
            );

            $tableItems = $installer->getTable('lof_hideprice_message');

            $installer->getConnection()->addColumn(
                $tableItems,
                'address',
                [
                    'nullable' => false,
                    'type'     => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length'   => 255,
                    'comment'  => 'Address'
                ]
            );

            $installer->getConnection()->addColumn(
                $tableItems,
                'town',
                [
                    'nullable' => false,
                    'type'     => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length'   => 255,
                    'comment'  => 'Town'
                ]
            );

            $installer->getConnection()->addColumn(
                $tableItems,
                'post_code',
                [
                    'nullable' => false,
                    'type'     => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length'   => 255,
                    'comment'  => 'Post Code'
                ]
            );

            $installer->getConnection()->addColumn(
                $tableItems,
                'company_name',
                [
                    'nullable' => false,
                    'type'     => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length'   => 255,
                    'comment'  => 'Company Name'
                ]
            );

            $installer->getConnection()->addColumn(
                $tableItems,
                'time_call',
                [
                    'nullable' => false,
                    'type'     => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length'   => 255,
                    'comment'  => 'Best time to Call'
                ]
            );


            /*
                * Create table lof_hideprice_quote
            */

            $table = $installer->getConnection()->newTable(
            $installer->getTable('lof_hideprice_quote')
            )->addColumn(
            'message_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            null,
            ['identity' => true,'nullable' => false, 'primary' => true],
            'Hide Price Id'
            )->addColumn(
            'entity_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['nullable' => false, 'primary' => true],
            'Entity id'
            )->addColumn(
            'hideprice_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['nullable' => false, 'primary' => true],
            'Hide Price id'
            )->addColumn(
            'quantity',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            100,
            ['nullable' => false],
            'Quantity'
            )->addColumn(
            'first_name',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'First Name'
            )->addColumn(
            'last_name',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'Last Name'
            )->addColumn(
            'email',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'Email'
            )->addColumn(
            'phone',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'Phone'
            )->addColumn(
            'content',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            '2M',
            ['nullable' => false],
            'Description'
            )->addColumn(
            'product_image',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'Product Image'
            )->addColumn(
            'product_url',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'Product Url'
            )->addColumn(
            'reply',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            ['nullable' => false,'default' => 'No'],
            'Product Image'
            )->addColumn(
            'reply_content',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            '2M',
            ['nullable' => false],
            'Content'
            )->addColumn(
                'creation_time',
                \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                null,
                ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
                'Form Creation Time'
            )->setComment(
            'Quote Meassage Table'
            )->addIndex(
            $installer->getIdxName('lof_hideprice_product', ['hideprice_id']),
            ['hideprice_id']
            );
            $installer->getConnection()->createTable($table);
        }
        if (version_compare($context->getVersion(), '1.0.3', '<')) {
            $table = $installer->getTable('lof_hideprice_hideprice_message');

            $installer->getConnection()->addColumn(
                $table,
                'client_ip',
                [
                    'type'     => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length'   => 60,
                    'nullable' => true,
                    'comment'  => 'Client IP addres'
                ]
            );

            $installer->getConnection()->addColumn(
                $table,
                'client_info',
                [
                    'type'     => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length'   => 255,
                    'nullable' => true,
                    'comment'  => 'Client Browser Info'
                ]
            );
        }
        $installer->endSetup();

    }
}
