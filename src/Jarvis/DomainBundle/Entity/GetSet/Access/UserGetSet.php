<?php

namespace Jarvis\DomainBundle\Entity\GetSet\Access;
use Jarvis\DomainBundle\Entity\Device\Group;

/**
 * Trait UserGetSet
 * @package Jarvis\DomainBundle\Entity\GetSet\Access
 */
trait UserGetSet
{
    /**
     * Get Username
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set Username
     * @param string $username
     * @return $this
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    /**
     * Set Roles
     * @param array $roles
     * @return $this
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;
        return $this;
    }

    /**
     * Get Email
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set Email
     * @param string $email
     * @return $this
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * Set Password
     * @param string $password
     * @return $this
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * Get Password
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Get Devices
     * @return ArrayCollection
     */
    public function getDevices()
    {
        return $this->devices;
    }

    /**
     * Set Devices
     * @param ArrayCollection $devices
     * @return $this
     */
    public function setDevices($devices)
    {
        $this->devices = $devices;
        return $this;
    }

    /**
     * Adds a group
     *
     * @param Group $group
     *
     * @return $this
     */
    public function addGroup(Group $group)
    {
        if (!$this->groups->contains($group)) {
            $this->groups->add($group);
            $group->setUser($this);
        }

        return $this;
    }

    /**
     * Removes a group
     *
     * @param Group $group
     *
     * @return $this
     */
    public function removeGroup(Group $group)
    {
        if ($this->groups->contains($group)) {
            $this->groups->removeElement($group);
            $group->setUser(null);
        }

        return $this;
    }

    /**
     * Get Groups
     * @return ArrayCollection
     */
    public function getGroups()
    {
        return $this->groups;
    }

    /**
     * Set Groups
     * @param ArrayCollection $groups
     * @return $this
     */
    public function setGroups($groups)
    {
        $this->groups = $groups;
        return $this;
    }
}