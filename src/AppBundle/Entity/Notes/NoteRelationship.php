<?php

namespace AppBundle\Entity\Notes;

use AppBundle\Entity\Common;
use AppBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(schema="notes", name="note_relationship")
 * @ORM\HasLifecycleCallbacks()
 */
class NoteRelationship
{
    use Common;

    const OWNER = 'owner';
    const COOWNER = 'coowner';

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    private $ghost = false;

    /**
     * @var Note
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Notes\Note", inversedBy="relations")
     * @ORM\JoinColumn(name="id_note", referencedColumnName="id_note")
     */
    private $note;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(name="id_user", referencedColumnName="id")
     */
    private $user;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $type;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param Note $note
     */
    public function setNote(Note $note)
    {
        if( $this->note === $note ) {
            return;
        }

        $this->note = $note;
        $this->note->addRelationship($this);
    }

    /**
     * @param User $user
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }

    /**
     * @param string $type
     */
    public function setType(string $type)
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }
}