#SamsonPHP AWS File service module

This is File service implementation for Amazon AWS S3 buckets in SamsonPHP.
This is abstraction layer over standard PHP file functions. 
 
[![Latest Stable Version](https://poser.pugx.org/samsonos/php_fs_aws/v/stable.svg)](https://packagist.org/packages/samsonos/php_fs_aws)
[![Build Status](https://travis-ci.org/samsonos/php_fs_aws.png)](https://travis-ci.org/samsonos/php_fs_aws)
[![Code Climate](https://codeclimate.com/github/samsonos/php_fs_aws/badges/gpa.svg)](https://codeclimate.com/github/samsonos/php_fs_aws)
[![Code Coverage](https://scrutinizer-ci.com/g/samsonos/php_fs_aws/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/samsonos/php_fs_aws/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/samsonos/php_fs_aws/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/samsonos/php_fs_aws/?branch=master)
[![Total Downloads](https://poser.pugx.org/samsonos/php_fs_aws/downloads.svg)](https://packagist.org/packages/samsonos/php_fs_aws)

##Configuration  

This is done using [SamsonPHP module/service configuration](https://github.com/samsonos/php_fs/wiki/0.3-Configurating)

All available configuration fields are:
```php
class FileServiceConfig extends \samson\core\Config 
{
  /**@var string Configured module/service identifier */
  public $__id = 'fs';
  
  /**@var string Set Amazon Web Services as web-application file service using its class name */
  public $fileServiceClassName = 'samson\fs\AWSFileService';

  /** @var string $bucket Aws bucket name */
  public $bucket = '...';
 
  /** @var string $accessKey */
  public $accessKey = '...';
 
  /** @var string $secretKey */
  public $secretKey = '...';
 
  /** @var string $bucketURL Url of amazon bucket */
  public $bucketURL = '...';
}
