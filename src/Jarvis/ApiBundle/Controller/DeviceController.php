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
 * Class DeviceController
 * @package Jarvis\ApiBundle\Controller
 */
class DeviceController extends FOSRestController implements ClassResourceInterface
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
     * Get collection of devices
     *
     * You can add query parameters (offset, limit and sort).
     * Default sort is by id DESC
     *
     * @Rest\View()
     * @Rest\Get()
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
     * Get a device by its idx
     *
     * @Rest\View()
     * @Rest\Get()
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