<!DOCTYPE HTML>
<html>
<head>
    <title>Archivo de Sueños</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="assets/css/main.css">
</head>
<body>
    <!-- Header -->
    <header id="header">
        <div class="logo"><a href="index.html">Archivo de Sueños</a></div>
        <a href="#menu"><span>Menu</span></a>
    </header>

    <!-- Nav -->
    <nav id="menu">
        <ul class="links">
            <li><a href="index.php">Home</a></li>
            <li><a href="generic.php">Archivo</a></li>
            
            
        </ul>
    </nav>

    <!-- Sueños -->
    <section id="suenos">
        <?php
        // Conexión a la base de datos
        $enlace = new mysqli("localhost", "cielitamartoscrespo", "Gwbmz42_42", "sammasati6791");

        // Verifica si la conexión es exitosa
        if ($enlace->connect_error) {
            die("Conexión fallida: " . $enlace->connect_error);
        }

        // Consulta para obtener todos los sueños
        $stmt = $enlace->prepare("SELECT * FROM sueños");
        $stmt->execute();
        $resultado = $stmt->get_result();

        // Mostrar todos los sueños
        while ($fila = $resultado->fetch_assoc()) {
            // Limitar a 100 caracteres del sueño para la vista inicial
            $sueñoCorto = mb_substr(htmlspecialchars($fila['sueño']), 0, 100) . '...';
            $sueñoCompleto = htmlspecialchars($fila['sueño']); // Guarda el texto completo
            
            
            
            echo '
            <section class="wrapper post">
                <div class="inner">
                    <article class="box">
                        <header>
                            <h2>'.htmlspecialchars($fila['titulo']).'</h2>
                            <p>'.htmlspecialchars($fila['fecha']).'</p>
                        </header>
                        <div class="content">
                            <p>'.$sueñoCompleto.'</p>'; // Muestra todo el sueño

            // Verificar si hay un audio disponible
            if (!empty($audioSrc)) {
                echo '
                            <audio controls>
                                <source src="'.$audioSrc.'" type="audio/mpeg">
                                Tu navegador no soporta el elemento de audio.
                            </audio>';
            }

            echo '
                        </div>
                    </article>
                </div>
            </section>';
        }

        $stmt->close();
        $enlace->close();
        ?>
    </section>

    <!-- Footer -->

    

    <!-- Scripts -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/jquery.scrolly.min.js"></script>
    <script src="assets/js/jquery.scrollex.min.js"></script>
    <script src="assets/js/skel.min.js"></script>
    <script src="assets/js/util.js"></script>
    <script src="assets/js/main.js"></script>
</body>
<footer><div class="copyright">
			Web creada por: <a href="https://jaumecrespo.com/">Jaume CM</a>
		</div></footer>
</html>

