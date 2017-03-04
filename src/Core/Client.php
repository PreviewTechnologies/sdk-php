<?php
/**
 * Copyright (c) 2017 Preview Technologies Limited
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Previewtechs\SDK\Core;

use GuzzleHttp\ClientInterface;
use Previewtechs\SDK\Entities\OptionsEntity;
use Previewtechs\SDK\Services\MailServices\Mailer;

/**
 * Class Client
 * @package Previewtechs\SDK\Core
 */
class Client
{
    /**
     * @var array
     */
    public $options = [];

    /**
     * @var \GuzzleHttp\Client
     */
    protected $http;
    /**
     * @var \JsonMapper
     */
    protected $jsonMapper;

    /**
     * Client constructor.
     * @param array $options
     */
    public function __construct($options = [])
    {
        $this->options = $options;

        $httpConfig = array_key_exists('httpConfig', $this->options) ? $this->options['httpConfig'] : [];
        $this->http = new \GuzzleHttp\Client($httpConfig);
        $this->jsonMapper = new \JsonMapper();
    }

    /**
     * @param null $key
     * @return array
     */
    public function getOptions($key = null)
    {
        if (isset($key) && array_key_exists($key, $this->options)) {
            return $this->options[$key];
        }

        return $this->options;
    }

    /**
     * @param array $options
     */
    public function setOptions($options = [])
    {
        $this->options = $options;
    }

    /**
     * @param $key
     * @param $value
     */
    public function addOptions($key, $value)
    {
        if (array_key_exists($key, $this->options)) {
            throw new \InvalidArgumentException(
                "Options with this " . $key . " already set. You can't add again what's already set"
            );
        }

        $this->options[$key] = $value;
    }

    /**
     * @return \GuzzleHttp\Client
     */
    public function getHttp()
    {
        return $this->http;
    }

    /**
     * @param ClientInterface $http
     */
    public function setHttp(ClientInterface $http)
    {
        $this->http = $http;
    }

    /**
     * @return \JsonMapper
     */
    public function getJsonMapper()
    {
        return $this->jsonMapper;
    }

    /**
     * @param \JsonMapper $jsonMapper
     */
    public function setJsonMapper($jsonMapper)
    {
        $this->jsonMapper = $jsonMapper;
    }

    /**
     * @return Mailer
     */
    public function getMailServices()
    {
        return new Mailer($this);
    }
}
