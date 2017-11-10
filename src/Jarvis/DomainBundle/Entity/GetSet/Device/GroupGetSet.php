<?php

namespace Jarvis\DomainBundle\Entity\GetSet\Device;

use Jarvis\DomainBundle\Entity\Access\User;

/**
 * Trait GroupGetSet
 * @package Jarvis\DomainBundle\Entity\GetSet\Device
 */
trait GroupGetSet
{
    /**
     * Get Name
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set Name
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get User
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set User
     * @param User $user
     * @return $this
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * Get Devices
     * @return array
     */
    public function getDevices()
    {
        return $this->devices;
    }

    /**
     * Set Devices
     * @param array $devices
     * @return $this
     */
    public function setDevices($devices)
    {
        $this->devices = $devices;
        return $this;
    }

    /**
     * Get Default
     * @return bool
     */
    public function isDefault()
    {
        return $this->default;
    }

    /**
     * Set Default
     * @param bool $default
     * @return $this
     */
    public function setDefault($default)
    {
        $this->default = $default;
        return $this;
    }

    /**
     * Add device
     * @param integer $device
     * @return $this
     */
    public function addDevice($device)
    {
        if (!in_array($device, $this->devices)) {
            $this->devices[] = $device;
        }

        return $this;
    }

    /**
     * Remove device
     * @param integer $device
     * @return $this
     */
    public function removeDevice($device)
    {
        if(($key = array_search($device, $this->devices)) !== false) {
            unset($this->devices[$key]);
        }

        return $this;
    }
}