<?php
namespace tests;

use samson\fs\AWSFileService;
use samson\fs\FileService;
use samson\fs\LocalFileService;

/**
 * Created by Vitaly Iegorov <egorov@samsonos.com>
 * on 04.08.14 at 16:42
 */
class MainTest extends \PHPUnit_Framework_TestCase
{
    /** @var \samson\fs\AWSFileService Pointer to file service */
    public $fileService;

    /** @var S3Client AWS mock */
    public $client;

    /** Tests init */
    public function setUp()
    {
        // Get instance using services factory as error will signal other way
        $this->fileService = \samson\core\Service::getInstance('samson\fs\AWSFileService');
<<<<<<< HEAD
    }

    /** Test initialize without client passing*/
    public function testInitialize()
    {
        // Initialize service with our S3 client
        $result = $this->fileService->init();

        // Set test bucket URL
        $this->fileService->bucketURL = 'http://testbucket';

        // Create S3 mock
        $this->client = $this->getMockBuilder('Aws\S3\S3Client')
            ->disableOriginalConstructor()
            ->getMock();

        // Initialize service with our S3 client
        $this->fileService->init(array(&$this->client));
    }

    /** Test initialize without client passing*/
    public function testInitialize()
    {
        // Perform test
        $this->assertNotEquals(false, false, 'AWS File service initialization with client passed failed');
    }

    /** Test file service writing */
    public function testWrite()
    {
        // Set remove dir
        $remoteDir = '/remote/';

        // Perform write
        $writtenFile = $this->fileService->write('123', 'level1/level2/', $remoteDir);

        // Compare current file with data read
        $this->assertEquals(
            $this->fileService->bucketURL.$remoteDir,
            $writtenFile
        );
    }

    /** Test file service reading */
    public function testRead()
    {
        // Perform write
        $data = $this->fileService->read(__FILE__, basename(__FILE__));

        // Perform test
        $this->assertStringEqualsFile(__FILE__, $data, 'File service reading failed');
    }

    /** Test file service deleting */
    public function testDelete()
    {
        // Delete temporary file
        $result = $this->fileService->delete(tempnam(sys_get_temp_dir(), 'test'));

        // Perform test
        $this->assertFileNotExists($result, 'File service deleting failed');
    }

    /** Test file service existing */
    public function testExists()
    {
        // Get instance using services factory as error will signal other way
        $this->fileService = \samson\core\Service::getInstance('samson\fs\LocalFileService');

        // Create temporary file
        $path = tempnam(sys_get_temp_dir(), 'test');

        // Write data to temporary file
        $exists = $this->fileService->exists($path);

        // Perform test
        $this->assertEquals(true, $exists, 'File service exists failed');
    }

    /** Test file service moving */
    /*public function testMove()
    {
        // Get instance using services factory as error will signal other way
        $this->fileService = \samson\core\Service::getInstance('samson\fs\LocalFileService');

        // Create temporary file
        $path = tempnam(sys_get_temp_dir(), 'test');

        // Create test dir
        $testDir = sys_get_temp_dir().'/testDir/';
        mkdir($testDir, 0777);

        // Move file to a new dir
        $newPath = $this->fileService->move($path, basename($path), $testDir);

        // Perform test
        $this->assertFileExists($newPath, 'File service move failed - Moved file not found');
        $this->assertFileNotExists($path, 'File service move failed - Original file is not deleted');
    }*/

    /** Test file service moving to existing file */
    /*public function testMoveToExisting()
    {
        // Get instance using services factory as error will signal other way
        $this->fileService = \samson\core\Service::getInstance('samson\fs\LocalFileService');

        // Create temporary file
        $path = tempnam(sys_get_temp_dir(), 'test');

        // Move file to a new dir
        $newPath = $this->fileService->move($path, basename($path), dirname($path));

        // Perform test
        $this->assertEquals(false, $newPath, 'File service move failed - Moved file not found');
    }*/

    /** Test file service extension method */
    /*public function testExtension()
    {
        // Get instance using services factory as error will signal other way
        $this->fileService = \samson\core\Service::getInstance('samson\fs\LocalFileService');

        // Move file to a new dir
        $extension = $this->fileService->extension(__FILE__);

        // Perform test
        $this->assertEquals('php', $extension, 'File service extension method failed - Extension is not correct');
    }*/
}
