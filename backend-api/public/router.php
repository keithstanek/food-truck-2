<?php
<?php
header('Content-Type: application/json');
require_once '../classes/db_conn.php';
require_once '../classes/crud.php';

$db = (new Database())->getConnection();
$crud = new GenericCrud($db);

$data = json_decode(file_get_contents('php://input'), true);

$table = $data['table'] ?? null;
$action = $data['action'] ?? null;
$payload = $data['payload'] ?? [];
$where = $data['where'] ?? [];

if (!$table || !$action) {
    echo json_encode(['success' => false, 'message' => 'Missing table or action']);
    exit;
}

try {
    switch ($action) {
        case 'create':
            $result = $crud->create($table, $payload);
            echo json_encode(['success' => true, 'id' => $result]);
            break;
        case 'read':
            $result = $crud->read($table, $where);
            echo json_encode(['success' => true, 'data' => $result]);
            break;
        case 'update':
            $result = $crud->update($table, $payload, $where);
            echo json_encode(['success' => $result]);
            break;
        case 'delete':
            $result = $crud->delete($table, $where);
            echo json_encode(['success' => $result]);
            break;
        default:
            echo json_encode(['success' => false, 'message' => 'Unknown action']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}