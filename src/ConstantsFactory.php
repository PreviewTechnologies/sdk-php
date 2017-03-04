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

/**
 * Write something about the purpose of this file
 *
 * @author Shaharia Azam <shaharia@previewtechs.com>
 * @url https://www.previewtechs.com
 */

namespace Previewtechs\SDK;

/**
 * Class ConstantsFactory
 * @package Previewtechs\SDK
 */
class ConstantsFactory
{
    /**
     *
     */
    const USER_AGENT_DEFAULT = 'Previewtechs SDK PHP - Built DevA101';
    /**
     *
     */
    const API_VERSION_STABLE = 'v1';
    /**
     *
     */
    const MAIL_SERVICES_ENDPOINT = "https://mail-services.previewtechsapis.com";
    /**
     * @var array
     */
    protected $constants = [];

    /**
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->constants[$name];
    }

    /**
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        $this->constants[$name] = $value;
    }

    /**
     * @return array
     */
    public function getConstants()
    {
        return $this->constants;
    }

    /**
     * @param array $constants
     */
    public function setConstants($constants)
    {
        $this->constants = $constants;
    }
}
