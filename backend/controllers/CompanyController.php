<?php

require_once 'models/Company.php';

class CompanyCollection
{
    public function showCompanies()
    {
        require_once 'config/database.php';
        $data = Company::getAllFromDb($pdo);

        $result = array_map(fn(Company $c) => [
            'id_company' => $c->getIdCompany(),
            'name' => $c->getName(),
            'secteur' => $c->getSecteur(),
            'email' => $c->getEmail(),
            'phone' => $c->getPhone(),
            'adress' => $c->getAdress(),

        ], $data);
        echo json_encode($result);
    }

    public function createCompany()
    {

        require_once 'config/database.php';

        $body = json_decode(file_get_contents('php://input'), true);

        Company::createInDb($pdo, $body);

        http_response_code(201);
        echo json_encode(['message' => 'Entreprise créé avec succès']);
    }

    public function updateCompany(int $id)
    {
        require_once 'config/database.php';

        $body = json_decode(file_get_contents('php://input'), true);

        Company::updateInDb($pdo, $id, $body);

        echo json_encode(['message' => 'Entreprise modifié']);
    }

    public function deleteCompany(int $id)
    {
        require_once 'config/database.php';

        Company::deleteFromDb($pdo, $id);

        echo json_encode(['message' => 'Entreprise supprimé']);
    }
}
