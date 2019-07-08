<?php

namespace AppBundle\DataFixtures\ORM\Bug;


use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class Report extends AbstractFixture implements ORMFixtureInterface, OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $frequency = $manager->getRepository(\AppBundle\Entity\Bug\Frequency::class)->findOneBy([]);
        $subject = $manager->getRepository(\AppBundle\Entity\Bug\Subject::class)->findOneBy([]);

        $entity = new \AppBundle\Entity\Bug\Report();
        $entity->setEmail('test@test.pl');
        $entity->setLink('onet.pl');
        $entity->setDescription('Testowy opis');
        $entity->setFrequency($frequency);
        $entity->setSubject($subject);

        $manager->persist($entity);

        $manager->flush();
    }

    public function getOrder()
    {
        return 300;
    }
}