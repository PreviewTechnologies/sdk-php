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

namespace Previewtechs\SDK\Services\MailServices\Entities;

/**
 * Class MailEntity
 * @package Previewtechs\SDK\Services\MailServices\Entities
 */
trait MailEntity
{
    /**
     * @var null
     */
    public $from = null;
    /**
     * @var array
     */
    public $to = [];
    /**
     * @var null
     */
    public $subject = null;
    /**
     * @var null
     */
    public $htmlBody = null;
    /**
     * @var null
     */
    public $textBody = null;
    /**
     * @var array
     */
    public $customVars = [];

    /**
     * @return string
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @param null $from
     */
    public function setFrom($from)
    {
        $this->from = $from;
    }

    /**
     * @return array
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * @param array $to
     */
    public function setTo($to)
    {
        $this->to = $to;
    }

    /**
     * @param $email
     * @param $name
     */
    public function addTo($email, $name)
    {
        $recipient = sprintf("%s <%s>", $name, $email);

        array_push($this->to, $recipient);
    }

    /**
     * @return null
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param null $subject
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    /**
     * @return null
     */
    public function getHtmlBody()
    {
        return $this->htmlBody;
    }

    /**
     * @param null $htmlBody
     */
    public function setHtmlBody($htmlBody)
    {
        $this->htmlBody = $htmlBody;
    }

    /**
     * @return null
     */
    public function getTextBody()
    {
        return $this->textBody;
    }

    /**
     * @param null $textBody
     */
    public function setTextBody($textBody)
    {
        $this->textBody = $textBody;
    }

    /**
     * @return array
     */
    public function getCustomVars()
    {
        return $this->customVars;
    }

    /**
     * @param array $customVars
     */
    public function setCustomVars($customVars)
    {
        $this->customVars = $customVars;
    }

    /**
     * @param $key
     * @param $value
     */
    public function addCustomVars($key, $value)
    {
        $this->customVars[$key] = $value;
    }
}
