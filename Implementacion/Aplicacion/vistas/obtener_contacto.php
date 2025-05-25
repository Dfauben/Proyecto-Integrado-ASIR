<?php
// Disable error display and enable error logging to prevent breaking JSON responses
ini_set('display_errors', 0);
ini_set('log_errors', 1);
error_reporting(E_ALL);

require '../funciones.php';
$archivoDatos = '../data/contactos.json';
$contactos = leerContactos($archivoDatos);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
    if (!$id) {
        http_response_code(400);
        echo json_encode(['error' => 'ID de contacto inválido.']);
        exit;
    }
    $contacto = buscarContactoPorID($contactos, $id);
    if ($contacto) {
        echo json_encode($contacto);
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'Contacto no encontrado']);
    }
}
?>
