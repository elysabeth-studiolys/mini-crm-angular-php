<?php

require_once 'Collection.php';
require_once 'Company.php';

class CompanyCollection extends Collection
{
    public function add(object $item): void
    {
        if (!$item instanceof Company) {
            throw new InvalidArgumentException("L'objet doit être une instance de Contact.");
        }
        $this->items->append($item);
    }

    public function removeById(int $id_company): void
    {
        foreach ($this->items as $key => $company) {
            if ($company->getIdCompany() === $id_company) {
                unset($this->items[key]);
                return;
            }
        }
    }
}
