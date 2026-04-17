<?php

require_once 'models/Deal.php';

class DealController {

    public function showDeals()
    {
        require_once 'config/database.php';
        $data = Deal::getAllFromDb($pdo);

        $result = array_map(fn(Deal $d) => [
            'id_deal' => $d->getIdDeal(),
            'name' => $d->getName(),
            'amount' => $d->getAmount(),
            'id_contact' => $d->getIdContact(),
            'id_¨company' => $d->getIdCompany(),
            'date' => $d->getDate()?->format('Y-m-d'),
            'status' => $d->getStatus(),
        ], $data);
        echo json_encode($result);
    }

    public function createDeal()
    {
        require_once 'config/database.php';

        $body = json_decode(file_get_contents('php://input'), true);

        Deal::createInDb($pdo, $body);

        http_response_code(201);
        echo json_encode(['message' => 'Vente crée avec succès']);
    }

    public function updateinDb()
    {
        require_once 'config/database.php';

        $body = json_decode(file_get_contents('php://input'), true);

        Deal::updateInDb($pdo, $id, $body);

        echo json_encode(['message' => 'Vente modifiée']);
    }

    public function deleteDeal(int $id)
    {
        require_once 'config/database.php';

        Deal::deleteFromDb($pdo, $id);

        echo json_encode(['message' => 'Contact supprimé']);
    }
}