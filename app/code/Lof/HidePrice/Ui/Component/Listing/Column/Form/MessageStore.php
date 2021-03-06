<?php
/**
 * Landofcoder
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the Landofcoder.com license that is
 * available through the world-wide-web at this URL:
 * http://landofcoder.com/license
 * 
 * DISCLAIMER
 * 
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 * 
 * @category   Landofcoder
 * @package    Lof_HidePrice
 * @copyright  Copyright (c) 2016 Landofcoder (http://www.landofcoder.com/)
 * @license    http://www.landofcoder.com/LICENSE-1.0.html
 */
namespace Lof\HidePrice\Ui\Component\Listing\Column\Form;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\System\Store as SystemStore;
use Magento\Framework\Escaper;

class MessageStore extends Column
{


      /**
     * Escaper
     *
     * @var \Magento\Framework\Escaper
     */
    protected $escaper;
     /**
     * System store
     *
     * @var SystemStore
     */
    protected $systemStore;


    protected $hideprice;

    /**
     * @param ContextInterface   $context            
     * @param UiComponentFactory $uiComponentFactory 
     * @param UrlBuilder         $actionUrlBuilder   
     * @param UrlInterface       $urlBuilder         
     * @param array              $components         
     * @param array              $data               
     * @param [type]             $editUrl            
     */
    public function __construct(
        \Lof\HidePrice\Model\Hideprice $hideprice,
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        SystemStore $systemStore,
        array $components = [],
        Escaper $escaper,
        array $data = []        
        ) {
        $this->hideprice = $hideprice;
        $this->systemStore = $systemStore;
        $this->escaper = $escaper;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                if (isset($item['entity_id'])) {
                    $hideprice = $this->hideprice->getCollection()->addFieldToFilter('hideprice_id',$item['hideprice_id']);
                    $store_id = '';
                    foreach ($hideprice as $key => $_hideprice) {
                        if($_hideprice->getStoreId()) {
                            $store_id = $_hideprice->getStoreId();
                        }
                    }
                    if($store_id) {
                        $item['store_id'] = $this->prepareItem($store_id);
                    } else {
                        $item['store_id'] = '';
                    }
                    
                }
            }
        }
       
        return $dataSource;
    }

    /**
     * Get data
     *
     * @param array $item
     * @return string
     */
    protected function prepareItem($item)
    {
       
        if (!empty($item)) {
            $origStores = json_decode($item,true);
        }

         
        if (empty($origStores)) {
            return '';
        }
        if (!is_array($origStores)) {
            $origStores = [$origStores];
        }

        if (in_array(0, $origStores) && count($origStores) == 1) {
            return __('All Store Views');
        }

        $data = $this->systemStore->getStoresStructure(false, $origStores);
        $content ='';
        foreach ($data as $website) {
            $content .= $website['label'] . "<br/>";
            foreach ($website['children'] as $group) {
                $content .= str_repeat('&nbsp;', 3) . $this->escaper->escapeHtml($group['label']) . "<br/>";
                foreach ($group['children'] as $store) {
                    $content .= str_repeat('&nbsp;', 6) . $this->escaper->escapeHtml($store['label']) . "<br/>";
                }
            }
        }
       
        return $content;
    }

}
