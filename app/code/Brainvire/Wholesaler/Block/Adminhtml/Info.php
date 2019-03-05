<?php
namespace Brainvire\Wholesaler\Block\Adminhtml;

class Info extends \Magento\Backend\Block\Template
{    
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepositoryInterface,
        array $data = []
    ) {
        $this->customerRepositoryInterface = $customerRepositoryInterface;
        parent::__construct($context, $data);
    }
	
	public function getWholeSalerStatus()
	{		
		$customerId = $this->getRequest()->getParam('id');

		$customer = $this->customerRepositoryInterface->getById($customerId);
        $customerAttributeData = $customer->__toArray();
        
        if(isset($customerAttributeData['custom_attributes']['become_wholesaler'])){
        	$becomeWholeSaler = $customerAttributeData['custom_attributes']['become_wholesaler']['value'];
        	return $becomeWholeSaler;        	
        }
	}
}