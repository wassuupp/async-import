<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\ImportService\Api;

use Magento\Framework\UrlInterface;
use Magento\ImportService\Api\Data\SourceInterface;
use Magento\ImportService\Api\Data\SourceUploadResponseInterface;
use Magento\TestFramework\Helper\Bootstrap;
use Magento\TestFramework\TestCase\WebapiAbstract;

/**
 * Tests the import service by given external source.
 */
class ExternalSourceImportTest extends WebapiAbstract
{
    const SERVICE_NAME = 'sourceRepositoryV1';
    const SERVICE_VERSION = 'V1';
    const RESOURCE_PATH = '/V1/import/source';

    /**
     * Magento Media directory
     */
    const DIR_MEDIA = BP . '/pub/media/';

    /**
     * The destination directory
     */
    const DIR_IMPORT_DESTINATION = 'import/';

    /**
     * The temporary directory that provides sample file for copying
     */
    const DIR_TMP_PROVIDER = 'tmp_import/';

    /**
     * The tested file extension
     */
    const EXTERNAL_FILE_TYPE = 'csv';

    /**
     * The type of import
     */
    const IMPORT_TYPE = 'external';

    /**
     * @var \Magento\Framework\Filesystem\Io\File
     */
    protected $fileSystemIo;

    /**
     * Sets Up the tests
     */
    public function setUp()
    {
        /** @var \Magento\Framework\ObjectManagerInterface  $objectManager */
        $objectManager = Bootstrap::getObjectManager();

        $this->fileSystemIo = $objectManager->create(\Magento\Framework\Filesystem\Io\File::class);
    }

    /**
     * Test Import Data not set
     */
    public function testImportDataNotSet()
    {
        $import_data = null;

        $result = $this->_webApiCall(
            $this->makeServiceInfo(),
            $this->makeRequestData($import_data)
        );

        $this->assertEquals(SourceUploadResponseInterface::STATUS_FAILED, $result['status']);
        $this->assertRegExp('/Filename cannot be empty/', $result['error']);
        $this->assertNull($result['source']);
    }

    /**
     * Test Import data not set file
     */
    public function testUnreachableFile()
    {
        $import_data = 'http://doesnotexist.domain/does-not-exist.csv';

        $result = $this->_webApiCall(
            $this->makeServiceInfo(),
            $this->makeRequestData($import_data)
        );

        $this->assertEquals(SourceUploadResponseInterface::STATUS_FAILED, $result['status']);
        $this->assertRegExp('/failed to open stream/', $result['error']);
        $this->assertNull($result['source']);
    }

    /**
     * Test reachable file
     */
    public function testReachableFile()
    {
        $sampleFileName = 'importservice-test-' . time() . '.' . self::EXTERNAL_FILE_TYPE;
        $sampleFileContent = 'ABCDEFGHabcdefgh0123456789';

        /** Create file to be copied */
        $this->fileSystemIo->write($this->pathProvider() . $sampleFileName, $sampleFileContent);

        /** @var \Magento\Store\Model\StoreManagerInterface $storeManager */
        $storeManager = Bootstrap::getObjectManager()->create(\Magento\Store\Model\StoreManagerInterface::class);

        /**
         * The external path to the file that should be copied
         * @var string $import_data
         */
        $import_data = $storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA)
            . self::DIR_TMP_PROVIDER
            . $sampleFileName;

        /** Make the Api call */
        $result = $this->_webApiCall(
            $this->makeServiceInfo(),
            $this->makeRequestData($import_data)
        );

        /** Assert the response status and the source_id */
        $this->assertEquals(SourceUploadResponseInterface::STATUS_UPLOADED, $result['status']);
        $this->assertNotNull($result['source']['import_data']);

        if (isset($result['source']['import_data'])) {

            /** @var $nameCopiedFile */
            $nameCopiedFile = $result['source']['import_data'];

            /** Assert that the content of the copied file matches the original content */
            $this->assertEquals(
                strlen($sampleFileContent),
                strlen($this->fileSystemIo->read($this->pathCopiedFile($nameCopiedFile)))
            );

            /** Remove copied file */
            $this->fileSystemIo->rm($this->pathCopiedFile($nameCopiedFile));
        }

        /** Remove tmp dir */
        $this->fileSystemIo->rmdir($this->pathProvider(), true);
    }

    /**
     * Sets up the service info
     * @return array
     */
    private function makeServiceInfo()
    {
        $serviceInfo = [
            'rest' => [
                'resourcePath' => self::RESOURCE_PATH,
                'httpMethod' => \Magento\Framework\Webapi\Rest\Request::HTTP_METHOD_POST,
            ],
            'soap' => [
                'service' => self::SERVICE_NAME,
                'serviceVersion' => self::SERVICE_VERSION,
                'operation' => self::SERVICE_NAME . 'Save',
            ],
        ];

        return $serviceInfo;
    }

    /**
     * Sets up the request array
     * @param string $import_data
     * @return array
     */
    private function makeRequestData($import_data)
    {
        return ['source' => [
                SourceInterface::SOURCE_TYPE => self::EXTERNAL_FILE_TYPE,
                SourceInterface::IMPORT_TYPE => self::IMPORT_TYPE,
                SourceInterface::IMPORT_DATA => $import_data
            ]
        ];
    }

    /**
     * Gets the path to the temporary directory, creates the directory and gives open permissions
     * @return string
     */
    private function pathProvider()
    {
        $fullPathTmpDir =  self::DIR_MEDIA . self::DIR_TMP_PROVIDER;

        $this->fileSystemIo->mkdir($fullPathTmpDir);
        $this->fileSystemIo->chmod($fullPathTmpDir, 0777, true);

        return $fullPathTmpDir;
    }

    /**
     * Gets the path to the copied file
     * @param string $source_id
     * @return string
     */
    private function pathCopiedFile($source_id)
    {
        return self::DIR_MEDIA
            . self::DIR_IMPORT_DESTINATION
            . $source_id
            . '.'
            . self::EXTERNAL_FILE_TYPE;
    }
}
