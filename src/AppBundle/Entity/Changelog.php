<?php

namespace AppBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 *  Encja opisująca changelog aplikacji
 *
 * @package AppBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(schema="public", name="changelog")
 * @ORM\HasLifecycleCallbacks()
 */
class Changelog
{
    use Common;

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=false)
     */
    private $date;

    /**
     * @var String
     *
     * @ORM\Column(name="version", type="string", nullable=false)
     */
    private $version;

    /**
     *  Szczegółowe informacje o zmianach
     *
     * @var String[]
     *
     * @ORM\Column(name="content", type="array", nullable=false)
     */
    private $items;

    /**
     * @param DateTime $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @param String $version
     */
    public function setVersion($version)
    {
        $this->version = $version;
    }

    /**
     * @param string $value
     */
    public function addItem($value)
    {
        $this->items[] = $value;
    }

    /**
     * @return DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @return String
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @return \String[]
     */
    public function getItems()
    {
        return $this->items;
    }
}