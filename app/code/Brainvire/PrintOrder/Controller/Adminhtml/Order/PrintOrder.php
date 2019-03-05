<?php

namespace Brainvire\PrintOrder\Controller\Adminhtml\Order;

use Magento\Framework\App\ResponseInterface;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Controller\ResultFactory;

class PrintOrder extends \Magento\Backend\App\Action
{    
    protected $fileFactory;
    protected $orderRepository;
    protected $date;
    protected $orderPdf;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\App\Response\Http\FileFactory $fileFactory,
        \Magento\Sales\Api\OrderRepositoryInterface $orderRepository,
        \Magento\Framework\Stdlib\DateTime\DateTime $date,
        \Brainvire\PrintOrder\Model\Pdf\Order $orderPdf
    ) {
        parent::__construct($context);
        $this->fileFactory = $fileFactory;        
        $this->orderRepository = $orderRepository;
        $this->date = $date;
        $this->orderPdf = $orderPdf;
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Magento_Sales::sales_order');
    }

    public function execute()
    {  

        $orderId = $this->getRequest()->getParam('order_id');
        if ($orderId) {
            $order = $this->orderRepository->get($orderId);
            if ($order) {
                $pdf = $this->orderPdf->getPdf([$order]);
                $date = $this->date->date('Y-m-d_H-i-s');
                return $this->fileFactory->create(
                    __('order') . '_' . $date . '.pdf',
                    $pdf->render(),
                    DirectoryList::VAR_DIR,
                    'application/pdf'
                );
            }
        }
        
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('sales/*/view');
    }
}
