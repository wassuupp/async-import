<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model\Import\Type;

use Magento\ImportServiceApi\Api\Data\SourceCsvInterface;
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
     * @param SourceCsvInterface $source
     * @throws ImportServiceException
     *
     * @return SourceCsvInterface
     */
    public function save(SourceCsvInterface $source): SourceCsvInterface;

    /**
     * @param SourceCsvInterface $source
     * @return string
     */
    public function getAbsolutePathToFile(SourceCsvInterface $source);
}
