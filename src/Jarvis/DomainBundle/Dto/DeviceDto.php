<?php

namespace Jarvis\DomainBundle\Dto;

/**
 * Class DeviceDto
 * @package Jarvis\DomainBundle\Dto
 */
class DeviceDto
{
    protected $data;

    protected $idx;

    protected $type;

    protected $name;

    protected $image;

    protected $hardwareType;

    protected $lastUpdate;

    protected $humidity = null;

    protected $temp = null;

    protected $used = true;

    /**
     * @param $value
     * @return null
     */
    private function checkIfEmpty($device, $value)
    {
        return array_key_exists($value, $device) ? $device[$value] : null;
    }

    /**
     * DeviceDto constructor.
     * @param array $device
     */
    public function __construct($device)
    {
        $this->data = $device['Data'];
        $this->idx = intval($device['idx']);
        $this->type = $device['Type'];
        $this->name = $device['Name'];
        $this->image = $this->checkIfEmpty($device, 'Image');
        $this->hardwareType = $device['HardwareType'];
        $this->lastUpdate = $device['LastUpdate'];
        $this->humidity = $this->checkIfEmpty($device, 'Humidity');
        $this->temp = $this->checkIfEmpty($device, 'Temp');
        $this->used = $device['Used'] == 0 ? false : true;
    }

    /**
     * Get Data
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set Data
     * @param mixed $data
     * @return $this
     */
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * Get Idx
     * @return mixed
     */
    public function getIdx()
    {
        return $this->idx;
    }

    /**
     * Set Idx
     * @param mixed $idx
     * @return $this
     */
    public function setIdx($idx)
    {
        $this->idx = $idx;
        return $this;
    }

    /**
     * Get Type
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set Type
     * @param mixed $type
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * Get Name
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set Name
     * @param mixed $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get Image
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set Image
     * @param mixed $image
     * @return $this
     */
    public function setImage($image)
    {
        $this->image = $image;
        return $this;
    }

    /**
     * Get HardwareType
     * @return mixed
     */
    public function getHardwareType()
    {
        return $this->hardwareType;
    }

    /**
     * Set HardwareType
     * @param mixed $hardwareType
     * @return $this
     */
    public function setHardwareType($hardwareType)
    {
        $this->hardwareType = $hardwareType;
        return $this;
    }

    /**
     * Get LastUpdate
     * @return mixed
     */
    public function getLastUpdate()
    {
        return $this->lastUpdate;
    }

    /**
     * Set LastUpdate
     * @param mixed $lastUpdate
     * @return $this
     */
    public function setLastUpdate($lastUpdate)
    {
        $this->lastUpdate = $lastUpdate;
        return $this;
    }

    /**
     * Get Humidity
     * @return mixed|null
     */
    public function getHumidity()
    {
        return $this->humidity;
    }

    /**
     * Set Humidity
     * @param mixed|null $humidity
     * @return $this
     */
    public function setHumidity($humidity)
    {
        $this->humidity = $humidity;
        return $this;
    }

    /**
     * Get Temp
     * @return mixed|null
     */
    public function getTemp()
    {
        return $this->temp;
    }

    /**
     * Set Temp
     * @param mixed|null $temp
     * @return $this
     */
    public function setTemp($temp)
    {
        $this->temp = $temp;
        return $this;
    }

    /**
     * Get Used
     * @return bool
     */
    public function isUsed()
    {
        return $this->used;
    }

    /**
     * Set Used
     * @param bool $used
     * @return $this
     */
    public function setUsed($used)
    {
        $this->used = $used;
        return $this;
    }
}