<?php
namespace Brainvire\Vendor\Model\ResourceModel\Vendor;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'vendor_id';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Brainvire\Vendor\Model\Vendor', 'Brainvire\Vendor\Model\ResourceModel\Vendor');
    }
}
