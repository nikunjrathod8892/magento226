<?php

namespace Brainvire\Wholesaler\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class CustomerRegisterObserver implements ObserverInterface
{    

    function __construct(
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    )
    {
        $this->customerRepository = $customerRepository;
        $this->storeManager = $storeManager;
    }


    public function execute(Observer $observer)
    {
        $customer = $observer->getCustomer();
        $customerid = $customer->getId();
        $customer = $this->customerRepository->getById($customerid);
        $websiteId = $this->storeManager->getStore()->getWebsiteId();
        $customer->setWebsiteId($websiteId);

        if(isset($_POST['become_wholesaler'])){
            $customer->setCustomAttribute('become_wholesaler', $_POST['become_wholesaler']);
        }

        $customer = $this->customerRepository->save($customer);
    }
}