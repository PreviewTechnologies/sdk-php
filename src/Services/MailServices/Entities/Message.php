<?php

namespace Previewtechs\SDK\Services\MailServices\Entities;


/**
 * Class Message
 * @package Previewtechs\SDK\Services\MailServices\Entities
 */
class Message
{
    /**
     * @var string
     */
    public $email_id = null;

    /**
     * @return mixed
     */
    public function getMessageId()
    {
        return $this->email_id;
    }
}