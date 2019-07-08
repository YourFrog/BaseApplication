<?php

namespace AppBundle\DataFixtures\ORM\Bug;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 *  Podstawowe dane dotyczące tytułów zgłaszanych błędów
 */
class Subject extends AbstractFixture implements ORMFixtureInterface, OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $object = new \AppBundle\Entity\Bug\Subject();
        $object->setName('Literówka na stronie');
        $object->setPriority(30);
        $manager->persist($object);

        $object = new \AppBundle\Entity\Bug\Subject();
        $object->setName('Poważny błąd uniemożliwiający pracę');
        $object->setPriority(20);
        $manager->persist($object);

        $object = new \AppBundle\Entity\Bug\Subject();
        $object->setName('Inny');
        $object->setPriority(10);
        $manager->persist($object);

        $manager->flush();
    }

    public function getOrder()
    {
        return 200;
    }
}