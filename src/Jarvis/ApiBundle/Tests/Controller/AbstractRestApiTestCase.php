<?php

namespace Jarvis\ApiBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Client;

/**
 * Class AbstractRestApiTestCase
 *
 * REST tests methods
 * @package Jarvis\ApiBundle\Tests\Controller
 */
abstract class AbstractRestApiTestCase extends AbstractApiTestCase
{
    /**
     * @var string
     */
    protected $url_prefix = null;

    /**
     * Get a random object
     * @return array
     */
    abstract public function getRandomObject();

    /**
     * POST as admin
     */
    public function testPostActionAsAdmin()
    {
        $this->isSuccessful($this->addObjectAsAdmin($this->url_prefix, $this->getRandomObject()));
    }

    /**
     * GET collection
     */
    public function testGetCollectionAction()
    {
        $client = $this->getClient($this->logAsAdmin());

        // Create objects
        $objs = [
            $this->getRandomObject(),
            $this->getRandomObject(),
        ];

        // Create some objects
        $this->addObjectAsAdmin($this->url_prefix, $objs[0]);
        $this->addObjectAsAdmin($this->url_prefix, $objs[1]);

        $response = $this->makeApiRequest('GET', $this->url_prefix . '?sort=id');

        $this->isSuccessful($response);
        $this->assertCollectionEqual($objs, $response);
    }
}