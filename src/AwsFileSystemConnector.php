<?php
/**
 * Created by PhpStorm.
 * User: onysko
 * Date: 17.11.2014
 * Time: 22:46
 */

namespace samson\fs;


class AwsFileSystemConnector extends \samson\core\CompressableExternalModule {
    /** Идентификатор модуля */
    protected $id = 'samson_fs_aws';

    public $adapterParameters;


    /**
     * Initialize module
     * @param array $params Collection of module parameters
     * @return bool True if module successfully initialized
     */
    public function init(array $params = array())
    {
        if (!isset($this->adapterParameters)) {

        }

        // Call parent initialization
        parent::init($params);
    }
} 