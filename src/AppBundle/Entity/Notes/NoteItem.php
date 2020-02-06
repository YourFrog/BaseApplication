<?php

namespace AppBundle\Entity\Notes;

use AppBundle\Entity\Common;
use AppBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(schema="notes", name="note_item")
 * @ORM\HasLifecycleCallbacks()
 */
class NoteItem
{
    use Common;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Note
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Notes\Note", inversedBy="items")
     * @ORM\JoinColumn(name="id_note", referencedColumnName="id_note")
     */
    private $note;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    private $ghost = false;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    private $checked = false;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @param Note $note
     */
    public function setNote(Note $note)
    {
        $this->note = $note;
    }

    /**
     * @param bool $ghost
     */
    public function setGhost(bool $ghost)
    {
        $this->ghost = $ghost;
    }

    /**
     * @param bool $checked
     */
    public function setChecked(bool $checked)
    {
        $this->checked = $checked;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return bool
     */
    public function isChecked(): bool
    {
        return $this->checked;
    }

    /**
     * @return bool
     */
    public function isGhost(): bool
    {
        return $this->ghost;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return Note
     */
    public function getNote(): Note
    {
        return $this->note;
    }
}