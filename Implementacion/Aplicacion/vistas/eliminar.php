<?php
require '../funciones.php';
$archivoDatos = '../data/contactos.json';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize input
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
    if (!$id) {
        http_response_code(400);
        echo json_encode(['error' => 'ID de contacto inválido.']);
        exit;
    }

    // Leer los contactos del archivo JSON
    $contactos = leerContactos($archivoDatos);

    // Buscar el contacto a eliminar
    $contactoAEliminar = null;
    foreach ($contactos as $index => $contacto) {
        if ($contacto['id'] == $id) {
            $contactoAEliminar = $contacto;
            $posicion = $index;
            break;
        }
    }

    if (!$contactoAEliminar) {
        http_response_code(404);
        echo json_encode(['error' => 'Contacto no encontrado.']);
        exit;
    }

    // Eliminar el contacto seleccionado
    array_splice($contactos, $posicion, 1);
    if (!guardarContactos($archivoDatos, $contactos)) {
        http_response_code(500);
        echo json_encode(['error' => 'Error al guardar los contactos.']);
        exit;
    }

    // Eliminar la imagen del contacto
    if ($contactoAEliminar['imagen'] !== null) {
        eliminarImagen('../uploads', $contactoAEliminar['imagen']);
    }

    // Obtener la lista de imágenes utilizadas
    $imagenesUtilizadas = array();
    foreach ($contactos as $contacto) {
        if ($contacto['imagen'] !== null) {
            $imagenesUtilizadas[] = $contacto['imagen'];
        }
    }

    // Obtener la lista de imágenes en la carpeta de uploads
    $imagenesEnCarpeta = scandir('../uploads');

    // Eliminar las imágenes que no se están utilizando
    foreach ($imagenesEnCarpeta as $imagen) {
        if (!in_array($imagen, $imagenesUtilizadas) && $imagen !== '.' && $imagen !== '..') {
            eliminarImagen('../uploads', $imagen);
        }
    }

    echo json_encode(['success' => 'Contacto eliminado con éxito']);
}
?>
