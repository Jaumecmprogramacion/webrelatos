<!DOCTYPE HTML>
<!--
	Road Trip by TEMPLATED
	templated.co @templatedco
	Released for free under the Creative Commons Attribution 3.0 license (templated.co/license)
--><html><head><title>Sueños lucidos por Cielita</title><meta charset="utf-8"><meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1"><meta name="viewport" content="width=device-width, initial-scale=1"><link rel="stylesheet" href="assets/css/main.css"></head><body>

		<!-- Header -->
			<header id="header"><div class="logo"><a href="index.php">Sueños lucidos <span>por Cielita</span></a></div>
				<a href="#menu"><span>Menu</span></a>
			</header><!-- Nav --><nav id="menu"><ul class="links"><li><a href="index.php">Inicio</a></li>
					<li><a href="generic.php">Archivo</a></li>
					
					
				</ul></nav><!-- Banner --><!--
			Note: To show a background image, set the "data-bg" attribute below
			to the full filename of your image. This is used in each section to set
			the background image.
		--><section id="banner" class="bg-img" data-bg="banner.jpg"><div class="inner">
					<header><h1 class="cambia-color">SAMMASATI</h1>
					<p>Sueños y otras cosas</p>
					</header></div>
				<a href="#one" class="more">Learn More</a>
			</section>
			
			<!-- Sueños -->
			<?php
// Configuración de conexión
$enlace = new mysqli("localhost", "cielitamartoscrespo", "Gwbmz42_42", "sammasati6791");

// Verifica si la conexión es exitosa
if ($enlace->connect_error) {
    die("Conexión fallida: " . $enlace->connect_error);
}

// Consulta segura
$stmt = $enlace->prepare("SELECT * FROM sueños");
$stmt->execute();
$resultado = $stmt->get_result();

while ($fila = $resultado->fetch_assoc()) {
    // Limitar a 100 caracteres del sueño para la vista inicial
    $sueñoCorto = mb_substr(htmlspecialchars($fila['sueño']), 0, 100) . '...';
    $sueñoCompleto = htmlspecialchars($fila['sueño']); // Guarda el texto completo
    
    echo '
    <section id="one" class="wrapper post bg-img" data-bg="'.htmlspecialchars($fila['imagen']).'">
        <div class="inner">
            <article class="box">
                <header>
                    <h2>'.htmlspecialchars($fila['titulo']).'</h2>
                    <p>'.htmlspecialchars($fila['fecha']).'</p>
                </header>
                <div class="content">
                    <p class="sueño-corto">'.$sueñoCorto.'</p>
                    <p class="sueño-completo" style="display: none;">'.$sueñoCompleto.'</p>
                </div>
                <footer>
                    <a href="#" class="button alt" onclick="toggleSueño(this); return false;">Leer más</a>
                </footer>
            </article>
        </div>
    </section>';
}


$stmt->close();
$enlace->close();
?>

			


			

			<!-- Fin Sueños -->
			
						
			
			</section><!-- Footer --><footer id="footer"><div class="inner">

					<h2>Contactame</h2>

					<form action="submit.php" method="post">

						<div class="field">
							<label for="subject">Asunto</label>
							<input name="subject" id="name" type="text" placeholder="Asunto"></div>
							<div class="field half first">
							<label for="name">Nombre</label>
							<input name="name" id="name" type="text" placeholder="Nombre"></div>	
						<div class="field half">
							<label for="email">Email</label>
							<input name="email" id="email" type="email" placeholder="Email"></div>
						<div class="field">
							<label for="message">Mensaje</label>
							<textarea name="comment" id="message" rows="6" placeholder="Mensaje"></textarea></div>
						<ul class="actions"><li><input value="Enviar mensaje" class="button alt" type="submit"></li>
						</ul></form>

					<ul class="icons"><li><a href="#" class="icon round fa-twitter"><span class="label">Twitter</span></a></li>
						<li><a href="#" class="icon round fa-facebook"><span class="label">Facebook</span></a></li>
						<li><a href="#" class="icon round fa-instagram"><span class="label">Instagram</span></a></li>
					</ul></div>
			</footer><div class="copyright">
			Web creada por: <a href="https://jaumecrespo.com/">Jaume CM</a>
		</div>
		<script>
    function toggleSueño(button) {
        // Encuentra el contenedor del artículo
        var article = button.closest('.box');
        var corto = article.querySelector('.sueño-corto');
        var completo = article.querySelector('.sueño-completo');
        
        // Alternar la visibilidad del texto corto y completo
        if (completo.style.display === "none") {
            completo.style.display = "block"; // Mostrar texto completo
            corto.style.display = "none"; // Ocultar texto corto
            button.innerText = "Leer menos"; // Cambiar el texto del botón
        } else {
            completo.style.display = "none"; // Ocultar texto completo
            corto.style.display = "block"; // Mostrar texto corto
            button.innerText = "Leer más"; // Cambiar el texto del botón
        }
    }
</script>

		<!-- Scripts -->
		<script>
    const colores = ["#FF5733", "#33FF57", "#3357FF", "#F1C40F", "#8E44AD", "#E74C3C"]; // Colores que deseas usar
    let indiceColor = 0;
    const elemento = document.querySelector('.cambia-color'); // Selecciona el elemento

    function cambiarColor() {
        elemento.style.color = colores[indiceColor]; // Cambia el color
        indiceColor = (indiceColor + 1) % colores.length; // Aumenta el índice y reinicia si es necesario
    }

    setInterval(cambiarColor, 1000); // Cambia el color cada segundo (1000 ms)
</script>

			<script src="assets/js/jquery.min.js"></script><script src="assets/js/jquery.scrolly.min.js"></script><script src="assets/js/jquery.scrollex.min.js"></script><script src="assets/js/skel.min.js"></script><script src="assets/js/util.js"></script><script src="assets/js/main.js"></script></body></html>
