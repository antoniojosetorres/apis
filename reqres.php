<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reqres</title>
</head>
<body>
	<h1>Reqres</h1>
	<h2>Usando https://reqres.in</h2>
    <form action="">
        <input type="number" name="idapi" id="idapi" min="0" max="99">
        <input type="submit" name="users" value="users">
    </form>
    <?php
        if (isset($_GET["users"])) {
            $ficha="https://reqres.in/api/".$_GET['users']."/".$_GET['idapi'];

            $ch = curl_init($ficha);
            curl_setopt($ch, CURLOPT_HTTPGET, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response_json = curl_exec($ch);
            curl_close($ch);

            $res=json_decode($response_json, true);
            if ($res != NULL) {
                $d = $res["data"];
                foreach ($d as $k => $v) {
                    if ($k == "avatar") {
                        echo "<img src='$v'>";
                    } else {
                        echo "$v<br>";
                    }
                }
            }
        }
    ?>
</body>
</html>