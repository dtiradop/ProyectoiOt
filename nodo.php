<html>

<head>
    <title>SmartDoor - Perfil</title>
    <link rel="stylesheet" href="estilo.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>

<body>
    <?php
    session_start();
    $us = $_SESSION['usuario'];
    if ($us == "") {
        header("Location: index.php");
    }
    $nodo = $_POST["nodo"];
    $var = $_POST["variable"];
    ?>
    <nav>
        <div class="o-img-nav">
            <img src="SmartDoor.png" alt="SmartDor" class="o-imgv">
        </div>
        <div class="o-icons">
            <span class="material-icons">search</span>
            <br>
            <span class="material-icons">help</span>
        </div>
    </nav>
    <div class="o-container-body">
        <div class="container-perfil">
            <h1 class="o-title o-otro">Hola, Usuario</h1>
            <img src="chico.png" alt="SmartDor" class="o-icon">
            <h4 class="o-title">Recuerde que por su seguridad, solo deje ingresar a conocidos.</h4>
        </div>
        <div class="container-tabla">
            <h2>Datos de la casa: <?php echo $nodo; ?> y el dato: <?php echo $var; ?> </h2>

            <table>
                <tr>
                    <th><?php echo $var; ?></th>
                    <th>Fecha</th>
                </tr>
                <?php
                $url_rest = "https://things.ubidots.com/api/v1.6/devices/$nodo/$var/values?token=BBFF-fCHtb6hNyEve0ZXYI148cCCMhihpuf";
                $curl = curl_init($url_rest);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                $respuesta = curl_exec($curl);
                if ($respuesta === false) {
                    curl_close($curl);
                    die("Error...");
                }
                curl_close($curl);
                //echo $respuesta;
                $resp = json_decode($respuesta);
                $result = $resp->results;
                $tam = count($result);
                for ($i = 0; $i < $tam; $i++) {
                    $j = $result[$i];
                    $valor = $j->value;
                    $time = $j->timestamp;
                    $fecha = date('d-m-Y H:i:s', $time);
                    echo "<tr><td>$valor</td><td>$fecha</td></tr>";
                }
                ?>
            </table><br>
            <a href="seleccion.php">Volver</a><br>
            <a href="logout.php">Cerrar sesión</a><br>
            <button name="enviar" class="o-button buttoningresar">Ingresar invitado</button>
            <?php
            if (isset($_POST['enviar'])) {
                $data = array(
                    "Puerta" => 1,
                    "Usuario" => "Invitado",
                    "Ingreso" => 0,
                );
                
                $data_json = json_encode($data);
                $url = "https://things.ubidots.com/api/v1.6/devices/$nodo/token=BBFF-fCHtb6hNyEve0ZXYI148cCCMhihpuf";
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt(
                    $ch,
                    CURLOPT_HTTPHEADER,
                    array(
                        'Content-Type: application/json',
                        'Content-Length: '.strlen($data_json)
                    )
                );
                $result = curl_exec($ch);
                if ($result == false) {
                    die('Error de comunicacion');
                }
                curl_close($ch);
            }
            ?>
        </div>
    </div>
</body>

</html>