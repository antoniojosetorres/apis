<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ghibli</title>
</head>
<body>
	<h1>Ghibli API</h1>
	<h2>Usando https://studio-ghibli-films-api.herokuapp.com/api</h2>
    <form action="" method="get">
		<label for="titulo">Título</label>
        <input type="text" name="titulo" id="titulo">
        <input type="submit" name="buscar" value="Buscar">
    </form>
    <hr>
    <?php
        if (isset($_GET["buscar"])) {
            $titulo = $_GET["titulo"];
			$url = "https://studio-ghibli-films-api.herokuapp.com/api";
            $api = api($url);
            buscarTitulo($api, $titulo);
        }
        
        // Recupera datos de la API
        function api($u) {
            $c = curl_init($u);
            curl_setopt($c, CURLOPT_HTTPGET, true);
            curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
            $r = curl_exec($c);
            curl_close($c);
            return json_decode($r, true);
        }
        // Muestra todas las peliculas
        function mostrar($a) {
            foreach ($a as $v) {
                $title = $v["title"];
                $poster = $v["poster"];
                echo "<h1>$title</h1>";
                echo "<img src='$poster' alt='$title'><br>";
            }
        }
        // Muestra las peliculas que contengan $t en el titulo
        function buscarTitulo($a, $t) {
            $n = 0;
            foreach ($a as $v) {
                $title = $v["title"];
                $poster = $v["poster"];
                if (($t == "") || ($t <> "" && strlen(stristr($title, $t)))) {
                    $n++;
                    echo "<strong>$n - $title</strong><br>";
                    echo "<img src='$poster' alt='$title' width='220px'><br>";
                }
            }
        }
    ?>
</body>
</html>