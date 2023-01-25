<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JSON Placeholder</title>
</head>
<body>
	<h1>JSON Placeholder</h1>
	<h2>Usando https://jsonplaceholder.typicode.com</h2>
    <form action="">
		<label for="album">Album (1-99) </label>
        <input type="number" name="album" id="album" min="1" max="99">
        <input type="submit" name="insert" value="Añadir">
		<input type="submit" name="select" value="Ver">
        <input type="submit" name="delete" value="Borrar">
    </form>
    <hr>
    <?php
        // Recuperar datos de API
        function api($u) {
            $c = curl_init($u);
            curl_setopt($c, CURLOPT_HTTPGET, true);
            curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
            $r = curl_exec($c);
            curl_close($c);
            return json_decode($r, true);
        }
        // Conectar a base de datos JSONPlaceholder
        function conectar() {
            $c = new mysqli("localhost", "root", "", "JSONPlaceholder");
            $c->set_charset("utf8");
            return $c;
        }
        // Crear base de datos JSONPlaceholder y tablas Albums y Photos
        function crearbd() {
            $c = new mysqli("localhost", "root", "");
            $c->set_charset("utf8");
            $c->query("CREATE DATABASE IF NOT EXISTS JSONPlaceholder;");
            $c->query("USE JSONPlaceholder;");
            $c->query("CREATE TABLE IF NOT EXISTS albums (
                userId INT NOT NULL,
                id INT NOT NULL PRIMARY KEY,
                titulo VARCHAR(50) NOT NULL
            );");
            $c->query("CREATE TABLE IF NOT EXISTS fotos (
                albumId INT NOT NULL,
                id INT NOT NULL PRIMARY KEY,
                titulo VARCHAR(100) NOT NULL,
                url VARCHAR(50) NOT NULL,
                miniatura VARCHAR(50) NOT NULL,
                FOREIGN KEY (albumId) REFERENCES albums(id)
            );");
            return $c;
        }

        // Insertar album $a
        function insertarAlbum($c, $a) {
            $userId = $a["userId"];
            $id = $a["id"];
            $titulo = $a["title"];
            $sql = "INSERT IGNORE INTO albums (userId, id, titulo) VALUES ($userId, $id, '$titulo');";
            if (!$c->query($sql)) {
                echo $c->error;
            } else {
                return "<p>Album $id - $titulo añadido</p>";
            }
        }
        // Insertar fotos en el album $a
        function insertarFotos($c, $a) {
            $num = "";
            foreach ($a as $v) {
                $albumId = $v["albumId"];
                $id = $v["id"];
                $titulo = $v["title"];
                $url = $v["url"];
                $miniatura = $v["thumbnailUrl"];
                $sql = "INSERT IGNORE INTO fotos VALUES ($albumId, $id, '$titulo', '$url', '$miniatura');";
                if (!$c->query($sql)) {
                    echo $c->error;
                } else {
                    echo "<img src='$miniatura' width='25px'> $id - $titulo<br>";
                }
                $num++;
            }
            return "<p>$num Fotos del album $albumId añadidas</p>";
        }

		// Ver fotos del album $a
		function verFotos($c, $a) {
			echo "<p>Album $a mostrado</p>";
			$sql = "SELECT * FROM fotos WHERE albumId = $a";
			$res = $c->query($sql);
			if ($res->num_rows > 0) {
				while ($fil = $res->fetch_assoc()) {
					$id = $fil["id"];
					$titulo = $fil["titulo"];
					$miniatura = $fil["miniatura"];
					echo "<img src='$miniatura' width='25px'> $id - $titulo<br>";
				}
			} else {
				echo "Album $a no existe";
			}
		}

        // Borrar fotos del album $a
        function borrarFotos($c, $a) {
            $sql = "DELETE FROM fotos WHERE albumId = $a;";
            $c->query($sql);
            return "<p>Fotos del album $a borradas</p>";
        }
        // Borrar album $a
        function borrarAlbum($c, $a) {
            $sql = "DELETE FROM albums WHERE id = $a;";
            $c->query($sql);
            return "<p>Album $a borrado</p>";
        }

        // Insertar fotos en el album $album
        if (isset($_GET["insert"])) {
            $album = $_GET["album"];
            $con = crearbd();

            $url = "https://jsonplaceholder.typicode.com/albums/$album";
            $api = api($url);
            echo insertarAlbum($con, $api);

            $url = "https://jsonplaceholder.typicode.com/albums/$album/photos";
            $api = api($url);
            echo insertarFotos($con, $api);

            $con->close();
        }
		// Ver fotos del album $album
		if (isset($_GET["select"])) {
			$album = $_GET["album"];
			$con = conectar();
			echo verFotos($con, $album);
			$con->close();
		}
        // Borrar registros del album $album
        if (isset($_GET["delete"])) {
            $album = $_GET["album"];
            $con = conectar();
            echo borrarFotos($con, $album);
            echo borrarAlbum($con, $album);
            $con->close();
        }
    ?>
</body>
</html>