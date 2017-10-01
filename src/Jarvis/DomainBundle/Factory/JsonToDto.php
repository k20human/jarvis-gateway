<?php

namespace Jarvis\DomainBundle\Factory;

use Jarvis\DomainBundle\Dto\DeviceDto;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class JsonToDto
 * @package Jarvis\DomainBundle\Factory
 */
class JsonToDto
{
    /**
     * Convert results to dto array
     * @param $results
     * @return array
     */
    public function convertResults($results)
    {
        $results = $this->jsonToArray($results);

        $dtoResults = [];

        foreach ($results['result'] as $result) {
            $dtoResults[] = new DeviceDto($result['result']);
        }

        return $dtoResults;
    }

    /**
     * Convert result to dto
     * @param $result
     * @return DeviceDto
     * @throws NotFoundHttpException
     */
    public function convertResult($result)
    {
        $result = $this->jsonToArray($result);

        if (isset($result['result'])) {
            $dto = new DeviceDto($result['result'][0]);

            return $dto;
        } else {
            throw new NotFoundHttpException('This device doesn\'t exist in Domoticz');
        }
    }

    /**
     * Convert to array if necessary
     * @param $value
     * @return mixed
     */
    private function jsonToArray($value) {
        if (is_string($value)) {
            $value = json_decode($value, true);
        }

        return $value;
    }
}