<?php
namespace Brainvire\Vendor\Controller\Adminhtml\Vendors;
use Magento\Backend\App\Action;
use Brainvire\Vendor\Model\Vendor;

class MassDelete extends \Magento\Backend\App\Action
{
    public function execute()
    {
        $ids = $this->getRequest()->getParam('selected', []);        
        if (!is_array($ids) || !count($ids)) {
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('*/*/index', array('_current' => true));
        }
        foreach ($ids as $id) {
            if ($vendor = $this->_objectManager->create(Vendor::class)->load($id)) {
                $vendor->delete();
            }
        }
        $this->messageManager->addSuccess(__('A total of %1 record(s) have been deleted.', count($ids)));

        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath('*/*/index', array('_current' => true));
    }
}