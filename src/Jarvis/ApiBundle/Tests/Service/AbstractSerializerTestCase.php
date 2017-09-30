<?php

namespace Jarvis\ApiBundle\Tests\Service;

use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class AbstractSerializerTestCase
 * @package Jarvis\ApiBundle\Tests\Service
 */
abstract class AbstractSerializerTestCase extends WebTestCase
{
    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $this->serializer = self::createClient(array('environment' => 'test'))->getContainer()->get('serializer');
    }

    /**
     * @return SerializerInterface
     */
    public function getSerializer()
    {
        return $this->serializer;
    }

    /**
     * Test default serialization
     */
    public function test_default_serialization()
    {
        self::assertSameAs($this->getDefaultExpected(), $this->getSerializer()->serialize($this->getDefaultObject(), 'json', SerializationContext::create()->setGroups(['Default'])));
    }

    /**
     * @param array $expected
     * @param $actual
     */
    public static function assertSameAs(array $expected, $actual)
    {
        self::assertEquals($expected, (array) json_decode($actual, true));
    }

    /**
     * @return object
     */
    abstract protected function getDefaultObject();

    /**
     * @return array
     */
    abstract protected function getDefaultExpected();
}