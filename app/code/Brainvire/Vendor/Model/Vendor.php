<?php

namespace Brainvire\Vendor\Model;

use Magento\Framework\DataObject\IdentityInterface;

class Vendor extends \Magento\Framework\Model\AbstractModel implements IdentityInterface
{

    /**
     * CMS page cache tag
     */
    const CACHE_TAG = 'bv_vendors_grid';

    /**
     * @var string
     */
    protected $_cacheTag = 'bv_vendors_grid';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'bv_vendors_grid';

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Brainvire\Vendor\Model\ResourceModel\Vendor');
    }

    /**
     * Return unique ID(s) for each object in system
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getProducts(\Brainvire\Vendor\Model\Vendor $object)
    {
        $tbl = $this->getResource()->getTable(\Brainvire\Vendor\Model\ResourceModel\Vendor::TBL_ATT_PRODUCT);
        $select = $this->getResource()->getConnection()->select()->from(
            $tbl,
            ['product_id']
        )
        ->where(
            'vendor_id = ?',
            (int)$object->getId()
        );
        return $this->getResource()->getConnection()->fetchCol($select);
    }
}
