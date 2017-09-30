<?php
namespace Jarvis\ApiBundle\Tests\Service;

use Liip\FunctionalTestBundle\Test\WebTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class AbstractValidationTestCase
 * @package Jarvis\ApiBundle\Tests\Service
 */
abstract class AbstractValidationTestCase extends WebTestCase
{
    /**
     * @var ValidatorInterface
     */
    private $validator;

    protected function setUp()
    {
        $this->validator = self::createClient(array('environment' => 'test'))->getContainer()->get('validator');
    }

    /**
     * @return ValidatorInterface
     */
    public function getValidator()
    {
        return $this->validator;
    }
}