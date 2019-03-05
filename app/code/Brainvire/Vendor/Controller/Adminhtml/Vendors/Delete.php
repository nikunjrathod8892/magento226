<?php

namespace Brainvire\Vendor\Controller\Adminhtml\Vendors;

use Magento\Backend\App\Action;
use Magento\TestFramework\ErrorLog\Logger;

class Delete extends \Magento\Backend\App\Action
{

    /**
     * {@inheritdoc}
     */
    /*protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Brainvire_Vendor::atachment_delete');
    }*/

    /**
     * Delete action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('vendor_id');
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            try {
                $model = $this->_objectManager->create('Brainvire\Vendor\Model\Vendor');
                $model->load($id);
                $model->delete();
                $this->messageManager->addSuccess(__('The vendor has been deleted.'));
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['vendor_id' => $id]);
            }
        }
        $this->messageManager->addError(__('We can\'t find a vendor to delete.'));
        return $resultRedirect->setPath('*/*/');
    }
}
