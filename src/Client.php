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

namespace Previewtechs\SDK\PHP;


class Client
{
    const MAIL_SERVICES_ENDPOINT = "https://mail-services.previewtechsapis.com";
    const ACCOUNTS_SERVICES_ENDPOINT = "https://accounts-services.previewtechsapis.com";
    const BILLING_SERVICES_ENDPOINT = "https://billing-services.previewtechsapis.com";

    protected $options = [];

    public function __construct($options = [])
    {
        $this->options = $options;
    }

    /**
     * @param null $key
     * @return array|mixed
     */
    public function getOptions($key = null)
    {
        if ($key) {
            return $this->options[$key];
        }

        return $this->options;
    }

    /**
     * @param $key
     * @param $value
     * @internal param array $options
     */
    public function setOptions($key, $value)
    {
        $this->options[$key] = $value;
    }
}