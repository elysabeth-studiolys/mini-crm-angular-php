<?php

require_once 'Collection.php';
require_once 'Contact.php';

class ContactCollection extends Collection
{
    public function add(object $item): void
    {
        if (!$item instanceof Contact) {
            throw new InvalidArgumentException("L'objet doit être une instance de Contact.");
        }
        $this->items->append($item);
    }

    public function removeById(int $id_contact): void
    {
        foreach ($this->items as $key => $contact) {
            if ($contact->getIdContact() === $id_contact) {
                unset($this->items[$key]);
                return;
            }
        }
    }
}
