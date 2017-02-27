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

namespace Previewtechs\SDK\Http;

use Previewtechs\SDK\Client;
use Previewtechs\SDK\ConstantsFactory;

/**
 * Class Agent
 * @package Previewtechs\SDK\PHP\Http
 */
class Agent
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var array
     */
    protected $options = [];
    /**
     * @var array
     */
    protected $headers = [];
    /**
     * @var null
     */
    protected $response = null;

    /**
     * Agent constructor.
     * @param Client $client
     * @param array $options
     */
    public function __construct(Client $client, $options = [])
    {
        $this->client = $client;
        $this->options = $options;

        if (!$this->client->getOptions('apiKey') || !$this->client->getOptions('accessToken')) {
            throw new \InvalidArgumentException("Credentials must required. Either ApiKey or Access Token");
        }

        if (!array_key_exists('userAgent', $options)) {
            $this->options['userAgent'] = ConstantsFactory::USER_AGENT_DEFAULT;
        }

        if (!array_key_exists('silentRequest', $options)) {
            $this->options['silentRequest'] = false;
        }

        $this->headers['Authorization'] = "Bearer " . $this->client->getOptions('apiKey');
    }

    /**
     * @param $key
     * @param $value
     * @return $this
     */
    public function addOption($key, $value)
    {
        if (array_key_exists($key, $this->options)) {
            throw new \InvalidArgumentException("Couldn\'t set duplicate options");
        }

        $this->options[$key] = $value;
        return $this;
    }

    /**
     * @param $key
     * @param $value
     * @return $this
     */
    public function addHeaders($key, $value)
    {
        if (array_key_exists($key, $this->headers)) {
            throw new \InvalidArgumentException("Couldn\'t set duplicate header");
        }

        $this->headers[$key] = $value;
        return $this;
    }

    /**
     * @param $method
     * @param $url
     * @param array $body
     * @param array $options
     * @return $this
     */
    public function request($method, $url, $body = [], $options = [])
    {
        $this->options['method'] = strtolower($method);
        $this->options['url'] = $url;
        $this->options['body'] = $body;
        $this->options = array_merge($this->options, $options);

        if (!$this->options['url']) {
            throw new \InvalidArgumentException("Invalid URL");
        }

        if (!$this->options['method']) {
            throw new \InvalidArgumentException("Invalid HTTP method");
        }

        if (strtolower($this->options['method']) == "post" && empty($this->options['body'])) {
            throw new \InvalidArgumentException("Empty HTTP post body");
        }

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, filter_var($this->options['url'], FILTER_SANITIZE_URL));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, ($this->options['silentRequest']) ? 1 : 0);
        curl_setopt($curl, CURLOPT_USERAGENT, $this->options['userAgent']);

        if ($this->options['method'] == "post") {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
        }

        curl_setopt($curl, CURLOPT_HTTPHEADER, $this->headers);

        $this->response = curl_exec($curl);

        curl_close($curl);

        return $this;
    }
}