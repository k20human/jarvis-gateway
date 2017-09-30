<?php

namespace Jarvis\DomainBundle\Entity\Access;

use Jarvis\DomainBundle\Entity\GetSet\Access\UserGetSet;
use Jarvis\DomainBundle\Entity\Mixins\IdTrait;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class User
 * @package Jarvis\DomainBundle\Entity\Access
 */
class User implements UserInterface
{
    use IdTrait;
    use UserGetSet;

    /**
     * @var string
     */
    protected $username;

    /**
     * @var string
     */
    protected $email;

    /**
     * @var string
     */
    protected $password;

    /**
     * {@inheritdoc}
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * Get roles
     * @return array
     */
    public function getRoles()
    {
        return ['ROLE_USER'];
    }

    /**
     * {@inheritdoc}
     */
    public function eraseCredentials()
    {

    }
}