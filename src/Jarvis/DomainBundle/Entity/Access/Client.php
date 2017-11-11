<?php

namespace Jarvis\DomainBundle\Entity\Access;

/**
 * Class Client
 *
 * @package Jarvis\DomainBundle\Entity\Access
 */
class Client extends \FOS\OAuthServerBundle\Entity\Client
{
    /**
     * @var string
     */
    protected $applicationName;

    /**
     * @var string
     */
    protected $origin;

    /**
     * @return string
     */
    public function getApplicationName()
    {
        return $this->applicationName;
    }

    /**
     * @param string $applicationName
     */
    public function setApplicationName($applicationName)
    {
        $this->applicationName = $applicationName;
    }

    /**
     * @return string
     */
    public function getOrigin()
    {
        return $this->origin;
    }

    /**
     * @param string $origin
     */
    public function setOrigin($origin)
    {
        $this->origin = $origin;
    }

}