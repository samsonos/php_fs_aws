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
class AwsAdapter implements IAdapter
{
    /** @var Credentials $credentials access key and secret key for amazon connect */
    protected $credentials;

    /** @var S3Client $client Aws services user */
    protected $client;

    /** @var string $bucket Aws bucket name */
    protected $bucket;

    /** @var string $accessKey */
    protected $accessKey;

    /** @var string $secretKey */
    protected $secretKey;

    /** @var string $bucketURL Url of amazon bucket */
    protected $bucketURL;

    /** @var LocalAdapter  */
    protected $localAdapter;

    /**
     * Adapter initialization
     */
    public function __construct()
    {
        $this->accessKey = m('samson_fs_aws')->adapterParameters['accessKey'];
        $this->secretKey = m('samson_fs_aws')->adapterParameters['secretKey'];
        $this->bucketURL = m('samson_fs_aws')->adapterParameters['bucketURL'];
        $this->bucket = m('samson_fs_aws')->adapterParameters['bucket'];

        // Create Authorization object
        $this->credentials = new Credentials($this->accessKey, $this->secretKey);

        // Instantiate the S3 client with AWS credentials
        $this->client = S3Client::factory(array(
            'credentials' => $this->credentials
        ));

        $this->localAdapter = new LocalAdapter();
    }

    /**
     * @param $data
     * @param string $filename
     * @param string $uploadDir
     * @see \samson\upload\iAdapter::write()
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

    public function exists($filename) {
        return file_get_contents($filename);
    }

    public function read($fullname, $filename)
    {
        // Create temporary catalog
        if (!is_dir('temp')) {
            mkdir('temp', 0775);
        }

        // Create file in local file system
        $this->localAdapter->write(file_get_contents($fullname), $filename, 'temp');

        return 'temp/'.$filename;
    }

    public function copy($filePath, $filename, $uploadDir)
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
