<?php

namespace Previewtechs\SDK\Services\MailServices\Response;

/**
 * Class General
 * @package Previewtechs\SDK\Services\MailServices\Response
 */
class GeneralResponse
{
    /**
     * @var bool
     */
    public $success;

    /**
     * @var string
     */
    public $message;

    /**
     * @var string
     */
    public $error = null;

    /**
     * @var string
     */
    public $errorCode = null;

    /**
     * @var \Previewtechs\SDK\Services\MailServices\Entities\Message
     */
    public $data;

    /**
     * @return bool
     */
    public function isSuccess()
    {
        return $this->success;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @return string
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @return string
     */
    public function getErrorCode()
    {
        return $this->errorCode;
    }

    /**
     * @return \Previewtechs\SDK\Services\MailServices\Entities\Message
     */
    public function getData()
    {
        return $this->data;
    }
}
