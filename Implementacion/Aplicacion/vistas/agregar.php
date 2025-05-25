<?php
require '../funciones.php';
$archivoDatos = '../data/contactos.json';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $contactos = leerContactos($archivoDatos);

    // Sanitize and validate inputs
    $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);
    $telefono = filter_input(INPUT_POST, 'telefono', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

    if (!$nombre) {
        http_response_code(400);
        echo json_encode(['error' => 'Nombre es obligatorio y debe ser válido.']);
        exit;
    }
    if ($email === false) {
        http_response_code(400);
        echo json_encode(['error' => 'Email no es válido.']);
        exit;
    }

    // Generate new ID using generarId function
    $nuevoId = generarId($contactos);

    // Handle image upload
    $imagen = null;
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] !== UPLOAD_ERR_NO_FILE) {
        $imagen = subirImagen($_FILES['imagen'], '../uploads');
        if ($imagen === null) {
            http_response_code(400);
            echo json_encode(['error' => 'Error al subir la imagen.']);
            exit;
        }
    }

    $nuevoContacto = [
        'id' => $nuevoId,
        'nombre' => $nombre,
        'telefono' => $telefono,
        'email' => $email,
        'imagen' => $imagen,
        'password' => generarPassword()
    ];

    $contactos[] = $nuevoContacto;
    if (guardarContactos($archivoDatos, $contactos)) {
        echo json_encode(['success' => 'Contacto agregado con éxito']);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Error al guardar el contacto']);
    }
}
?>
