<?php

namespace Previewtechs\SDK\Services\MailServices;

use GuzzleHttp\Exception\ClientException;
use Previewtechs\SDK\Client;
use Previewtechs\SDK\Entities\OptionsEntity;
use Previewtechs\SDK\Services\MailServices\Entities\MailEntity;
use Previewtechs\SDK\Services\MailServices\Response\GeneralResponse;

/**
 * Class Mailer
 * @package Previewtechs\SDK\Services\MailServices
 */
class Mailer
{
    /**
     *
     */
    const MAIL_SERVICES_ENDPOINT = "https://mail-services.previewtechsapis.com/v1";

    /**
     * @var Client
     */
    protected $client;

    /**
     * @var GeneralResponse
     */
    protected $response;


    use OptionsEntity, MailEntity;

    /**
     * Mailer constructor.
     * @param Client $client
     * @param array $options
     */
    public function __construct(Client $client, $options = [])
    {
        $this->client = $client;
        $this->options = $options;

        if (!array_key_exists('api_key', $this->client->getOptions('auth'))) {
            throw new \InvalidArgumentException("Authorization credentials required. api_key is required");
        }
    }

    /**
     * @return GeneralResponse
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @return object|GeneralResponse
     */
    public function send()
    {
        $this->checkRequiredFields();

        try {
            $response = $this->client->getHttp()->request('POST', self::MAIL_SERVICES_ENDPOINT . "/messages/sends", [
                'query' => ['api_key' => $this->client->getOptions('auth')['api_key']],
                'json' => $this->getParamsAsArray()
            ]);

            $response = ($response->getStatusCode() === 200) ? json_decode($response->getBody()->getContents()) : new \stdClass();
            $mapper = $this->client->getJsonMapper();
            $mapper->bExceptionOnUndefinedProperty = false;
            return $mapper->map($response, new GeneralResponse());
        } catch (ClientException $exception) {
            return $this->client->getJsonMapper()
                ->map(json_decode($exception->getResponse()->getBody()->getContents()), new GeneralResponse());
        }
    }

    /**
     *
     */
    public function checkRequiredFields()
    {
        if (!$this->getFrom()) {
            throw new \InvalidArgumentException("From must required");
        }

        if (!$this->getTo()) {
            throw new \InvalidArgumentException("To must required");
        }

        if (is_array($this->getTo()) === false) {
            throw new \InvalidArgumentException("To must be an array");
        }

        if (!$this->getSubject()) {
            throw new \InvalidArgumentException("Subject must required");
        }

        if ($this->getHtmlBody() == null || $this->getTextBody() == null) {
            throw new \InvalidArgumentException("Body (HTML/Text) must required");
        }
    }

    /**
     * @return array
     */
    public function getParamsAsArray()
    {
        $data = [];
        $data['from'] = $this->getFrom();
        $data['to'] = $this->getTo();
        $data['subject'] = $this->getSubject();
        $data['html'] = $this->getHtmlBody();
        $data['text'] = $this->getTextBody();

        return $data;
    }
}
