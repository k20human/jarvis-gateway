<?php

namespace Jarvis\ApiBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Jarvis\DomainBundle\Dto\DeviceDto;
use Jarvis\DomainBundle\Factory\JsonToDto;
use M12U\Bundle\Sdk\DomoticzBundle\Client\Type\Command;
use M12U\Bundle\Sdk\DomoticzBundle\Client\Type\Device;
use M12U\Bundle\Sdk\DomoticzBundle\Provider\ProxyProvider;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * Class DomoticzController
 * @package Jarvis\ApiBundle\Controller
 */
class DomoticzController extends FOSRestController implements ClassResourceInterface
{
    /** @var  Command */
    private $command;

    /** @var  Device */
    private $device;

    /** @var  JsonToDto */
    private $jsonToDto;

    /**
     * DeviceController constructor.
     */
    public function __construct(ProxyProvider $provider, JsonToDto $jsonToDto)
    {
        $this->command = $provider->getClient('command');
        $this->device = $provider->getClient('device');
        $this->jsonToDto = $jsonToDto;
    }

    /**
     * Get collection of Contacts
     *
     * You can add query parameters (offset, limit and sort).
     * Default sort is by id DESC
     *
     * @Rest\View()
     * @Rest\Get("/devices")
     * @Rest\QueryParam(name="offset", requirements="\d+", strict=true, default="0", description="Offset query (start at 0)")
     * @Rest\QueryParam(name="limit", requirements="\d+", strict=true, nullable=true, description="Item count limit")
     * @Rest\QueryParam(name="sort", default="-id", description="Sort direction. Example sort=id,title or sort=-id,name")
     * @Rest\QueryParam(name="filter", description="Filter results")
     *
     * @param Request $request
     * @param ParamFetcher $paramFetcher
     * @return array
     */
    public function cgetAction(Request $request, ParamFetcher $paramFetcher)
    {
        return $this->jsonToDto->convertResults($this->device->getDevices());
    }

    /**
     * Get a Contact by its id
     *
     * @Rest\View()
     * @Rest\Get("/devices/{idx}")
     *
     * @param Request $request
     * @param string $idx
     * @return DeviceDto
     */
    public function getAction(Request $request, $idx)
    {
        return $this->jsonToDto->convertResult($this->device->getDevice($idx));
    }
}