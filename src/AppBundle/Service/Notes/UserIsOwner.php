<?php

namespace AppBundle\Service\Notes;

use AppBundle\Entity\Notes\Note;
use AppBundle\Entity\Notes\NoteItem;
use AppBundle\Entity\Notes\NoteRelationship;
use AppBundle\Entity\User;

/**
 *  Sprawdzenie czy użytkownik jest właścicielem notatki
 *
 * @package AppBundle\Service\Notes
 */
class UserIsOwner
{
    /**
     * @param Note $note
     * @param User $user
     *
     * @return bool
     */
    public function execute(Note $note, User $user)
    {
        foreach($note->getRelations() as $relation) {
            if( $relation->getType() === NoteRelationship::OWNER ) {
                return true;
            }
        }

        return false;
    }
}