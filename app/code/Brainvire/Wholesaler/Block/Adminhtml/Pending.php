<?php

namespace Brainvire\Wholesaler\Block\Adminhtml;

class Pending extends \Magento\Backend\Block\Widget\Container
{
    /**
     * @var string
     */
    protected $_template = 'grid/pending.phtml';

    /**
     * @param \Magento\Backend\Block\Widget\Context $context
     * @param array $data
     */
    public function __construct(\Magento\Backend\Block\Widget\Context $context,array $data = [])
    {
        parent::__construct($context, $data);
    }

    /**
     * Prepare button and grid
     *
     * @return \Magento\Catalog\Block\Adminhtml\Product
     */
    protected function _prepareLayout()
    {        
        $this->setChild(
            'grid',
            $this->getLayout()->createBlock('Brainvire\Wholesaler\Block\Adminhtml\Pending\Grid', 'brainvire.pendingwholesaler.grid')
        );
        return parent::_prepareLayout();
    }

    /**
     * Render grid
     *
     * @return string
     */
    public function getGridHtml()
    {
        return $this->getChildHtml('grid');
    }

}
