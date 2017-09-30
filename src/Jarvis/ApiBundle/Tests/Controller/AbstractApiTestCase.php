<?php

namespace Jarvis\ApiBundle\Tests\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Client;

/**
 * Class AbstractApiTestCase
 *
 * Extend classic WebTestCase
 * @package Jarvis\ApiBundle\Tests\Controller
 */
abstract class AbstractApiTestCase extends WebTestCase
{
    /** @var Client */
    private $client = null;

    /**
     * {@inheritdoc]
     */
    public function setUp()
    {
        $this->initDatabase();
    }

    /**
     * Makes a request to our API
     *
     * @param string $method
     * @param string $url
     * @param string $jsonPayload
     * @param null $user
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function makeApiRequest($method, $url, $jsonPayload = null, $user = null)
    {
        $headers = [
            'HTTP_ACCEPT' => 'application/json',
            'CONTENT_TYPE' => 'application/json',
        ];

        $this->getClient($user)->request($method, $url, [], [], $headers, $jsonPayload);

        return $this->client->getResponse();
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Response $response
     * @return array
     */
    protected function getJsonToArray($response)
    {
        return json_decode($response->getContent(), true);
    }

    /**
     * Check that $search_this is contains in $all
     * @param array $search_this
     * @param array $all
     * @return bool
     */
    protected function checkArrayContainsOther($search_this, $all)
    {
        return !array_diff($search_this, $all);
    }

    /**
     * @param array $send
     * @param \Symfony\Component\HttpFoundation\Response $response $response
     */
    protected function assertCollectionEqual($send, $response)
    {
        $response_array = $this->getJsonToArray($response);

        foreach ($send as $key => $value) {
            self::assertTrue($this->checkArrayContainsOther($send[$key], $response_array[$key]));
        }
    }

    /**
     * Create new client
     * @param array $user
     * @return Client
     */
    protected function getClient($user = null)
    {
        if ($user === null) {
            $user = $this->logAsAdmin();
        }

        $this->client = $this->makeClient($user);

        return $this->client;
    }

    /**
     * Get admin client
     * @return Client
     */
    protected function getClientAdmin()
    {
        return $this->getClient($this->logAsAdmin());
    }

    /**
     * Get user client
     * @return Client
     */
    protected function getClientUser()
    {
        return $this->getClient($this->logAsUser());
    }

    /**
     * Init database
     */
    protected function initDatabase()
    {
        $this->loadFixtures(array());
    }

    /**
     * Get user
     * @return array
     */
    protected function logAsAdminDb()
    {
        return [
            'username' => 'admin_db',
            'password' => 'test',
        ];
    }

    /**
     * Get user
     * @return array
     */
    protected function logAsEntityDb()
    {
        return [
            'username' => 'entity_db',
            'password' => 'test',
        ];
    }

    /**
     * Get user
     * @return array
     */
    protected function logAsUser()
    {
        return [
            'username' => 'user',
            'password' => 'test',
        ];
    }

    /**
     * Get admin
     * @return array
     */
    protected function logAsAdmin()
    {
        return [
            'username' => 'admin',
            'password' => 'test',
        ];
    }

    /**
     * Add object
     * @param $user
     * @param $url
     * @param $object
     * @return \Symfony\Component\HttpFoundation\Response
     */
    private function addObject($user, $url, $object)
    {
        return $this->makeApiRequest('POST', $url, json_encode($object), $user);
    }

    /**
     * Add object as
     * @param $url
     * @param $object
     * @param $user
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function addObjectAs($url, $object, $user)
    {
        return $this->addObject($user, $url, $object);
    }

    /**
     * Add object as user
     * @param $url
     * @param $object
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function addObjectAsUser($url, $object)
    {
        return $this->addObject($this->logAsUser(), $url, $object);
    }

    /**
     * Add object as admin
     * @param $url
     * @param $object
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function addObjectAsAdmin($url, $object)
    {
        return $this->addObject($this->logAsAdmin(), $url, $object);
    }
}