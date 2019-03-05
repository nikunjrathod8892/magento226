<?php
 
namespace Brainvire\Wholesaler\Block\Adminhtml\Renderer;
 
use Magento\Framework\DataObject;
use Brainvire\Wholesaler\Model\Wholesalerstatus;
 
class Approvelink extends \Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer
{    
    public function render(DataObject $row)
    {
    	$approvesrc = $this->getUrl('*/index/approve',array('id' => $row->getId()));
    	$disapprovesrc = $this->getUrl('*/index/disapprove',array('id' => $row->getId()));
    	
    	$approveLink = "<a title='Approve' href='".$approvesrc."'>".__('Approve')."</a>";
    	$slash = " / ";
    	$disaproveLink = "<a title='Disapprove' href='".$disapprovesrc."'>".__('Disapprove')."</a>";

    	$pendingLink = $approveLink.$slash.$disaproveLink;    	

    	$status = $row->getWholesalerApproved();
    	switch ($status) {
    		case Wholesalerstatus::PENDING:
    			$link = $pendingLink;
    			break;

    		case Wholesalerstatus::APPROVED:
    			$link = $disaproveLink;
    			break;

    		case Wholesalerstatus::DISAPPROVED:
    			$link = $approveLink;
    			break;
    				
    		default:
    			$link = '-';
    			break;
    	}

    	return $link;
    }
}