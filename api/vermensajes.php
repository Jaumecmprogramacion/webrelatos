<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit();
}





// Especificar la ruta del archivo XML
$directory = 'C:\xampp\htdocs\Angela\blog4\roadtrip\contactos\\';
$xml_file_name = $directory . 'todos_los_mensajes.xml';

// Función para cargar mensajes desde el archivo XML
function cargarMensajes($xml_file_name) {
    if (file_exists($xml_file_name)) {
        return simplexml_load_file($xml_file_name);
    }
    return false;
}

// Cargar los mensajes
$xml = cargarMensajes($xml_file_name);

// Procesar la solicitud de eliminación AJAX
if (isset($_POST['delete_id'])) {
    $delete_ids = $_POST['delete_id'];

    // Asegurarse de que sea un array
    if (!is_array($delete_ids)) {
        $delete_ids = [$delete_ids]; // Convertir a array si no es uno
    }

    // Crear un nuevo objeto SimpleXMLElement para almacenar los mensajes restantes
    $new_xml = new SimpleXMLElement('<mensajes/>');

    // Recorrer cada mensaje y agregar solo los que no se eliminan
    foreach ($xml->mensaje as $mensaje) {
        if (!in_array((string)$mensaje->id, $delete_ids)) {
            $nuevo_mensaje = $new_xml->addChild('mensaje');
            $nuevo_mensaje->addChild('id', $mensaje->id);
            $nuevo_mensaje->addChild('asunto', $mensaje->asunto);
            $nuevo_mensaje->addChild('nombre', $mensaje->nombre);
            $nuevo_mensaje->addChild('fecha', $mensaje->fecha);
            $nuevo_mensaje->addChild('email', $mensaje->email);
            $nuevo_mensaje->addChild('comentario', $mensaje->comentario);
        }
    }

    // Guardar el nuevo XML actualizado
    if ($new_xml->asXML($xml_file_name)) {
        echo count($delete_ids) > 1 ? "Mensajes eliminados" : "Mensaje eliminado"; // Mensaje adecuado
    } else {
        echo "Error al guardar el archivo XML.";
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mensajes Recibidos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #007BFF;
        }

        .mensaje-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .mensaje-card {
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 15px;
            padding: 15px;
            background-color: #fafafa;
            transition: background-color 0.3s;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .mensaje-card:hover {
            background-color: #f1f1f1;
        }

        .btn-eliminar,
        .btn-eliminar-multiple {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            align-self: flex-start;
            margin-top: 10px;
        }

        .btn-eliminar:hover,
        .btn-eliminar-multiple:hover {
            background-color: #c82333;
        }

        .mensaje-checkbox {
            margin-right: 10px;
        }

        .nombre {
            font-weight: bold;
            margin-bottom: 5px;
        }

        p {
            margin: 5px 0;
            white-space: normal;
            overflow-wrap: break-word;
            overflow: hidden;
        }

        @media (max-width: 600px) {
            .mensaje-card {
                padding: 10px;
            }

            .btn-eliminar, .btn-eliminar-multiple {
                width: 100%;
            }
        }
    </style>
    <script>
        function eliminarMensaje(delete_id) {
            if (confirm("¿Estás seguro de que deseas eliminar este mensaje?")) {
                const formData = new FormData();
                formData.append("delete_id", delete_id);

                fetch("", {
                    method: "POST",
                    body: formData
                })
                .then(response => response.text())
                .then(data => {
                    console.log(data); // Verificar la respuesta del servidor
                    if (data === "Mensajes eliminados" || data === "Mensaje eliminado") {
                        document.getElementById("mensaje-" + delete_id).remove();
                    } else {
                        alert("Error al eliminar el mensaje: " + data);
                    }
                })
                .catch(error => console.error("Error:", error));
            }
        }

        function eliminarMensajesSeleccionados() {
            const selectedIds = [];
            const checkboxes = document.querySelectorAll('.mensaje-checkbox:checked');
            checkboxes.forEach(checkbox => {
                selectedIds.push(checkbox.value);
            });

            if (selectedIds.length === 0) {
                alert("Por favor, selecciona al menos un mensaje para eliminar.");
                return;
            }

            if (confirm("¿Estás seguro de que deseas eliminar los mensajes seleccionados?")) {
                const formData = new FormData();
                selectedIds.forEach(id => {
                    formData.append("delete_id[]", id); // Cambiar para enviar como array
                });

                fetch("", {
                    method: "POST",
                    body: formData
                })
                .then(response => response.text())
                .then(data => {
                    console.log(data); // Verificar la respuesta del servidor
                    if (data.includes("eliminados")) {
                        selectedIds.forEach(id => {
                            document.getElementById("mensaje-" + id).remove();
                        });
                    } else {
                        alert("Error al eliminar los mensajes: " + data);
                    }
                })
                .catch(error => console.error("Error:", error));
            }
        }
    </script>
</head>
<body>
    <h1>Mensajes Recibidos</h1>

    <button class="btn-eliminar-multiple" onclick="eliminarMensajesSeleccionados()">Eliminar Mensajes Seleccionados</button>

    <div class="mensaje-container">
        <?php if ($xml && $xml->mensaje): ?>
            <?php foreach ($xml->mensaje as $mensaje): ?>
                <div class="mensaje-card" id="mensaje-<?php echo htmlspecialchars($mensaje->id); ?>">
                    <input type="checkbox" class="mensaje-checkbox" value="<?php echo htmlspecialchars($mensaje->id); ?>">
                    <h2><strong>Asunto:</strong><?php echo htmlspecialchars($mensaje->asunto); ?></h2>
                    <p class="nombre"><strong>Nombre:</strong> <?php echo htmlspecialchars($mensaje->nombre); ?></p>
                    <p><strong>Fecha:</strong> <?php echo htmlspecialchars($mensaje->fecha); ?></p>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($mensaje->email); ?></p>
                    <p><strong>Comentario:</strong> <?php echo nl2br(htmlspecialchars($mensaje->comentario)); ?></p>
                    <button class="btn-eliminar" onclick="eliminarMensaje('<?php echo htmlspecialchars($mensaje->id); ?>')">Eliminar</button>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No hay mensajes para mostrar.</p>
        <?php endif; ?>
    </div>
</body>
</html>

