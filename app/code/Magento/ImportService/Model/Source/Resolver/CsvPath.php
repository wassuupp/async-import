<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model\Source\Resolver;

use Magento\Framework\Stdlib\ArrayManager;

class CsvPath implements PathResolverInterface
{

    /**
     * @var ArrayManager
     */
    private $arrayManager;

    /**
     * CsvPath constructor.
     *
     * @param ArrayManager $arrayManager
     */
    public function __construct(
        ArrayManager $arrayManager
    ) {
        $this->arrayManager = $arrayManager;
    }

    /**
     * @inheritDoc
     */
    public function get($item, $path)
    {
        return $this->arrayManager->get($path, $item, null, '.');
    }

    /**
     * @inheritDoc
     */
    public function set($item, $path, $value)
    {
        return $this->arrayManager->set($path, $item, $value, '.');
    }
}