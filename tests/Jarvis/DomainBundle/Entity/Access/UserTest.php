<?php

namespace Tests\Jarvis\DomainBundle\Entity\Access;

use Jarvis\DomainBundle\Entity\Access\User;
use PHPUnit\Framework\TestCase;

/**
 * Class UserTest
 * @package Tests\Jarvis\DomainBundle\Entity\Access
 */
class UserTest extends TestCase
{
    /**
     * @var User
     */
    private $user;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $this->user = new User();
    }

    /**
     * {@inheritdoc}
     */
    public function tearDown()
    {
        unset($this->user);
    }

    /**
     * Check that getters and setters work
     */
    public function test_setters_and_getters_concistency()
    {
        $this->user
            ->setUsername('test')
            ->setEmail('test@test.fr')
        ;

        self::assertEquals('test', $this->user->getUsername());
        self::assertEquals('test@test.fr', $this->user->getEmail());
    }
}