<?php

namespace Magento\AsynchronousImportDataExchanging\Model\Configuration;

interface ConfigInterface
{
    /** @var string  */
    public const ASYNCHRONOUS_IMPORT_NODE = 'asynchronous_import';

    /** @var string  */
    public const EXCHANGE_ADAPTER_NODE = 'exchange_adapter';

    /** @var string  */
    public const DEFAULT_EXCHANGE_ADAPTER = 'service_contracts';

    /**
     * Loads the configured exchange adapter
     *
     * @return mixed
     */
    public function getAdapterConfiguration();
}
