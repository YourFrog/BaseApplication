<?php

namespace AppBundle\Repository\Notes;

use AppBundle\Entity;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\ORM\Query\ResultSetMappingBuilder;

/**
 *  Repozytorium obsługujące notatki
 *
 * @package AppBundle\Repository\Notes
 */
class NoteRepository
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     *  Konstruktor
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     *  Pobranie notatek przynależnych do użytkownika
     *
     * @param Entity\User $user
     *
     * @return Entity\Notes\Note[]
     */
    public function findByUser(Entity\User $user): array
    {
        $rsm = new ResultSetMappingBuilder($this->entityManager, ResultSetMappingBuilder::COLUMN_RENAMING_INCREMENT);
        $rsm->addRootEntityFromClassMetadata(Entity\Notes\Note::class, 'note');
//        $rsm->addJoinedEntityFromClassMetadata(Entity\Notes\NoteRelationship::class, 'note_relationship', 'note', 'relations', ['id' => 'id_note']);

        $query = $this->entityManager->createNativeQuery("
            SELECT
                " . $rsm->generateSelectClause([]) . "
            FROM
                notes.note
                JOIN notes.note_relationship ON note.id_note = note_relationship.id_note
            WHERE
                note_relationship.id_user = ?
        ", $rsm);
        $query->setParameter(1, $user->getId());

        return $query->getResult();
    }
}