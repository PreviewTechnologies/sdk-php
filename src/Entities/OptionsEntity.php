<?php
namespace Previewtechs\SDK\Entities;


/**
 * Class OptionsEntity
 * @package Previewtechs\SDK\Entities
 */
trait OptionsEntity
{
    /**
     * @var array
     */
    public $options = [];

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
            throw new \InvalidArgumentException("Options with this " . $key . " already set. You can't add again what's already set");
        }

        $this->options[$key] = $value;
    }
}