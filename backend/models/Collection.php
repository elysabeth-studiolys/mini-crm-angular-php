<?php

abstract class Collection
{
    protected ArrayObject $items;

    public function __construct()
    {
        $this->items = new ArrayObject();
    }

    abstract public function add(object $item): void;

    public function getAll(): array
    {
        return $this->items->getArrayCopy();
    }
}
