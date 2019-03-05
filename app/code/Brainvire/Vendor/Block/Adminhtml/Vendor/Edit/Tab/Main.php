<?php
namespace Brainvire\Vendor\Block\Adminhtml\Vendor\Edit\Tab;

class Main extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
{
    /**
     * @var \Magento\Store\Model\System\Store
     */
    protected $store;

    /**
    * @var \Brainvire\Vendor\Helper\Data $helper
    */
    protected $helper;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Brainvire\Vendor\Helper\Data $helper,
        array $data = []
    ) {
        $this->helper = $helper;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Prepare form
     *
     * @return $this
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    protected function _prepareForm()
    {
        /* @var $model \Brainvire\Vendor\Model\Vendor */
        $model = $this->_coreRegistry->registry('bv_vendor');

        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();

        $form->setHtmlIdPrefix('vendor_');

        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Vendor Information')]);

        if ($model->getId()) {
            $fieldset->addField('vendor_id', 'hidden', ['name' => 'vendor_id']);
        }

        $fieldset->addField(
            'vendor_name',
            'text',
            [
                'name' => 'vendor_name',
                'label' => __('Name'),
                'title' => __('Name'),
                'required' => true,
            ]
        );

        $fieldset->addField(
            'amazon_id',
            'text',
            [
                'name' => 'amazon_id',
                'label' => __('Amazon Id'),
                'title' => __('Amazon Id'),
                'required' => true,
            ]
        );

        $fieldset->addField(
            'amazon_secret_key',
            'text',
            [
                'name' => 'amazon_secret_key',
                'label' => __('Amazon Secret Key'),
                'title' => __('Amazon Secret Key'),
                'required' => true,
            ]
        );

        $fieldset->addField(
            'amazon_consumer_key',
            'text',
            [
                'name' => 'amazon_consumer_key',
                'label' => __('Amazon Consumer Key'),
                'title' => __('Amazon Consumer Key'),
                'required' => true,
            ]
        );        

        $form->setValues($model->getData());
        $this->setForm($form);

        return parent::_prepareForm();
    }

    /**
     * Prepare label for tab
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabLabel()
    {
        return __('Main');
    }

    /**
     * Prepare title for tab
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabTitle()
    {
        return __('Main');
    }

    /**
     * {@inheritdoc}
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isHidden()
    {
        return false;
    }

    /**
     * Check permission for passed action
     *
     * @param string $resourceId
     * @return bool
     */
    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }
}
