<?php


namespace AppBundle\Service\Notes;

use AppBundle\Entity;
use AppBundle\Repository\Notes\NoteRepository;
use Doctrine\ORM\EntityRepository;

/**
 *  Lista aktywnych notatek
 *
 * @package AppBundle\Service\Notes
 */
class ListOfActiveNote
{
    /**
     * @var NoteRepository
     */
    private $noteRepository;

    /**
     *  Konstruktor
     *
     * @param NoteRepository $noteRepository
     */
    public function __construct(NoteRepository $noteRepository)
    {
        $this->noteRepository = $noteRepository;
    }

    /**
     * @param Entity\User $user
     *
     * @return array
     */
    public function execute(Entity\User $user): array
    {
        $notes = $this->noteRepository->findByUser($user);

        return array_filter($notes, function(Entity\Notes\Note $note) {
            return !$note->isGhost();
        });
    }
}