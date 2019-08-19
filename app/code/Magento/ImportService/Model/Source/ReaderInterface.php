<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model\Source;

use Magento\ImportServiceApi\Api\SourceBuilderInterface;

/**
 *  Source Reader Interface
 */
interface ReaderInterface extends \SeekableIterator
{
    const FILE_PATH = 'file_path';
    const SOURCE = 'source';

    /**
     * @param SourceBuilderInterface $source
     * @param $filePath
     *
     * @return mixed
     */
    public function init(SourceBuilderInterface $source, $filePath);

    /**
     * @return string
     */
    public function getFilePath();

    /**
     * @param string $filePath
     *
     * @return $this
     */
    public function setFilePath(string $filePath);

    /**
     * @return SourceBuilderInterface
     */
    public function getSource();

    /**
     * @param SourceBuilderInterface $source
     *
     * @return $this
     */
    public function setSource(SourceBuilderInterface $source);

}