<?php
namespace tests;

use samson\fs\AWSFileService;
use samson\fs\FileService;
use samson\fs\LocalFileService;

/**
 * Created by Vitaly Iegorov <egorov@samsonos.com>
 * on 04.08.14 at 16:42
 */
class AwsTest extends \PHPUnit_Framework_TestCase
{
    /** @var \samson\fs\FileService Pointer to file service */
    public $fileService;

    /** Tests init */
    public function setUp()
    {
        $this->fileService = new AWSFileService(__DIR__.'../');
    }

    /** Test initialize without client passing*/
    public function testInitialize()
    {
        // Initialize service with our S3 client
        $result = $this->fileService->init();

<<<<<<< HEAD
        // Set access and secret keys
        $this->fileService->accessKey = '';
        $this->fileService->secretKey = '';
=======
        // Perform test
        $this->assertNotEquals(false, $result, 'AWS File service initialization with client passed failed');
    }

    /** Test initialize with client passing*/
    public function testInitializeWithClient()
    {
        // Create S3 mock
        $client = $this->getMockBuilder('Aws\S3\S3Client')
            ->disableOriginalConstructor()
            ->getMock();
>>>>>>> 7fc0afd... Added possible client instance passing for interacting with AWS S3

        // Initialize service with our S3 client
        $result = $this->fileService->init(array(&$client));

        // Perform test
        $this->assertNotEquals(false, $result, 'AWS File service initialization with client passed failed');
    }

    /** Test reading */
   /* public function testRead()
    {
        // Create instance
        $this->fileService = new AWSFileService(__DIR__.'../');

        $filePath = 'http://static.landscape.ua/company27338/catalog/dekorativnij-grynt-salatovuj-1-kg-01jpg';

        $filename = 'dekorativnij-grynt-salatovuj-1-kg-01.jpg';

        // Read current file data
        $data = $this->fileService->read($filePath, $filename);

        // Compare current file with data readed
        $this->assertStringEqualsFile(__FILE__, $data, 'File service read failed');
    }*/

    /** Test file service writing and reading */
    /*public function testWriteRead()
    {
        // Get instance using services factory as error will signal other way
        $this->fileService = \samson\core\Service::getInstance('samson\fs\LocalFileService');

        // Create temporary file
        $path = tempnam(sys_get_temp_dir(), 'test');

        // Write data to temporary file
        $this->fileService->write('123', $path);

        // Read data from file
        $data = $this->fileService->read($path);

        // Perform test
        $this->assertEquals('123', $data, 'File service writing failed');
    }*/

    /** Test file service writing failed */
   /* public function testFailWrite()
    {
        // Get instance using services factory as error will signal other way
        $this->fileService = \samson\core\Service::getInstance('samson\fs\LocalFileService');

        // Create temporary file
        $path = __DIR__.'/test/test.txt';

        // Write data to temporary file
        $this->fileService->write('123', $path);

        // Read data from file
        $data = $this->fileService->read($path);

        // Perform test
        $this->assertNotEquals('123', $data, 'File service failed writing failed');
    }*/

    /** Test file service deleting */
   /* public function testDelete()
    {
        // Get instance using services factory as error will signal other way
        $this->fileService = \samson\core\Service::getInstance('samson\fs\LocalFileService');

        // Create temporary file
        $path = tempnam(sys_get_temp_dir(), 'test');

        // Delete temporary file
        $this->fileService->delete($path);

        // Perform test
        $this->assertFileNotExists($path, 'File service deleting failed');
    }*/

    /** Test file service existing */
   /* public function testExists()
    {
        // Get instance using services factory as error will signal other way
        $this->fileService = \samson\core\Service::getInstance('samson\fs\LocalFileService');

        // Create temporary file
        $path = tempnam(sys_get_temp_dir(), 'test');

        // Write data to temporary file
        $exists = $this->fileService->exists($path);

        // Perform test
        $this->assertEquals(true, $exists, 'File service exists failed');
    }*/

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
