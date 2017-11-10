<?php

namespace Jarvis\ApiBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Jarvis\ApiBundle\Security\Device\GroupVoter;
use Jarvis\DomainBundle\Entity\Access\User;
use Jarvis\DomainBundle\Entity\Device\Group;
use Jarvis\DomainBundle\Form\Device\GroupForm;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpKernel\Exception\HttpException;

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
        return $this->getUser();
    }

    /**
     * Get user's collection of Group
     * @Rest\View()
     * @Rest\Get()

     * @param Request $request
     * @return ArrayCollection
     */
    public function cgetGroupsAction(Request $request)
    {
        return $this->getUser()->getGroups();
    }

    /**
     * Create new Group
     *
     * @Rest\View(statusCode=Response::HTTP_CREATED)
     * @Rest\Post()
     *
     * @param Request $request
     * @return Group|Form
     */
    public function postGroupAction(Request $request)
    {
        /** @var User $user */
        $user = $this->getUser();

        $group = new Group();
        $form = $this->createForm(GroupForm::class, $group);

        $form->submit($request->request->all());

        if ($form->isValid()) {
            // Check if group name already exists
            if (!$user->isGroupExists($group->getName())) {
                $em = $this->getDoctrine()->getManager();

                $user->addGroup($group);
                $em->persist($group);
                $em->flush();

                return $group;
            }

            throw new HttpException(Response::HTTP_METHOD_NOT_ALLOWED, "Ce groupe existe déjà");
        }

        return $form;
    }

    /**
     * Update Group
     *
     * @Rest\View()
     * @Rest\Patch("/users/groups/{group}")
     *
     * @ParamConverter("group", class="Jarvis\DomainBundle\Entity\Device\Group")
     *
     * @param Request $request
     * @param Group $group
     * @return Group|Form
     */
    public function patchGroupAction(Request $request, Group $group)
    {
        /** @var User $user */
        $user = $this->getUser();

        $this->denyAccessUnlessGranted(GroupVoter::ACCESS, $group);

        $form = $this->createForm(GroupForm::class, $group);

        $form->submit($request->request->all(), false);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $group;
        }

        return $form;
    }

    /**
     * Delete a Group by its id
     *
     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
     * @Rest\Delete("/users/groups/{group}")

     * @ParamConverter("group", class="Jarvis\DomainBundle\Entity\Device\Group")
     *
     * @param Request $request
     * @param Group $group
     */
    public function deleteGroupAction(Request $request, Group $group)
    {
        /** @var User $user */
        $user = $this->getUser();

        $this->denyAccessUnlessGranted(GroupVoter::ACCESS, $group);

        $em = $this->getDoctrine()->getManager();

        // Remove group from user
        $user->removeGroup($group);
        $em->flush();

        // Remove group
        $em->remove($group);
        $em->flush();
    }
}