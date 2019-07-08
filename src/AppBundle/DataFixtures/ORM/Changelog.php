<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class Changelog extends AbstractFixture
{
    public function load(ObjectManager $manager)
    {
        $object = new \AppBundle\Entity\Changelog();
        $object->setVersion('0.0.1');
        $object->setDate(new \DateTime());
        $object->addItem('Utworzenie ...');
        $object->addItem('Utworzenie 2...');

        $manager->persist($object);
        $manager->flush();
    }

}