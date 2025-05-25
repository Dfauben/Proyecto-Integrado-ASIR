<?php
require '../funciones.php';
$archivoDatos = '../data/contactos.json';
$contactos = leerContactos($archivoDatos);

// Pagination setup
$contactsPerPage = 5;
$totalContacts = count($contactos);
$totalPages = ceil($totalContacts / $contactsPerPage);
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
if ($page > $totalPages) $page = $totalPages;
$startIndex = ($page - 1) * $contactsPerPage;
$contactsToShow = array_slice($contactos, $startIndex, $contactsPerPage);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Lista de contactos</title>
    <link rel="stylesheet" href="../styles.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <header>
        <h1>Lista de Contactos</h1>
        <nav>
            <a href="#" class="button" id="agregar-contacto">Agregar Contacto</a>
            <a href="#" class="button" id="galeria-imagenes">Galería de Imágenes</a>
        </nav>
    </header>

    <main>
        <div class="contact-grid">
            <?php foreach ($contactsToShow as $contacto): ?>
                <div class="contact-card" data-id="<?= $contacto['id'] ?>">
                    <div class="contact-photo">
                        <?php if (!empty($contacto['imagen'])): ?>
                            <img src="../uploads/<?= htmlspecialchars($contacto['imagen']) ?>" alt="Foto de <?= htmlspecialchars($contacto['nombre']) ?>" />
                        <?php else: ?>
                            <img src="assets/default-avatar.png" alt="Sin imagen" />
                        <?php endif; ?>
                    </div>
                    <div class="contact-info">
                        <h3><?= htmlspecialchars($contacto['nombre']) ?></h3>
                        <p><strong>Teléfono:</strong> <?= htmlspecialchars($contacto['telefono']) ?></p>
                        <p><strong>Email:</strong> <?= htmlspecialchars($contacto['email']) ?></p>
                    </div>
                    <div class="contact-actions">
                        <button class="button button-edit editar-contacto-btn" data-id="<?= $contacto['id'] ?>">Editar</button>
                        <button class="button button-delete eliminar-contacto-btn" data-id="<?= $contacto['id'] ?>">Eliminar</button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="pagination">
            <?php if ($page > 1): ?>
                <a href="?page=<?= $page - 1 ?>" class="button">Anterior</a>
            <?php endif; ?>

            <?php for ($p = 1; $p <= $totalPages; $p++): ?>
                <?php if ($p == $page): ?>
                    <span class="button button-current"><?= $p ?></span>
                <?php else: ?>
                    <a href="?page=<?= $p ?>" class="button"><?= $p ?></a>
                <?php endif; ?>
            <?php endfor; ?>

            <?php if ($page < $totalPages): ?>
                <a href="?page=<?= $page + 1 ?>" class="button">Siguiente</a>
            <?php endif; ?>
        </div>
    </main>

    <!-- Popup modal para seleccionar el contacto y editar -->
    <div id="popup-seleccionar-contacto" class="modal">
        <div class="modal-content">
            <h2>Seleccionar Contacto</h2>
            <form id="formulario-seleccionar-contacto">
                <select id="contacto" name="contacto">
                    <?php foreach ($contactos as $contacto): ?>
                        <option value="<?= $contacto['id'] ?>"><?= $contacto['nombre'] ?></option>
                    <?php endforeach; ?>
                </select>
                <button id="seleccionar-contacto-btn">Seleccionar</button>
                <button class="cerrar">Cerrar</button>
            </form>
        </div>
    </div>

    <div id="popup-modal" class="modal">
        <div class="modal-content">
            <h2>Editar Contacto</h2>
            <form id="formulario-edicion" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" />
                </div>
                <div class="form-group">
                    <label for="telefono">Teléfono:</label>
                    <input type="tel" id="telefono" name="telefono" />
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" />
                </div>
                <div class="form-group">
                    <label for="password">Contraseña:</label>
                    <input type="text" id="password" name="password" />
                </div>
                <div class="form-group">
                    <input type="file" id="imagen-editar" name="imagen" accept="image/*" style="display:none;" />
                    <label for="imagen-editar" class="file-input-label">Seleccionar Archivo</label>
                </div>
                <div class="form-group">
                    <button id="autogenerar-password-btn">Autogenerar Contraseña</button>
                </div>
                <div class="form-group">
                    <button id="guardar-cambios-btn">Guardar Cambios</button>
                </div>
                <div class="form-group">
                    <button class="cerrar">Cerrar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Popup modal para agregar contacto -->
    <div id="popup-agregar" class="modal">
        <div class="modal-content">
            <h2>Agregar Contacto</h2>
            <form id="formulario-agregar">
                <div class="form-group">
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" />
                </div>
                <div class="form-group">
                    <label for="telefono">Teléfono:</label>
                    <input type="tel" id="telefono" name="telefono" />
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" />
                </div>
                <div class="form-group">
                    <label for="password">Contraseña:</label>
                    <input type="text" id="password" name="password" />
                </div>
                <div class="form-group">
                    <button type="button" id="autogenerar-password-btn-agreg">Autogenerar Contraseña</button>
                </div>
                <div class="form-group">
                    <label for="imagen">Imagen:</label>
                    <input type="file" id="imagen" name="imagen" />
                    <img id="preview-imagen" src="" alt="Preview de la imagen" />
                </div>
                <div class="form-group">
                    <button id="agregar-contacto-btn">Agregar</button>
                </div>
                <div class="form-group">
                    <button class="cerrar">Cerrar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Popup para la eliminación -->
    <div id="popup-alert" class="modal">
        <div class="modal-content">
            <h2>Eliminar Contacto</h2>
            <form id="formulario-eliminar">
                <select id="contacto" name="contacto">
                    <?php foreach ($contactos as $contacto): ?>
                        <option value="<?= $contacto['id'] ?>"><?= $contacto['nombre'] ?></option>
                    <?php endforeach; ?>
                </select>
                <button id="confirmar-accion-btn">Confirmar</button>
                <button class="cerrar">Salir</button>
            </form>
        </div>
    </div>

    <!-- Popup galería de imágenes -->
    <div id="popup-galeria" class="modal">
        <div class="modal-content">
            <h2>Galería de Imágenes</h2>
            <div class="gallery-horizontal">
                <?php
                $imagenes = glob('../uploads/*.{jpg,jpeg,png,gif}', GLOB_BRACE);
                foreach ($imagenes as $imagen):
                    $nombreImagen = basename($imagen);
                ?>
                    <div class="gallery-item">
                        <img src="../uploads/<?= htmlspecialchars($nombreImagen) ?>" alt="Imagen <?= htmlspecialchars($nombreImagen) ?>" />
                        <p><?= htmlspecialchars($nombreImagen) ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
            <button class="cerrar">Cerrar</button>
        </div>
    </div>

    <script>
    $(document).ready(function () {
        // Abrir popup modal para seleccionar el contacto y editar
        $('#editar-contacto').click(function () {
            $('#popup-seleccionar-contacto').show();
        });

        // Use event delegation for dynamically generated edit buttons
        $(document).on('click', '.editar-contacto-btn', function () {
            var contactoId = $(this).data('id');
            window.contactoId = contactoId;
            $.ajax({
                type: 'POST',
                url: 'obtener_contacto.php',
                data: { id: contactoId },
                success: function (data) {
                    try {
                        var contacto = JSON.parse(data);
                    } catch (error) {
                        console.log('Error al parsear el JSON:', error);
                        return;
                    }
                    $('#popup-modal input[name="nombre"]').val(contacto.nombre);
                    $('#popup-modal input[name="telefono"]').val(contacto.telefono);
                    $('#popup-modal input[name="email"]').val(contacto.email);
                    $('#popup-modal input[name="password"]').val(contacto.password);
                    $('#popup-seleccionar-contacto').hide();
                    $('#popup-modal').show();
                },
                error: function (xhr, status, error) {
                    console.log('Error en la solicitud AJAX:', error);
                }
            });
        });

        // Use event delegation for dynamically generated delete buttons
        $(document).on('click', '.eliminar-contacto-btn', function () {
            var contactoId = $(this).data('id');
            window.contactoId = contactoId;
            $('#popup-alert').show();
            $('#contacto').val(contactoId);
        });

        $('#seleccionar-contacto-btn').click(function (event) {
            event.preventDefault();
            var contactoId = $('#contacto').val();
            window.contactoId = contactoId;
            $.ajax({
                type: 'POST',
                url: 'obtener_contacto.php',
                data: { id: contactoId },
                success: function (data) {
                    try {
                        var contacto = JSON.parse(data);
                    } catch (error) {
                        console.log('Error al parsear el JSON:', error);
                        return;
                    }
                    $('#popup-modal input[name="nombre"]').val(contacto.nombre);
                    $('#popup-modal input[name="telefono"]').val(contacto.telefono);
                    $('#popup-modal input[name="email"]').val(contacto.email);
                    $('#popup-modal input[name="password"]').val(contacto.password);
                    $('#popup-seleccionar-contacto').hide();
                    $('#popup-modal').show();
                },
                error: function (xhr, status, error) {
                    console.log('Error en la solicitud AJAX:', error);
                }
            });
        });

        $('#popup-seleccionar-contacto .cerrar').click(function () {
            $('#popup-seleccionar-contacto').hide();
        });

        $('#popup-modal form').submit(function (event) {
            event.preventDefault();
            var formData = new FormData(this);
            var contactoId = window.contactoId;
            formData.append('id', contactoId);
            $.ajax({
                type: 'POST',
                url: 'editar_contacto.php',
                data: formData,
                processData: false,
                contentType: false,
                success: function (data) {
                    $('#popup-modal').hide();
                    location.reload();
                }
            });
        });

        $('#eliminar-contacto').click(function () {
            $('#popup-alert').show();
        });

        $('#popup-modal .cerrar').click(function () {
            $('#popup-modal form')[0].reset();
            event.preventDefault();
            $('#popup-modal').hide();
        });

        $('#agregar-contacto').click(function () {
            $('#popup-agregar').show();
        });

        $('#popup-agregar form').submit(function (event) {
            event.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: 'agregar.php',
                data: formData,
                processData: false,
                contentType: false,
                success: function (data) {
                    $('#popup-agregar').hide();
                    location.reload();
                }
            });
        });

        $('#popup-agregar .cerrar').click(function () {
            $('#popup-modal form')[0].reset();
            event.preventDefault();
            $('#popup-agregar').hide();
        });

        $('#autogenerar-password-btn').click(function (event) {
            event.preventDefault();
            event.stopPropagation();
            $.ajax({
                type: 'POST',
                url: 'generar_password_ajax.php',
                success: function (data) {
                    $('#password').val(data);
                }
            });
        });

        $('#confirmar-accion-btn').click(function (event) {
            event.preventDefault();
            var contactoId = $('#contacto').val();
            window.contactoId = contactoId;
            $.ajax({
                type: 'POST',
                url: 'eliminar.php',
                data: { id: contactoId },
                success: function (data) {
                    location.reload();
                }
            });
        });

        $('#popup-alert .cerrar').click(function () {
            event.preventDefault();
            $('#popup-alert').hide();
        });

        $('#autogenerar-password-btn-agreg').click(function (event) {
            event.preventDefault();
            event.stopPropagation();
            $.ajax({
                type: 'POST',
                url: 'generar_password_ajax.php',
                success: function (data) {
                    $('#popup-agregar input[name="password"]').val(data);
                }
            });
        });

        function previewImagen(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    if (e.target.result) {
                        $('#preview-imagen').attr('src', e.target.result);
                        $('#preview-imagen').css('display', 'block');
                    } else {
                        $('#preview-imagen').css('display', 'none');
                    }
                };
                reader.readAsDataURL(input.files[0]);
            } else {
                $('#preview-imagen').css('display', 'none');
            }
        }

        $('#imagen').change(function () {
            previewImagen(this);
        });

        $('#popup-modal .imagen').change(function () {
            previewImagen(this);
        });

        $('#galeria-imagenes').click(function () {
            $('#popup-galeria').show();
        });

        $('#popup-galeria .cerrar').click(function () {
            $('#popup-galeria').hide();
        });
    });
    </script>

    <!-- Modal for image preview -->
    <div id="image-preview-modal" class="modal">
        <span id="close-image-preview" style="cursor: pointer; position: fixed; top: 20px; right: 20px; font-size: 40px; font-weight: bold; color: white; z-index: 1200;">&times;</span>
        <div class="modal-content" style="max-width: 800px; text-align: center; margin: 5% auto; padding: 0; border-radius: 16px; position: relative;">
            <img id="image-preview" src="" alt="Vista previa de la imagen" style="max-height: 700px; width: auto; border-radius: 16px;"/>
        </div>
    </div>

    <script>
    $(document).ready(function () {
        // Existing code...

        // Image preview on clicking profile pictures except default avatar
        $('.contact-photo img').click(function () {
            var src = $(this).attr('src');
            if (!src.includes('default-avatar.png')) {
                $('#image-preview').attr('src', src);
                $('#image-preview-modal').fadeIn();
                $('body, html').addClass('image-preview-open'); // Disable scroll by adding class to body and html
            }
        });

        // Close modal on clicking close button
        $('#close-image-preview').click(function () {
            $('#image-preview-modal').fadeOut(function() {
                $('body, html').removeClass('image-preview-open'); // Enable scroll by removing class after fadeOut completes
            });
        });

        // Close modal on clicking outside the modal content
        $('#image-preview-modal').click(function (e) {
            if (e.target.id === 'image-preview-modal') {
                $('#image-preview-modal').fadeOut(function() {
                    $('body, html').removeClass('image-preview-open'); // Enable scroll by removing class after fadeOut completes
                });
            }
        });
    });
    </script>
</body>
</html>
