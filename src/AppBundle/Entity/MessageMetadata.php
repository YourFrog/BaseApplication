<?php
// src/AppBundle/Entity/MessageMetadata.php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\MessageBundle\Entity\MessageMetadata as BaseMessageMetadata;

/**
 * @ORM\Entity
 * @ORM\Table(schema="message", name="metadata")
 * @ORM\HasLifecycleCallbacks()
 */
class MessageMetadata extends BaseMessageMetadata
{
    use Common;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(
     *   targetEntity="AppBundle\Entity\Message",
     *   inversedBy="metadata"
     * )
     * @var \FOS\MessageBundle\Model\MessageInterface
     */
    protected $message;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @var \FOS\MessageBundle\Model\ParticipantInterface
     */
    protected $participant;
}