<?php

namespace Brainvire\Lazyloading\Block;

class Init extends \Magento\Framework\View\Element\Template
{   

    protected $coreRegistry = null;
    protected $storeManager;
    protected $helperData;

    
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,        
        \Magento\Framework\Registry $registry,
        \Brainvire\Lazyloading\Helper\Data $helperData,
        \Magento\Catalog\Model\Session $catalogSession,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        array $data = []
        ) {
        parent::__construct($context, $data);
        $this->coreRegistry = $registry;
        $this->helperData = $helperData;
        $this->storeManager = $storeManager;
        $this->catalogSession = $catalogSession;
    }

    public function getCurrentCategory()
    {
        return $this->coreRegistry->registry('current_category');
    }

    public function getProductContainer()
    {
        $defaultValue = '.product-items';
        return $this->helperData->getConfig('brainvire_lazyloading/general/content',$defaultValue);
    }    

    public function isEnable() {
        $fullAction       = $this->getRequest()->getFullActionName();
        if ($fullAction == 'catalog_category_view' && $category_obj = $this->coreRegistry->registry('current_category')) {
            $category = $category_obj->getId();
            $categories = explode(',', $this->helperData->getConfig('brainvire_lazyloading/general/categories'));  
            if($categories){
                foreach ($categories as $catid) {
                    if($category == $catid){
                        return true;
                    }
                } 
            }
        }
        $enabled_search   = $this->helperData->getConfig('brainvire_lazyloading/general/enabled_search');
        $enabled_advanced = $this->helperData->getConfig('brainvire_lazyloading/general/enabled_advanced');
        if (($enabled_search && $fullAction == 'catalogsearch_result_index') || ($enabled_advanced && $fullAction == 'catalogsearch_advanced_result')) {
            return true;
        }
        return false;  
    }

    public function getLastPageNum()
    {
        $lastPageNum = 1;
        if($this->catalogSession->getTotalPages()){
            $lastPageNum = $this->catalogSession->getTotalPages();
        }
        return $lastPageNum;
    }
}
