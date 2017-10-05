<?php

namespace Jarvis\ApiBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Jarvis\DomainBundle\Entity\Access\User;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * Class UserController
 * @package Jarvis\ApiBundle\Controller
 */
class UserController extends FOSRestController implements ClassResourceInterface
{
    /**
     * Get connected user
     *
     * @Rest\View()
     * @Rest\Get("/users/connected")

     * @param Request $request
     * @return User
     */
    public function getConnectedAction(Request $request)
    {
        return $this->get('security.token_storage')->getToken()->getUser();
    }
}