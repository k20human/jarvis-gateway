<?php

namespace Jarvis\DomainBundle\Entity\Access;

use Jarvis\DomainBundle\Entity\GetSet\Access\UserGetSet;
use Jarvis\DomainBundle\Entity\Mixins\IdTrait;
use Symfony\Component\Security\Core\User\UserInterface;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * Class User
 * @package Jarvis\DomainBundle\Entity\Access
 */
class User extends BaseUser
{
}