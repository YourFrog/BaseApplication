<?php

namespace AppBundle\Entity;

use DateTime;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Mapping as ORM;

/**
 * @package AppBundle\Entity
 *
 * @ORM\Class Common
 */
trait Common
{
    /**
     * @var DateTime
     *
     * @ORM\Column(name="added", type="datetimetz", nullable=false)
     */
    private $createAt;

    /**
     * @var DateTime|null
     *
     * @ORM\Column(name="modified", type="datetimetz", nullable=true)
     */
    private $updateAt;

    /**
     * @return DateTime
     */
    public function getCreateAt()
    {
        return $this->createAt;
    }

    /**
     * @return DateTime|null
     */
    public function getUpdateAt()
    {
        return $this->updateAt;
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     *
     * @ORM\PrePersist
     */
    public function preInsert(LifecycleEventArgs $eventArgs)
    {
        $this->createAt = new DateTime();
    }

    /**
     * @param PreUpdateEventArgs $eventArgs
     *
     * @ORM\PreUpdate
     */
    public function preUpdate(PreUpdateEventArgs $eventArgs)
    {
        $this->updateAt = new DateTime();
    }
}