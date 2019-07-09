<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 *  Załadowanie użytkowników
 */
class User extends AbstractFixture implements ORMFixtureInterface, OrderedFixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $factory = $this->container->get('security.encoder_factory');


        $object = new \AppBundle\Entity\User();
        $object->setRoles([\AppBundle\Entity\User::ROLE_ADMIN]);
        $object->setEmail('stedi2@o2.pl');
        $object->setEmailCanonical('stedi2@o2.pl');
        $object->setUsername('YourFrog');
        $object->setUsernameCanonical('YourFrog');
        $object->setEnabled(true);
        $object->setSalt(md5(time()));
        $password = $factory->getEncoder($object)->encodePassword('admin', $object->getSalt());
        $object->setPassword($password);
        $manager->persist($object);

        $object = new \AppBundle\Entity\User();
        $object->setEmail('natalia.rabiega@gmail.com');
        $object->setEmailCanonical('natalia.rabiega@gmail.com');
        $object->setUsername('Natttka');
        $object->setUsernameCanonical('Natttka');
        $object->setEnabled(true);
        $object->setSalt(md5(time()));
        $password = $factory->getEncoder($object)->encodePassword('admin', $object->getSalt());
        $object->setPassword($password);
        $manager->persist($object);

        $manager->flush();
    }

    public function getOrder()
    {
        return 100;
    }
}