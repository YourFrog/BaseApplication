<?php

namespace AppBundle\DataFixtures\ORM\News;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Created by PhpStorm.
 * User: YourFrog
 * Date: 2019-07-08
 * Time: 23:38
 */
class News extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $object = new \AppBundle\Entity\News\News();
        $object->setAuthor($manager->getRepository(\AppBundle\Entity\User::class)->find(1));
        $object->setTitle('Hello normal');
        $object->setContent('Hello normal world!');
        $object->setPublished(true);
        $object->setType('normal');

        $manager->persist($object);


        $object = new \AppBundle\Entity\News\News();
        $object->setAuthor($manager->getRepository(\AppBundle\Entity\User::class)->find(1));
        $object->setTitle('Hello short');
        $object->setContent('Hello short world!');
        $object->setPublished(true);
        $object->setType('short');

        $manager->persist($object);
        $manager->flush();
    }

    public function getOrder()
    {
        return 200;
    }
}