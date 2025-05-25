<?php

/**
 * Lee los contactos almacenados en un archivo JSON.
 * @param string $archivo Ruta del archivo JSON.
 * @return array Lista de contactos como un array asociativo.
 */
function leerContactos($archivo) {
    if (!file_exists($archivo)) {
        return []; // Devuelve un array vacío si el archivo no existe.
    }
    $datos = file_get_contents($archivo);
    $contactos = json_decode($datos, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        // Manejo de error en decodificación JSON
        error_log('Error al decodificar JSON: ' . json_last_error_msg());
        return [];
    }
    return $contactos ?? [];
}

/**
 * Guarda los contactos en un archivo JSON.
 * @param string $archivo Ruta del archivo JSON.
 * @param array $contactos Lista de contactos a guardar.
 * @return bool True si se guardó correctamente, false en caso contrario.
 */
function guardarContactos($archivo, $contactos) {
    $json = json_encode($contactos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    if ($json === false) {
        error_log('Error al codificar JSON: ' . json_last_error_msg());
        return false;
    }
    $result = file_put_contents($archivo, $json);
    return $result !== false;
}

/**
 * Genera una contraseña aleatoria segura.
 * @param int $longitud Longitud de la contraseña (por defecto 12).
 * @return string Contraseña generada.
 */
function generarPassword($longitud = 12) {
    $caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()-_=+[]{}<>?';
    $password = '';
    $maxIndex = strlen($caracteres) - 1;
    for ($i = 0; $i < $longitud; $i++) {
        $password .= $caracteres[random_int(0, $maxIndex)];
    }
    return $password;
}

/**
 * Genera una contraseña y la imprime (para uso AJAX).
 */
function generarPasswordAjax() {
    $password = generarPassword();
    echo $password;
}

/**
 * Sube un archivo de imagen al servidor y devuelve su nombre único.
 * @param array $archivo Datos del archivo subido ($_FILES).
 * @param string $directorio Carpeta donde se guardará la imagen.
 * @return string|null Nombre del archivo subido o null si falla.
 */
function subirImagen($archivo, $directorio) {
    if ($archivo['error'] !== UPLOAD_ERR_OK) {
        error_log('Error en la subida del archivo: ' . $archivo['error']);
        return null; // Devuelve null si hay errores en la subida.
    }

    // Verifica si el archivo es una imagen válida.
    $tipoPermitido = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($archivo['type'], $tipoPermitido)) {
        error_log('Tipo de archivo no permitido: ' . $archivo['type']);
        return null;
    }

    // Genera un nombre único para la imagen.
    $nombreArchivo = uniqid('', true) . "_" . basename($archivo["name"]);
    $rutaDestino = rtrim($directorio, '/') . "/" . $nombreArchivo;

    // Mueve el archivo al directorio de destino.
    if (move_uploaded_file($archivo["tmp_name"], $rutaDestino)) {
        return $nombreArchivo;
    }
    error_log('Error al mover el archivo subido.');
    return null;
}

/**
 * Elimina una imagen del servidor.
 * @param string $directorio Carpeta donde está almacenada la imagen.
 * @param string $nombreArchivo Nombre del archivo a eliminar.
 */
function eliminarImagen($directorio, $nombreArchivo) {
    $rutaArchivo = rtrim($directorio, '/') . "/" . $nombreArchivo;
    if (file_exists($rutaArchivo)) {
        unlink($rutaArchivo); // Elimina el archivo si existe.
    }
}

/**
 * Busca un contacto por su ID.
 * @param array $contactos Lista de contactos.
 * @param string $id Identificador del contacto.
 * @return array|null Contacto encontrado o null si no existe.
 */
function buscarContactoPorID($contactos, $id) {
    foreach ($contactos as $contacto) {
        if ($contacto['id'] == $id) {
            return $contacto;
        }
    }
    return null; // Devuelve null si no encuentra el contacto.
}

/**
 * Actualiza un contacto existente en la lista.
 * @param array $contactos Lista de contactos.
 * @param string $id Identificador del contacto a actualizar.
 * @param array $nuevosDatos Nuevos datos del contacto.
 * @return array Lista de contactos actualizada.
 */
function actualizarContacto($contactos, $id, $nuevosDatos) {
    foreach ($contactos as $index => $contacto) {
        if ($contacto['id'] === $id) {
            $contactos[$index] = array_merge($contacto, $nuevosDatos);
            break;
        }
    }
    return $contactos;
}

/**
 * Elimina un contacto por su ID.
 * @param array $contactos Lista de contactos.
 * @param string $id Identificador del contacto a eliminar.
 * @return array Lista de contactos actualizada.
 */
function eliminarContacto($contactos, $id) {
    foreach ($contactos as $index => $contacto) {
        if ($contacto['id'] === $id) {
            array_splice($contactos, $index, 1);
            break;
        }
    }
    return $contactos;
}

/**
 * Genera una ID única para cada contacto agregado.
 * @param array $contactos Lista de contactos.
 * @return int Nueva ID.
 */
function generarId($contactos) {
    $ultimoId = 0;
    foreach ($contactos as $contacto) {
        if ($contacto['id'] > $ultimoId) {
            $ultimoId = $contacto['id'];
        }
    }
    return $ultimoId + 1;
}
?>
