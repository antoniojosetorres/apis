<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>El Tiempo</title>
</head>
<body>
    <?php
        function api($u) {
            $c = curl_init($u);
            curl_setopt($c, CURLOPT_HTTPGET, true);
            curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
            $j = curl_exec($c);
            curl_close($c);
            return json_decode($j, true);
        }

        function verMunicipiosMalaga($a) {
            $n = 0;
            echo "<p><strong>Municipios de Málaga</strong></p>";
            foreach ($a as $v) {
                $provincia = $v["NOMBRE_PROVINCIA"];
                $nombre = $v["NOMBRE"];
                if ($provincia == "Málaga") {
                    echo "$nombre<br>";
                    $n++;
                }
            }
            echo "<p>Total: $n</p>";
        }
        function verMunicipiosMalagaMenos20000($a) {
            $n = 0;
            echo "<p><strong>Municipios de Málaga con Menos de 20000 habitantes</strong></p>";
            foreach ($a as $v) {
                $provincia = $v["NOMBRE_PROVINCIA"];
                $poblacion = $v["POBLACION_MUNI"];
                $nombre = $v["NOMBRE"];
                if ($provincia == "Málaga" && $poblacion < 20000) {
                    echo "$nombre - $poblacion<br>";
                    $n++;
                }
            }
            echo "<p>Total: $n</p>";
        }
        function verPoblacionCampillos($a) {
            echo "<p><strong>Población de Campillos</strong></p>";
            foreach ($a as $v) {
                $nombre = $v["NOMBRE"];
                if ($nombre == "Campillos") {
                    $poblacion = $v["POBLACION_MUNI"];
                    echo "<p>$poblacion</p>";
                }
            }
        }
        function verTemperaturaCampillos($a) {
            echo "<p><strong>Temperatura actual de Campillos</strong></p>";
            foreach ($a as $k => $v) {
                if ($k == "temperatura_actual") {
                    $temperatura = $v;
                    echo "<p>$temperatura ºC</p>";
                }
            }
        }
        function verTiempoMalaga($a) {
            echo "<p><strong>Tiempo de mañana en Málaga</strong></p>";
            foreach ($a as $k => $v) {
                if ($k == "tomorrow") {
                    $p = $v["p"];
                    echo "<p>$p</p>";
                }
            }
        }
    ?>
    <form action="" method="get">
        <input type="submit" name="municipiosMalaga" value="Municipios de Málaga">
        <input type="submit" name="municipiosMalagaMenos20000" value="Municipios de Málaga con Menos de 20000 habitantes">
        <input type="submit" name="poblacionCampillos" value="Población de Campillos">
        <input type="submit" name="temperaturaCampillos" value="Temperatura de Campillos">
        <input type="submit" name="tiempoMalaga" value="Tiempo en Málaga">
    </form>
    <hr>
    <?php
        // mostrar los municipios de Málaga y el total
        if (isset($_GET["municipiosMalaga"])) {
            $url = "https://www.el-tiempo.net/api/json/v2/municipios";
            $api = api($url);
            verMunicipiosMalaga($api);
        }
        // mostrar los municipios de Málaga con menos de 20000 habitantes y el total
        if (isset($_GET["municipiosMalagaMenos20000"])) {
            $url = "https://www.el-tiempo.net/api/json/v2/municipios";
            $api = api($url);
            verMunicipiosMalagaMenos20000($api);
        }
        // mostrar la población de Campillos
        if (isset($_GET["poblacionCampillos"])) {
            $url = "https://www.el-tiempo.net/api/json/v2/municipios";
            $api = api($url);
            verPoblacionCampillos($api);
        }
        // mostrar la temperatura actual de Campillos
        if (isset($_GET["temperaturaCampillos"])) {
            $url = "https://www.el-tiempo.net/api/json/v2/provincias/29/municipios/29032";
            $api = api($url);
            verTemperaturaCampillos($api);
        }
        // mostrar el tiempo de mañana en Málaga
        if (isset($_GET["tiempoMalaga"])) {
            $url = "https://www.el-tiempo.net/api/json/v2/provincias/29";
            $api = api($url);
            verTiempoMalaga($api);
        }
    ?>
</body>
</html>