<?php

namespace Brainvire\Wholesaler\Setup;

use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Eav\Model\Config;
use Magento\Eav\Model\Entity\Attribute\SetFactory as AttributeSetFactory;
use Magento\Customer\Model\Customer;

class InstallData implements InstallDataInterface
{
	private $eavSetupFactory;

	public function __construct(EavSetupFactory $eavSetupFactory, Config $eavConfig, AttributeSetFactory $attributeSetFactory)
	{
		$this->eavSetupFactory = $eavSetupFactory;
		$this->eavConfig       = $eavConfig;
		$this->attributeSetFactory       = $attributeSetFactory;
	}

	public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
	{
		$eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
		$customerEntity = $this->eavConfig->getEntityType('customer');
		$attributeSetId = $customerEntity->getDefaultAttributeSetId();
		/** @var $attributeSet AttributeSet */
		$attributeSet = $this->attributeSetFactory->create();
		$attributeGroupId = $attributeSet->getDefaultGroupId($attributeSetId);
		$eavSetup->addAttribute(
			\Magento\Customer\Model\Customer::ENTITY,
			'become_wholesaler',
			[
				'type' => 'int',
				'label' => 'Become Wholesaler',
				'input' => 'text',
				'required' => false,
				'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
				'visible' => true,
				'user_defined' => true,
				'position' => 999,
				'system' => 0,
			]
		);
		$attribute = $this->eavConfig->getAttribute(\Magento\Customer\Model\Customer::ENTITY, 'become_wholesaler');

		$attribute->addData([
			'attribute_set_id' => $attributeSetId,
			'attribute_group_id' => $attributeGroupId,
			'used_in_forms' => ['checkout_register', 'customer_account_create', 'customer_account_edit'],
		]);

		$attribute->save();



		$eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
		$customerEntity = $this->eavConfig->getEntityType('customer');
		$attributeSetId = $customerEntity->getDefaultAttributeSetId();
		/** @var $attributeSet AttributeSet */
		$attributeSet = $this->attributeSetFactory->create();
		$attributeGroupId = $attributeSet->getDefaultGroupId($attributeSetId);
		$eavSetup->addAttribute(
			\Magento\Customer\Model\Customer::ENTITY,
			'wholesaler_approved',
			[
				'type' => 'int',
				'label' => 'Approved Wholesaler',
				'input' => 'text',
				'required' => false,
				'visible' => true,
				'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
				'user_defined' => true,
				'position' => 999,
				'system' => 0,
			]
		);
		$attribute = $this->eavConfig->getAttribute(\Magento\Customer\Model\Customer::ENTITY, 'wholesaler_approved');

		$attribute->addData([
			'attribute_set_id' => $attributeSetId,
			'attribute_group_id' => $attributeGroupId,
			'used_in_forms' => ['checkout_register', 'customer_account_create', 'customer_account_edit'],
		]);

		$attribute->save();
	}
}
