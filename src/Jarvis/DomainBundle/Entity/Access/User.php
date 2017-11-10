<?php

namespace Jarvis\DomainBundle\Entity\Access;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use Jarvis\DomainBundle\Entity\Device\Group;
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
     * @var ArrayCollection
     */
    protected $groups;

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

    /**
     * Check if group name already exists
     * @param string $group
     * @return bool
     */
    public function isGroupExists($group)
    {
        $criteria = Criteria::create()->where(Criteria::expr()->eq("name", $group));

        return $this->getGroups()->matching($criteria)->count() > 0;
    }
}