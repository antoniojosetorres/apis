<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SWAPI</title>
</head>
<body>
    <?php
        // Recuperar datos de la API
        function api($u) {
            $c = curl_init($u);
            curl_setopt($c, CURLOPT_HTTPGET, true);
            curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
            $r = curl_exec($c);
            curl_close($c);
            return json_decode($r, true);
        }
    ?>
    <h1>Star Wars API</h1>
	<h2>Usando https://www.swapi.tech</h2>
    <form action="" method="post">
		<label for="idapi">Número de orden de la película</label>
        <input type="number" name="idapi" id="idapi" min="1" max="6">
        <input type="submit" name="films" value="Film">
    </form>
    <hr>
    <?php
        if (isset($_POST["films"])) {
            $url="https://www.swapi.tech/api/films/".$_POST['idapi'];

            $res = api($url);
            // $res contiene el resultado de la llamada a la API
            if ($res != NULL) {
                // Obtencion de los campos de salida
                $title = strtoupper($res["result"]["properties"]["title"]);
                $date = substr($res["result"]["properties"]["release_date"], 0, 4);
                $director = $res["result"]["properties"]["director"];
                $episode_id = $res["result"]["properties"]["episode_id"];
                $characters = $res["result"]["properties"]["characters"];
                $producer = $res["result"]["properties"]["producer"];

                // Escribir la salida en pantalla
                echo "<strong>$episode_id - $title ($date)</strong><br>";
                echo "Director: $director<br>";
                echo "Personajes:<br>";
                echo "<ul>";
                // Listo los personajes de la pelicula
                foreach ($characters as $v) {
                    // Llamada a la API para cada personaje
                    $char = api($v);
                    $name = $char["result"]["properties"]["name"];
                    if ($char != NULL) {
                        echo "<li>$name</li>";
                    }
                }
                echo "</ul>";
                echo "Productor(es): $producer";
            }
        }
    ?>
</body>
</html>