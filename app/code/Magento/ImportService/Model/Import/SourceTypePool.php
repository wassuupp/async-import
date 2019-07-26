<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model\Import;

use Magento\ImportService\Api\Data\SourceCsvInterface;
use Magento\ImportService\ImportServiceException;
use Magento\ImportService\Model\Import\Type\SourceTypeInterface;

/**
 *  Source Type Pool
 */
class SourceTypePool
{
    /**
     * @var array
     */
    private $sourceTypes;

    /**
     * Initial dependencies
     *
     * @param SourceTypeInterface[] $sourceTypes
     */
    public function __construct(array $sourceTypes = [])
    {
        $this->sourceTypes = $sourceTypes;
    }

    /**
     * Get all mime types
     *
     * @return array
     */
    public function getAllowedMimeTypes(): array
    {
        $allowedMimeTypes = [];

        foreach ($this->sourceTypes as $key => $object) {
            $allowedMimeTypes = array_replace($allowedMimeTypes, $object->getAllowedMimeTypes());
        }

        return $allowedMimeTypes;
    }

    /**
     * Provides source type
     *
     * @param SourceCsvInterface $source
     *
     * @return SourceTypeInterface
     *
     * @throws ImportServiceException
     */
    public function getSourceType(SourceCsvInterface $source): SourceTypeInterface
    {
        foreach ($this->sourceTypes as $key => $object) {
            if ($source->getSourceType() === $key) {
                return $object;
            }
        }
        throw new ImportServiceException(
            __('Specified Source type "%1" is wrong.', $source->getSourceType())
        );
    }
}
