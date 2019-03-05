<?php
 
namespace Brainvire\Admin\Controller\Adminhtml\Employee;
 
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
 
class Index extends \Magento\Backend\App\Action
{   
    const ADMIN_RESOURCE = 'Brainvire_Admin::employee';
 
        /**
         * @var \Magento\Framework\View\Result\PageFactory
         */
        protected $resultPageFactory;
 
        /**
         * @param \Magento\Framework\App\Action\Context $context
         * @param \Magento\Framework\View\Result\PageFactory resultPageFactory
         */
        public function __construct(
            \Magento\Framework\App\Action\Context $context,
            \Magento\Framework\View\Result\PageFactory $resultPageFactory
        )
        {
            parent::__construct($context);
            $this->resultPageFactory = $resultPageFactory;
        }
    /**
     * Default customer account page
     *
     * @return void
     */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Brainvire_Admin::employee');
        $resultPage->addBreadcrumb(__('Employee Data'), __('Employee Data'));
        $resultPage->addBreadcrumb(__('Employee Data'), __('Employee Data'));
        $resultPage->getConfig()->getTitle()->prepend(__('Employee Data'));
 
        return $resultPage;
    }
}?>