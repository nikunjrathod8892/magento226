<?php
namespace Brainvire\Wholesaler\Block\Adminhtml\Pending;
use Brainvire\Wholesaler\Model\Wholesalerstatus;

class Grid extends \Magento\Backend\Block\Widget\Grid\Extended {
	/**
	 * @var \Magento\Framework\Module\Manager
	 */
	protected $moduleManager;	

	/**
	 * @param \Magento\Backend\Block\Template\Context $context
	 * @param \Magento\Backend\Helper\Data $backendHelper
	 * @param \Brainvire\Sms\Model\SmsFactory $smsFactory
	 * @param \Magento\Framework\Module\Manager $moduleManager
	 * @param array $data
	 *
	 * @SuppressWarnings(PHPMD.ExcessiveParameterList)
	 */
	public function __construct(
		\Magento\Backend\Block\Template\Context $context,
		\Magento\Backend\Helper\Data $backendHelper,
		\Magento\Customer\Model\CustomerFactory $customerFactory,
		\Magento\Framework\Module\Manager $moduleManager,
		\Magento\Store\Model\StoreManagerInterface $storeManager,
		\Magento\Store\Api\WebsiteRepositoryInterface $websiteRepository,
		Wholesalerstatus $wholesalerStatus,
		array $data = []
	) {
		$this->customerFactory = $customerFactory;
		$this->moduleManager = $moduleManager;		
		$this->storeManager = $storeManager;		
		$this->websiteRepository = $websiteRepository;		
		$this->wholesalerStatus = $wholesalerStatus;		
		parent::__construct($context, $backendHelper, $data);
	}

	/**
	 * @return void
	 */
	protected function _construct() {
		parent::_construct();
		$this->setId('pendingwholesalerGrid');
		$this->setDefaultSort('id');
		$this->setDefaultDir('DESC');
		$this->setSaveParametersInSession(true);
		$this->setUseAjax(false);
		$this->setVarNameFilter('pendingwholesaler_filter');
		//$this->setFilterVisibility(false);
	}

	/**
	 * @return $this
	 */
	protected function _prepareCollection() {
		$collection = $this->customerFactory->create()->getCollection();
		$collection->addAttributeToSelect(array('*'));
		$collection->addAttributeToFilter('become_wholesaler', array('eq' => '1'));
		$collection->addAttributeToFilter('wholesaler_approved', array(array('eq' => '0'),array('eq' => '2')));
		// echo $collection->getSelect()->__toString();
		$this->setCollection($collection);

		parent::_prepareCollection();

		return $this;
	}
	
	protected function _prepareColumns() {
		$this->addColumn(
			'entity_id',
			[
				'header' => __('ID'),
				'type' => 'number',
				'index' => 'entity_id',
				'header_css_class' => 'col-id',
				'column_css_class' => 'col-id',
			]
		);
		$this->addColumn(
			'firstname',
			[
				'header' => __('Firstname'),
				'index' => 'firstname',				
			]
		);

		$this->addColumn(
			'lastname',
			[
				'header' => __('Lastname'),
				'index' => 'lastname',				
			]
		);

		$this->addColumn(
			'email',
			[
				'header' => __('Email'),
				'index' => 'email',				
			]
		);
		
		$this->addColumn(
			'website_id',
			[
				'header' => __('Website'),
				'index' => 'website_id',
				'type'      => 'options',
				'options' => $this->getWebsites(),
				'renderer' => 'Brainvire\Wholesaler\Block\Adminhtml\Renderer\Website'				
			]
		);

		$this->addColumn(
			'wholesaler_approved',
			[
				'header' => __('Status'),
				'index' => 'wholesaler_approved',
				'type'      => 'options',
				'width'      => '200px',
				'options' => $this->wholesalerStatus->toArray(),				
			]
		);
		
		$this->addColumn(
			'action_edit',
			[
				'header' => __('Action'),
				'sortable' => false,
		        'filter'   => false,
		        'renderer' => 'Brainvire\Wholesaler\Block\Adminhtml\Renderer\Approvelink'			
			]
		);

		return parent::_prepareColumns();
	}

	// protected function _prepareMassaction()
 //    {

 //        $this->setMassactionIdField('id');
 //        $this->getMassactionBlock()->setFormFieldName('devices');

 //        $this->getMassactionBlock()->addItem(
 //            'delete',
 //            [
 //                'label' => __('Delete'),
 //                'url' => $this->getUrl('*/*/massDelete' ,array()),
 //                'confirm' => __('Are you sure?')
 //            ]
 //        );

 //        return $this;
 //    }

	public function getRowUrl($row) {
		return $this->getUrl('customer/index/edit',['id' => $row->getId()]);
	}


	function getWebsites()
	{
		$websites = [];		
        foreach ($this->websiteRepository->getList() as $website) {
        	if ($website->getId() == 0) {
                continue;
            }
            $websites[$website->getId()] = $website->getName();            
        }
        return $websites;
	}	
}
