<?php

namespace Brainvire\Wholesaler\Controller\Adminhtml\Index;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Brainvire\Wholesaler\Model\Wholesalerstatus;

class Disapprove extends \Magento\Backend\App\Action
{

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepositoryInterface
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->customerRepositoryInterface = $customerRepositoryInterface;
    }

    /**
     * Index action
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        $customerId = $this->getRequest()->getParam('id');
        $resultRedirect = $this->resultRedirectFactory->create();

        $customer = $this->customerRepositoryInterface->getById($customerId);        
        $customer->setGroupId(1);
        $customer->setCustomAttribute('wholesaler_approved', Wholesalerstatus::DISAPPROVED);
        $this->customerRepositoryInterface->save($customer);        
        
        $this->messageManager->addSuccess(__('Wholesaler has been disapproved.'));
        return $resultRedirect->setPath('*/approved/index');
    }

    /**
     * Is the user allowed to view the attachment grid.
     *
     * @return bool
     */
    /*protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Brainvire_Device::vendors');
    }*/
}
