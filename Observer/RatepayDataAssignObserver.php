<?php


namespace Wirecard\ElasticEngine\Observer;

use Magento\Framework\Event\Observer;
use Magento\Payment\Observer\AbstractDataAssignObserver;
use Magento\Quote\Api\Data\PaymentInterface;

class RatepayDataAssignObserver extends AbstractDataAssignObserver
{
    /**
     * @param Observer $observer
     * @return void|null
     */
    public function execute(Observer $observer)
    {
        $data = $this->readDataArgument($observer);

        $additionalData = $data->getData(PaymentInterface::KEY_ADDITIONAL_DATA);
        if (!is_array($additionalData)) {
            return;
        }

        $paymentInfo = $this->readPaymentModelArgument($observer);

        if (array_key_exists('customerDob', $additionalData)) {
            $paymentInfo->setAdditionalInformation(
                'customerDob',
                $additionalData['customerDob']
            );
        }
    }
}