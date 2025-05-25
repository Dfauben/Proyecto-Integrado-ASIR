<?php
require '../funciones.php';
$archivoDatos = '../data/contactos.json';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $contactos = leerContactos($archivoDatos);

    // Sanitize and validate inputs
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
    $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);
    $telefono = filter_input(INPUT_POST, 'telefono', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

    if (!$id) {
        http_response_code(400);
        echo json_encode(['error' => 'ID de contacto inválido.']);
        exit;
    }
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

    // Find the contact to update
    $contactoAEditar = null;
    foreach ($contactos as $index => $contacto) {
        if ($contacto['id'] == $id) {
            $contactoAEditar = $contacto;
            $posicion = $index;
            break;
        }
    }

    if (!$contactoAEditar) {
        http_response_code(404);
        echo json_encode(['error' => 'Contacto no encontrado.']);
        exit;
    }

    // Handle image upload
    $imagen = $contactoAEditar['imagen'];
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $nuevaImagen = subirImagen($_FILES['imagen'], '../uploads');
        if ($nuevaImagen === null) {
            http_response_code(400);
            echo json_encode(['error' => 'Error al subir la imagen.']);
            exit;
        }
        // Delete old image if exists
        if ($imagen !== null) {
            eliminarImagen('../uploads', $imagen);
        }
        $imagen = $nuevaImagen;
    }

    // Update contact data
    $nuevosDatos = [
        'id' => $id,
        'nombre' => $nombre,
        'telefono' => $telefono,
        'email' => $email,
        'imagen' => $imagen,
        'password' => $contactoAEditar['password'] // Keep existing password
    ];

    $contactos = actualizarContacto($contactos, $id, $nuevosDatos);

    if (guardarContactos($archivoDatos, $contactos)) {
        echo json_encode(['success' => 'Contacto actualizado con éxito']);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Error al guardar el contacto']);
    }
}
?>
