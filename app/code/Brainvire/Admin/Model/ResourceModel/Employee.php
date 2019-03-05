<?php
/**
 * Copyright © 2015 Brainvire. All rights reserved.
 */
namespace Brainvire\Admin\Model\ResourceModel;

/**
 * Certificate resource
 */
class Employee extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Initialize resource
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init('brainvire_employee', 'id');
    }

  
}
