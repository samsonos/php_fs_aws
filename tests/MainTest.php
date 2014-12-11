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
        // Create S3 mock
        $this->client = $this->getMockBuilder('Aws\S3\S3Client')
            ->disableOriginalConstructor()
            ->getMock();

        // Get instance using services factory as error will signal other way
        $this->fileService = new \samson\fs\AWSFileService();
        $this->fileService->setClient($this->client);

        // Set test bucket URL
        $this->fileService->bucketURL = 'http://testbucket';
        $this->fileService->bucket = 'testbucket';
    }

    /** Test file service writing */
    public function testWrite()
    {
        // Set remove dir
        $remoteDir = 'remote';
        $fileName = 'test.txt';

        // Perform write
        $writtenFile = $this->fileService->write('123', $fileName, $remoteDir);

        // Compare current file with data read
        $this->assertEquals(
            $this->fileService->bucketURL.'/'.$remoteDir.'/',
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
        $this->fileService->delete(tempnam(sys_get_temp_dir(), 'test'));

        // Perform test
        $this->assertFileNotExists('test');
    }

    /** Test file service existing */
    public function testExists()
    {
        // Add method stub
        $this->client
            ->expects($this->once())
            ->method('doesObjectExist')
            ->willReturn(true);

        // Perform test
        $this->assertEquals(true, $this->fileService->exists(__FILE__));
    }

    /** Test file service extension */
    public function testExtension()
    {
        // Perform test
        $this->assertEquals(
            'php',
            $this->fileService->extension(__FILE__)
        );

        // Perform test 4 letter extension
        $this->assertEquals(
            'jpeg',
            $this->fileService->extension('test.jpeg')
        );
    }

    /** Test file service dir method */
    public function testDir()
    {
        // Add method stub
        $this->client
            ->expects($this->once())
            ->method('getIterator')
            ->willReturn(array(array('Key'=>'company/'), array('Key'=>'company.test')));
        // Scan project root dir
        $files = $this->fileService->dir('/');
         // Perform test
        $this->assertEquals(true, in_array('company.test', $files), 'File service dir failed - This file is not found in listing');
        $this->assertEquals(false, in_array('company/', $files), 'File service dir failed - This dir is found in listing');
    }

    public function testIsDir()
    {
        // Add method stub
        $this->client
            ->expects($this->once())
            ->method('doesObjectExist')
            ->willReturn(true);
        // Perform test
        $this->assertEquals(true, $this->fileService->isDir('company/'));
    }
}
