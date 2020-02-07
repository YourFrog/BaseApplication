<?php

namespace AppBundle\Service\Notes;

use AppBundle\Entity;

/**
 *  Pobranie aktywnych elementów z notatki
 *
 * @package AppBundle\Service\Notes
 */
class ListOfActiveNoteItems
{
    /**
     *  Pobranie aktywnych elementów notatki
     *
     * @param Entity\Notes\Note $note
     *
     * @return array
     */
    public function execute(Entity\Notes\Note $note): array
    {
        return array_filter($note->getItems(), function(Entity\Notes\NoteItem $noteItem) {
            return !$noteItem->isGhost();
        });
    }
}