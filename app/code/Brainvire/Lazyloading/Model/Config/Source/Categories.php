<?php

namespace Brainvire\Lazyloading\Model\Config\Source;

class Categories implements \Magento\Framework\Option\ArrayInterface
{    
	protected $_categoryFactory;
        
	public function __construct(
        \Magento\Catalog\Model\CategoryFactory $categoryFactory
	){
        $this->_categoryFactory = $categoryFactory;
	}

    public function toOptionArray()
    {   
        $result = [];
        $items = $this->_categoryFactory->create()->getCollection()->addAttributeToSelect(
            'name'
        )->addAttributeToSort(
            'entity_id',
            'ASC'
        )->load()->getItems();
        foreach ($items as $item) {
            $result[] = [
                'label' => $item->getName(),
                'value' => $item->getEntityId()
                ];
        }  
        return $result;
    }
}