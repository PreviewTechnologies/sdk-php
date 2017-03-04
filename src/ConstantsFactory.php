<?php
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
