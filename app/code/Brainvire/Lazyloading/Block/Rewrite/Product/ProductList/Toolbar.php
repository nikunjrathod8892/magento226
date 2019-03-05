<?php

namespace Brainvire\Lazyloading\Block\Rewrite\Product\ProductList;

use Magento\Framework\View\Element\Template;

class Toolbar extends \Magento\Catalog\Block\Product\ProductList\Toolbar
{

	public function getLastPageNum() 
	{
		$lastPageNumber = $this->getCollection()->getLastPageNumber();
		$this->_catalogSession->setTotalPages($lastPageNumber);
		return $lastPageNumber;
	}
}

?>