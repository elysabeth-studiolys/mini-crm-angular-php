<?php

require_once 'models/Contact.php';

class ContactController
{
    public function showContacts()
    {
        require_once 'config/database.php';
        $data = Contact::getAllFromDb($pdo);

        $result = array_map(fn(Contact $c) => [
            'id_contact' => $c->getIdContact(),
            'first_name' => $c->getFirstName(),
            'last_name' => $c->getLastName(),
            'email' => $c->getEmail(),
            'phone' => $c->getPhone(),
            'status' => $c->getStatus(),

        ], $data);
        echo json_encode($result);
    }

    public function createContact()
    {

        require_once 'config/database.php';

        $body = json_decode(file_get_contents('php://input'), true);

        Contact::createInDb($pdo, $body);

        http_response_code(201);
        echo json_encode(['message' => 'Contact créé avec succès']);
    }

    public function updateContact(int $id)
    {
        require_once 'config/database.php';

        $body = json_decode(file_get_contents('php://input'), true);

        Contact::updateInDb($pdo, $id, $body);

        echo json_encode(['message' => 'Contact modifié']);
    }

    public function deleteCOntact(int $id)
    {
        require_once 'config/database.php';

        Contact::deleteFromDb($pdo, $id);

        echo json_encode(['message' => 'Contact supprimé']);
    }
}
