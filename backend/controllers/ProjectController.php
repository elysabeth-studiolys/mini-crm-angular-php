<?php

require_once 'models/Project.php';

class ProjectController {

    public function showProjects() {

        require_once 'config/database.php';
        $data = Project::getAllFromDb($pdo);

        $result = array_map(fn(Project $p) => [
            'id_project' => $p->getIdProject(),
            'name' => $p->getName(),
            'description' => $p->getDescription(),
            'status' => $p->getStatus(),
            'contact_name' => $p->getContactName(),
            'company_name' => $p->getCompanyName(),
            'price' => $p->getPrice(),
            'date' => $p->getDate()?->format('d/m/Y'),

        ], $data);
        echo json_encode($result);
    }

    public function createProject()
    {
        require_once 'config/database.php';

        $body = json_decode(file_get_contents('php://input'), true);

        Project::createInDb($pdo, $body);

        http_response_code(201);
        echo json_encode(['message' => 'projet crée avec succès']);
    }

    public function updateinDb()
    {
        require_once 'config/database.php';

        $body = json_decode(file_get_contents('php://input'), true);

        Project::updateInDb($pdo, $id, $body);

        echo json_encode(['message' => 'project modifié']);
    }

    public function deleteProject(int $id)
    {
        require_once 'config/database.php';

        Project::deleteFromDb($pdo, $id);

        echo json_encode(['message' => 'projet supprimé']);
    }
}