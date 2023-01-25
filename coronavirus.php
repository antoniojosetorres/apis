<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coronavirus</title>
</head>
<body>
	<h1>Coronavirus</h1>
	<h2>Usando https://coronavirus.m.pipedream.net</h2>
    <form action="" method="get">
		<label for="pais">Country</label>
        <input type="text" name="pais" id="pais">
        <input type="submit" name="buscar" value="Buscar">
    </form>
    <?php
        function api($u) {
            $c = curl_init($u);
            curl_setopt($c, CURLOPT_HTTPGET, true);
            curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
            $r = curl_exec($c);
            curl_close($c);
            return json_decode($r, true);
        }

        function mostrar($a, $p) {
            $tc = 0;
            $td = 0;
            echo "<table>";
            echo "<tr style='background-color:black;color:white;'><th>Zona</th><th>Confirmadas</th><th>Muertes</th></tr>";
            foreach ($a["rawData"] as $v) {
                $country = $v["Country_Region"];
                if ($country == $p) {
                    $province = $v["Province_State"];
                    if ($province <> "Unknown") {
                        $confirmed = $v["Confirmed"];
                        $deaths = $v["Deaths"];
                        echo "<tr><td>$province</td><td style='text-align:right;'>$confirmed</td><td style='text-align:right;'>$deaths</td></tr>";
                        $tc += $confirmed;
                        $td += $deaths;
                    }
                }
            }
            echo "<tr style='background-color:black;color:white;'><td>$p</td><td style='text-align:right;'>$tc</td><td style='text-align:right;'>$td</td></tr>";
            echo "</table>";
        }

        if (isset($_GET["buscar"])) {
            $pais = $_GET["pais"];
            $url = "https://coronavirus.m.pipedream.net";
            $api = api($url);
            echo mostrar($api, $pais);    
        }
    ?>
</body>
</html>