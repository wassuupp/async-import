<?php

namespace Magento\AsynchronousImportDataExchanging\Model\Configuration;

use Magento\AsynchronousImportDataExchangingApi\Api\Data\RemoteReceiverInterface;
use Magento\Framework\Model\AbstractModel;


class RemoteReceiver extends AbstractModel implements RemoteReceiverInterface
{
    /**
     * @param string $integrationToken
     * @return $this
     */
    public function setIntegrationToken($integrationToken)
    {
        return $this->setData(self::INTEGRATION_TOKEN, $integrationToken);
    }

    /**
     * @return string
     */
    public function getIntegrationToken()
    {
        return $this->getData(self::INTEGRATION_TOKEN);
    }

    /**
     * @param string $baseUrl
     * @return $this
     */
    public function setBaseUrl($baseUrl)
    {
        return $this->setData(self::BASE_URL, $baseUrl);
    }

    /**
     * @return string
     */
    public function getBaseUrl()
    {
        return $this->getData(self::BASE_URL);
    }
}
