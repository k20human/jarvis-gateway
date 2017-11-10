<?php

namespace Jarvis\ApiBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Jarvis\DomainBundle\Entity\Access\User;
use Jarvis\DomainBundle\Entity\Device\Group;
use Jarvis\DomainBundle\Factory\JsonToDto;
use M12U\Bundle\Sdk\DomoticzBundle\Provider\ProxyProvider;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * Class GroupController
 * @package Jarvis\ApiBundle\Controller
 */
class GroupController extends FOSRestController implements ClassResourceInterface
{
    /** @var  Device */
    private $device;

    /** @var  JsonToDto */
    private $jsonToDto;

    /**
     * DeviceController constructor.
     */
    public function __construct(ProxyProvider $provider, JsonToDto $jsonToDto)
    {
        $this->device = $provider->getClient('device');
        $this->jsonToDto = $jsonToDto;
    }

    /**
     * Get a Group by its id
     *
     * @Rest\View()
     * @Rest\Get("/groups/{group}")
     *
     * @ParamConverter("group", class="Jarvis\DomainBundle\Entity\Device\Group")
     *
     * @param Request $request
     * @param Group $group
     */
    public function getAction(Request $request, Group $group)
    {
        $groupDevices = $group->getDevices();

        // Get devices from Domoticz
        $domoticzDevices = $this->jsonToDto->convertResults($this->device->getDevices());

        return $group;
    }
}