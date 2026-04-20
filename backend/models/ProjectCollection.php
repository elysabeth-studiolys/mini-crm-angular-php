<?php

require_once 'Collection.php';
require_once 'Project.php';

class ProjectCollection extends Collection
{
    public function add(object $item): void
    {
        if (!$item instanceof Deal) {
            throw new InvalidArgumentException("L'objet doit être une instance de project.");
        }
        $this->items->append($item);
    }

    public function removeById(int $id_project): void
    {
        foreach ($this->items as $key => $project) {
            if ($project->getIdProject() === $id_project) {
                unset($this->items[key]);
                return;
            }
        }
    }
}
