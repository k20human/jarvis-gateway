<?php

namespace Jarvis\DomainBundle\Entity\Device;

use Jarvis\DomainBundle\Entity\Access\User;
use Jarvis\DomainBundle\Entity\GetSet\Device\GroupGetSet;
use Jarvis\DomainBundle\Entity\Mixins\IdTrait;

/**
 * Class Group
 * @package Jarvis\DomainBundle\Entity\Device
 */
class Group
{
    use IdTrait;
    use GroupGetSet;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var User
     */
    protected $user;

    /**
     * @var array
     */
    protected $devices;

    /**
     * @var boolean
     */
    protected $default;

    /**
     * Group constructor.
     */
    public function __construct()
    {
        $this->default = false;
        $this->devices = [];
    }
}