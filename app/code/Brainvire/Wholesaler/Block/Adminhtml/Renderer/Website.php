<?php
 
namespace Brainvire\Wholesaler\Block\Adminhtml\Renderer;
 
use Magento\Framework\DataObject;
 
class Website extends \Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer
{   

	public function __construct(
		\Magento\Store\Api\WebsiteRepositoryInterface $websiteRepository
	)
	{
		$this->websiteRepository = $websiteRepository;
	} 
    public function render(DataObject $row)
    {
    	return $this->websiteRepository->getById($row->getWebsiteId())->getName();
    }
}