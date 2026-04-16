<?php

require_once 'controllers/ContactController.php';
require_once 'controllers/CompanyController.php';

//RECUP HTTP ET URL
$method = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

//POUR ANGULAR
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($method === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$contactController = new ContactController();
$companyController = new CompanyCollection();

//ROUTING
match (true) {
    $method === 'GET'       && $uri === '/api/contacts'   => $contactController->showContacts(),
    $method === 'POST'      && $uri === '/api/contacts'   => $contactController->createContact(),
    $method === 'PUT'       && preg_match('#^/api/contacts/(\d+)$#', $uri, $m) => $contactController->updateContact((int)$m[1]),
    $method === 'DELETE'    && preg_match('#^/api/contacts/(\d+)$#', $uri, $m) => $contactController->deleteContact((int)$m[1]),

    $method === 'GET'       && $uri === '/api/companies'         => $companyController->showCompanies(),
    $method === 'POST'      && $uri === '/api/companies'         => $companyController->createCompany(),
    $method === 'PUT'       && preg_match('#^/api/companies/(\d+)$#', $uri, $m) => $companyController->updateCompany((int)$m[1]),
    $method === 'DELETE'    && preg_match('#^/api/companies/(\d+)$#', $uri, $m) => $companyController->deleteCompany((int)$m[1]),

    default => (function () {
        http_response_code(404);
        echo json_encode(['error' => 'ROOT non trouvée']);
    })()
};
