<?php

namespace Jarvis\DomainBundle\Entity\Mixins;

/**
 * Trait IdTrait
 * @package Jarvis\DomainBundle\Entity\Mixins
 */
trait IdTrait
{
    /**
     * @var int|string
     */
    protected $id;

    /**
     * Get Id
     * @return int|string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set Id
     * @param int|string $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }
}