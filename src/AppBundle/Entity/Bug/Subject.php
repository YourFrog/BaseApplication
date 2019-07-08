<?php

namespace AppBundle\Entity\Bug;

use AppBundle\Entity\Common;
use Doctrine\ORM\Mapping as ORM;

/**
 *  Tytuł błędu
 *
 * @package AppBundle\Entity\Bug
 *
 * @ORM\Entity
 * @ORM\Table(schema="bug", name="subject")
 * @ORM\HasLifecycleCallbacks()
 */
class Subject
{
    use Common;

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer", name="id_subject")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     *  Nazwa
     *
     * @var string
     *
     * @ORM\Column(type="string", name="name", nullable=false)
     */
    private $name;

    /**
     *  Kolejność wyświetlania elementu
     *
     * @var int
     *
     * @ORM\Column(type="integer", name="priority", nullable=false)
     */
    private $priority;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param int $priority
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;
    }

    function __toString()
    {
        return $this->name;
    }
}