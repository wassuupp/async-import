<?php

namespace Magento\AsynchronousImportDataExchanging\Model\Configuration;

interface ConfigInterface
{
    /** @var string  */
    public const ASYNCHRONOUS_IMPORT_NODE = 'asynchronous_import';

    /** @var string  */
    public const EXCHANGE_ADAPTER_NODE = 'exchange_adapter';

    /** @var string  */
    public const TYPE_NODE = 'type';

    /** @var string  */
    public const RECEIVER_NODE = 'receiver';

    /** @var string  */
    public const INTEGRATION_TOKEN = 'integration_token';

    /** @var string  */
    public const BASE_URL = 'base_url';

    /** @var string  */
    public const DEFAULT_EXCHANGE_ADAPTER = 'service_contracts';

    /**
     * Loads the configured exchange adapter
     *
     * @return mixed
     */
    public function getAdapterType();

    /**
     * Returns the receiver details
     *
     * @return array
     */
    public function getReceiverDetails();
}
