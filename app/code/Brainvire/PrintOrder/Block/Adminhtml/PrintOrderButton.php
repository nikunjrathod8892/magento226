<?php

namespace Brainvire\PrintOrder\Block\Adminhtml;

class PrintOrderButton extends \Magento\Backend\Block\Widget\Container
{    
    protected $coreRegistry = null;
    
    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \Magento\Framework\Registry $registry,
        array $data = []
    ) {
        $this->coreRegistry = $registry;
        parent::__construct($context, $data);
    }

    protected function _construct()
    {
        $this->addButton(
            'brainvire_printorder',
            [
                'label'   => __('Print Order'),
                'class'   => 'print',
                'onclick' => 'setLocation(\'' . $this->getPdfPrintUrl() . '\')'
            ]
        );

        parent::_construct();
    }
    
    public function getPdfPrintUrl()
    {
        return $this->getUrl('brainvire_printorder/order/printOrder/order_id/' . $this->getOrderId());
    }
    
    public function getOrderId()
    {
        return $this->coreRegistry->registry('sales_order')->getId();
    }
}
