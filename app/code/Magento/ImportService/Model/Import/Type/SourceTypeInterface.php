<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model\Import\Type;

use Magento\ImportService\Api\Data\SourceCsvInterface;
use Magento\ImportService\ImportServiceException;

/**
 *  Source Type Interface
 */
interface SourceTypeInterface
{
    // todo discuss the name of constant
    const IMPORT_SOURCE_FILE_PATH = "import/";

    /**
     * save source content
     *
     * @param SourceCsvInterface $source
     * @throws ImportServiceException
     * @return SourceCsvInterface
     */
    public function save(SourceCsvInterface $source);
}
