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
     * @var NoteRelationship[]
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Notes\NoteRelationship", mappedBy="note")
     */
    private $relations;

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
        $this->relations = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
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
     * @return NoteRelationship[]
     */
    public function getRelations(): array
    {
        return $this->relations->toArray();
    }

    /**
     * @param NoteRelationship $relation
     */
    public function addRelationship(NoteRelationship $relation)
    {
        if( $this->relations->contains($relation) ) {
            return;
        }

        $this->relations->add($relation);
        $relation->setNote($this);
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

    /**
     * @return NoteItem[]
     */
    public function getItems(): array
    {
        return $this->items->toArray();
    }

    /**
     * @return bool
     */
    public function isGhost(): bool
    {
        return $this->ghost;
    }
}