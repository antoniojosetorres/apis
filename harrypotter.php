<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Harry Potter</title>
</head>
<body>
	<h1>Harry Potter API</h1>
	<h2>Usando https://hp-api.onrender.com</h2>
    <form action="" method="get">
		<label>Casa</label>
        <select name="house" id="house">
            <option value="#">--Elige una casa--</em></option>
            <option value="Gryffindor">Gryffindor</option>
            <option value="Hufflepuff">Hufflepuff</option>
            <option value="Ravenclaw">Ravenclaw</option>
            <option value="Slytherin">Slytherin</option>
            <option value="">* Sin casa asignada *</option>
        </select>
        <input type="submit" name="buscar" value="Buscar">
    </form>
    <hr>
    <?php
        if (isset($_GET["buscar"])) {
            $house = $_GET["house"];
            $url = "https://hp-api.onrender.com/api/characters";
            $api = api($url);
            mostrar($api, $house);
        }

        function api($u) {
            $c = curl_init($u);
            curl_setopt($c, CURLOPT_HTTPGET, true);
            curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
            $r = curl_exec($c);
            curl_close($c);
            return json_decode($r, true);
        }

        function mostrar($a, $h) {
            echo "<h1>$h</h1>";
            foreach ($a as $v) {
                $house = $v["house"];
                if ($house == $h) {
                    $name = $v["name"];
                    $actor = $v["actor"];
                    $image = $v["image"];
					if ($image != "") {
						echo "<p>$name ($actor)<br><img src='$image' alt='$name' width='150px'></p>";
					} else {
						echo "<p>$name ($actor)<br><em>No hay imagen</em></p>";
					}
                }
            }
        }
    ?>
</body>
</html>