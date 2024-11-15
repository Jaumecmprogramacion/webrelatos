<?php
// Validar y limpiar los datos del formulario
$name = isset($_POST['name']) ? htmlspecialchars(trim($_POST['name'])) : 'Nombre no proporcionado';
$email = isset($_POST['email']) ? filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL) : 'Email no válido';
$subject = isset($_POST['subject']) ? htmlspecialchars(trim($_POST['subject'])) : 'Asunto no proporcionado';
$comment = isset($_POST['comment']) ? htmlspecialchars(trim($_POST['comment'])) : 'Mensaje no proporcionado';

// Especificar la ruta donde se guardarán los archivos TXT y XML
$directory = 'C:\xampp\htdocs\Angela\blog4\roadtrip\contactos\\'; // Asegúrate de que esta carpeta existe

// Verificar si la carpeta existe, si no, intentar crearla
if (!is_dir($directory)) {
    mkdir($directory, 0777, true); // Intentar crear la carpeta si no existe
}

// ------------------- Guardar en el archivo XML acumulativo -------------------

// Ruta del archivo XML
$xml_file_name = $directory . 'todos_los_mensajes.xml';

// Verificar si el archivo XML ya existe
if (file_exists($xml_file_name)) {
    // Si existe, cargar el XML existente
    $xml = simplexml_load_file($xml_file_name);
} else {
    // Si no existe, crear un nuevo XML
    $xml = new SimpleXMLElement('<mensajes></mensajes>');
}

// Obtener el último ID
$ultimoId = 0;
foreach ($xml->mensaje as $mensaje) {
    $id = (int)$mensaje->id;
    if ($id > $ultimoId) {
        $ultimoId = $id; // Encuentra el ID más alto existente
    }
}
$nuevoId = $ultimoId + 1; // Incrementa el ID

// Agregar los nuevos datos al XML
$mensaje = $xml->addChild('mensaje');
$mensaje->addChild('id', $nuevoId);
$mensaje->addChild('fecha', date('Y-m-d H:i:s'));
$mensaje->addChild('nombre', $name);
$mensaje->addChild('email', $email);
$mensaje->addChild('asunto', $subject);
$mensaje->addChild('comentario', $comment);

// Guardar el XML actualizado en el archivo
if ($xml->asXML($xml_file_name)) {
    echo "<p>El mensaje se ha enviado de forma correcta.</p>";
} else {
    echo "<p>Error al guardar el archivo XML</p>";
}
?>

<!-- Redirigir a la página de inicio después de 5 segundos -->
<meta http-equiv='Refresh' content="1; url='index.php'" />



