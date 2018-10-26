<?php

namespace Magento\ImportService\Api\Data;

interface ImportResponseInterface
{
    const STATUS_COMPLETED = 'completed';

    const STATUS_FAILED = 'failed';

    const SOURCE_ID = 'source_id';

    const STATUS = 'status';

    const ERROR = 'error';

    /** 
     * 
     * Get file ID
     * 
     * @return int
     */
    public function getSourceId();
    
    /**
     *
     * Get file status
     *
     * @return string
     */
    public function getStatus();
    
    /**
     * 
     * Get error
     * @return string
     */
    public function getError();

    /**
     * @param $sourceId
     * @return mixed
     */
    public function setSourceId($sourceId);

    /**
     * @param $status
     * @return mixed
     */
    public function setStatus($status);

    /**
     * @param $error
     * @return mixed
     */
    public function setError($error);

}