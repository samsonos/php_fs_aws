<?php
/**
 * Created by PhpStorm.
 * User: onysko
 * Date: 17.11.2014
 * Time: 14:12
 */
namespace samson\upload;

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

    /**
     * Adapter initialization
     * @param array $params Collection of configuration parameters
     * @see \samson\upload\iAdapter::init()
     * @return mixed|void
     */
    public function init($params)
    {
        // TODO: Add parameters validation to avoid misconfiguration
        $this->accessKey = $params['accessKey'];
        $this->secretKey = $params['secretKey'];
        $this->bucketURL = $params['bucketURL'];
        $this->bucket = $params['bucket'];

        // Create Authorization object
        $this->credentials = new Credentials($this->accessKey, $this->secretKey);

        // Instantiate the S3 client with AWS credentials
        $this->client = S3Client::factory(array(
            'credentials' => $this->credentials
        ));
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
}
