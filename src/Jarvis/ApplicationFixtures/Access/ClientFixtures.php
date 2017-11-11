<?php

namespace Jarvis\ApplicationFixtures\Access;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use FOS\OAuthServerBundle\Model\ClientManager;
use Jarvis\DomainBundle\Entity\Access\Client;
use OAuth2\OAuth2;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

/**
 * Class ClientFixtures
 * @package Jarvis\ApplicationFixtures\Access
 */
class ClientFixtures extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $jarvisClientApplicationName = $this->container->getParameter('jarvis_oauth_application');

        $repository = $manager->getRepository(Client::class);

        $client = $repository->findOneByApplicationName($jarvisClientApplicationName);

        if ($client === null) {
            $jarvisClientOrigin = $this->container->getParameter('jarvis_oauth_origin');
            /** @var ClientManager $clientManager */
            $clientManager = $this->container->get('fos_oauth_server.client_manager.default');
            /** @var Client $client */
            $client = $clientManager->createClient();
            $client->setRedirectUris(array($jarvisClientOrigin));
            $client->setAllowedGrantTypes(array(OAuth2::GRANT_TYPE_USER_CREDENTIALS));
            $client->setApplicationName($jarvisClientApplicationName);
            $client->setOrigin($jarvisClientOrigin);
            $manager->persist($client);
            $manager->flush();
        }

    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 1;
    }

}