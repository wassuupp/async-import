<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model\Import\Type;

use Magento\ImportServiceApi\Api\SourceBuilderInterface;
use Magento\ImportService\ImportServiceException;

/**
 *  Source Type Interface
 */
interface SourceTypeInterface
{
    /**
     * @TODO discuss the name of constant
     */
    public const IMPORT_SOURCE_FILE_PATH = 'import/';

    /**
     * save source content
     *
     * @param SourceBuilderInterface $source
     * @throws ImportServiceException
     *
     * @return SourceBuilderInterface
     */
    public function save(SourceBuilderInterface $source): SourceBuilderInterface;

    /**
     * @param SourceBuilderInterface $source
     * @return string
     */
    public function getAbsolutePathToFile(SourceBuilderInterface $source);
}
