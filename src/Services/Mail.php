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

namespace Previewtechs\SDK\PHP\Services;


use Previewtechs\SDK\PHP\Client;

/**
 * Class Mail
 * @package Previewtechs\SDK\PHP\Services
 */
class Mail
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * Mail constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        if (!$client) {
            throw new \InvalidArgumentException("Previewtechs SDK Client must required");
        }

        $this->client = $client;
    }
}