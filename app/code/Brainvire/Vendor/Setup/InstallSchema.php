<?php
namespace Brainvire\Vendor\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface
{
    /**
     * Installs DB schema for a module
     *
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();

        if (!$installer->tableExists('brainvire_vendor_data')) {
            $table = $installer->getConnection()
                ->newTable($installer->getTable('brainvire_vendor_data'))
                ->addColumn(
                    'vendor_id',
                    Table::TYPE_INTEGER,
                    10,
                    ['identity' => true, 'nullable' => false, 'primary' => true, 'unsigned' => true]
                )
                ->addColumn('vendor_name', Table::TYPE_TEXT, 255, ['nullable' => false])
                ->addColumn('amazon_id', Table::TYPE_TEXT, 255, ['nullable' => false])
                ->addColumn('amazon_secret_key', Table::TYPE_TEXT, 255, ['nullable' => false])
                ->addColumn('amazon_consumer_key', Table::TYPE_TEXT, 255, ['nullable' => false])                
                ->addColumn('creation_time', Table::TYPE_DATETIME, null, ['nullable' => false], 'Creation Time')
                ->addColumn('update_time', Table::TYPE_DATETIME, null, ['nullable' => false], 'Update Time')
                ->setComment('Vendor table');

            $installer->getConnection()->createTable($table);
        }

        if (!$installer->tableExists('brainvire_product_attachment_rel')) {
            $table = $installer->getConnection()
                ->newTable($installer->getTable('brainvire_product_attachment_rel'))
                ->addColumn('entity_id', Table::TYPE_INTEGER, 10, ['identity' => true, 'nullable' => false, 'primary' => true, 'unsigned' => true])
                ->addColumn('vendor_id', Table::TYPE_INTEGER, 10, ['nullable' => false, 'unsigned' => true])
                ->addColumn('product_id', Table::TYPE_INTEGER, 10, ['nullable' => false, 'unsigned' => true], 'Magento Product Id')
                ->addForeignKey(
                    $installer->getFkName(
                        'brainvire_vendor_data',
                        'vendor_id',
                        'brainvire_product_attachment_rel',
                        'vendor_id'
                    ),
                    'vendor_id',
                    $installer->getTable('brainvire_vendor_data'),
                    'vendor_id',
                    Table::ACTION_CASCADE
                )
                ->addForeignKey(
                    $installer->getFkName(
                        'brainvire_product_attachment_rel',
                        'vendor_id',
                        'catalog_product_entity',
                        'entity_id'
                    ),
                    'product_id',
                    $installer->getTable('catalog_product_entity'),
                    'entity_id',
                    Table::ACTION_CASCADE
                )
                ->setComment('Brainvire Product Attachment relation table');

            $installer->getConnection()->createTable($table);
        }

        $installer->endSetup();
    }
}
