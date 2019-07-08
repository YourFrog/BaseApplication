<?php

namespace AppBundle\DataFixtures\ORM\Bug;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 *  Podstawowe dane dotyczące częstotliowści bug'ów
 */
class Frequency extends AbstractFixture implements ORMFixtureInterface, OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $object = new \AppBundle\Entity\Bug\Frequency();
        $object->setName('Występuje zawsze');
        $object->setPriority(30);
        $manager->persist($object);

        $object = new \AppBundle\Entity\Bug\Frequency();
        $object->setName('Problem z odtworzeniem');
        $object->setPriority(20);
        $manager->persist($object);

        $object = new \AppBundle\Entity\Bug\Frequency();
        $object->setName('Nie potrafię odtworzyć błędu');
        $object->setPriority(10);
        $manager->persist($object);

        $manager->flush();
    }

    public function getOrder()
    {
        return 200;
    }
}