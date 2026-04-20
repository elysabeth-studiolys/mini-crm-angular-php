<?php

require_once 'Collection.php';
require_once 'Deal.php';

class DealCollection extends Collection
{
    public function add(object $item): void
    {
        if (!$item instanceof Deal) {
            throw new InvalidArgumentException("L'objet doit être une instance de Deal.");
        }
        $this->items->append($item);
    }

    public function removeById(int $id_deal): void
    {
        foreach ($this->items as $key => $deal) {
            if ($deal->getIdDeal() === $id_deal) {
                unset($this->items[key]);
                return;
            }
        }
    }
}
