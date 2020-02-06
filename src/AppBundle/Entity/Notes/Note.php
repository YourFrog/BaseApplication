<?php

namespace AppBundle\Entity\Notes;

use AppBundle\Entity\Common;
use AppBundle\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(schema="notes", name="note")
 * @ORM\HasLifecycleCallbacks()
 */
class Note
{
    use Common;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer", name="id_note")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    protected $ghost = false;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     */
    private $owner;

    /**
     * @var NoteItem[]
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Notes\NoteItem", mappedBy="note")
     */
    private $items;

    /**
     * Note constructor.
     */
    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return User
     */
    public function getOwner(): User
    {
        return $this->owner;
    }

    /**
     * @param bool $ghost
     */
    public function setGhost(bool $ghost)
    {
        $this->ghost = $ghost;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return NoteItem[]
     */
    public function getItems(): array
    {
        return $this->items->filter(function(NoteItem $item) {
            return !$item->isGhost();
        })->toArray();
    }

    /**
     * @param User $owner
     */
    public function setOwner(User $owner)
    {
        $this->owner = $owner;
    }

    /**
     * @param string $name
     *
     * @return void
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

}