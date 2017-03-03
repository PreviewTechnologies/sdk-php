<?php

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
