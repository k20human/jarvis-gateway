<?php

namespace Jarvis\ApiBundle\Security\Device;

use Jarvis\DomainBundle\Entity\Access\User;
use Jarvis\DomainBundle\Entity\Device\Group;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

/**
 * Class GroupVoter
 * @package Jarvis\ApiBundle\Security\Device
 */
class GroupVoter extends Voter
{
    const ACCESS = 'access';


    /**
     * @inheritdoc
     */
    protected function supports($attribute, $subject)
    {
        // If the attribute isn't one we support, return false
        if (!in_array($attribute, [self::ACCESS])) {
            return false;
        }

        // only vote on Group objects inside this voter
        if (!($subject instanceof Group)) {
            return false;
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        /** @var User $user */
        $user = $token->getUser();

        /** @var Group $group */
        $group = $subject;

        return $group->getUser() === $user;
    }
}