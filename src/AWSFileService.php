<?php
/**
 * Created by PhpStorm.
 * User: onysko
 * Date: 17.11.2014
 * Time: 14:12
 */
namespace samson\fs;

use Aws\S3\S3Client;
use Aws\Common\Credentials\Credentials;

/**
 * Amazon Web Services Adapter implementation
 * @package samson\upload
 */
class AWSFileService extends \samson\core\CompressableService implements IFileSystem
{
    /** @var string Identifier */
    protected $id = 'fs_aws';

    /** @var S3Client $client Aws services user */
    protected $client;

    /** @var \samson\fs\LocalFileService Pointer to local file service  */
    protected $localFS;

    /** @var string $bucket Aws bucket name */
    public $bucket;

    /** @var string $accessKey */
    public $accessKey;

    /** @var string $secretKey */
    public $secretKey;

    /** @var string $bucketURL Url of amazon bucket */
    public $bucketURL;

    /**
     * Adapter initialization
     */
    public function __construct()
    {
        // Create Authorization object and instantiate the S3 client with AWS credentials
        $this->client = S3Client::factory(array(
            'credentials' => new Credentials($this->accessKey, $this->secretKey)
        ));

        // Set pointer to local file system service
        $this->localFS = & m('fs_local');
    }

    /**
     * @param $data
     * @param string $filename
     * @param string $uploadDir
     * @see \samson\fs\iAdapter::write()
     * @return string Path to file
     */
    public function write($data, $filename = '', $uploadDir = '')
    {
        // Upload data to Amazon S3
        $this->client->putObject(array(
            'Bucket'       => $this->bucket,
            'Key'          => $uploadDir.'/'.$filename,
            'Body'         => $data,
            'CacheControl' => 'max-age=1296000',
            'ACL'          => 'public-read'
        ));

        // Build absolute path to uploaded resource
        return $this->bucketURL.'/'.$uploadDir.'/';
    }

    public function exists($filename)
    {
        return file_get_contents($filename);
    }

    public function read($fullname, $filename = null)
    {
        // Create temporary catalog
        if (!is_dir('temp')) {
            mkdir('temp', 0775);
        }

        // Create file in local file system
        $this->localFS->write(file_get_contents($fullname), $filename, 'temp');

        return 'temp/'.$filename;
    }

    public function move($filePath, $filename, $uploadDir)
    {
        // Upload file to Amazon S3
        $this->client->putObject(array(
            'Bucket'       => $this->bucket,
            'Key'          => $uploadDir.'/'.$filename,
            'SourceFile'   => $filePath,
            'CacheControl' => 'max-age=1296000',
            'ACL'          => 'public-read'
        ));
    }

    public function delete($filePath)
    {
        $this->client->deleteObject(array(
            'Bucket' => $this->bucket,
            'Key'    => str_replace($this->bucketURL, '', $filePath)
        ));
    }
}
