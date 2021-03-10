<!DOCTYPE html>
<html>

<head>
    <title>SmartDoor - Seleccion</title>
    <link rel="stylesheet" href="estilo.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
</head>

<body>
    <?php
    session_start();
    $us = $_SESSION['usuario'];
    if ($us == "") {
        header("Location: index.php");
    }
    ?>
    <div class="container-login">
        <div class="o-container-img">
            <img src="SmartDoor.png" alt="SmartDor" class="o-img">
        </div>
        <div class="o-form-container">
            <h1 class="o-title o-otro">Tu casa siempre protegida</h1>
            <h2 class="o-title">Seleccione la casa y el dato que desea visualizar: </h2>
            <form action="nodo.php" method="POST">
                Casa: <input type="text" name="nodo" class="o-input"><br>
                Dato: <input type="text" name="variable" class="o-input"><br><br>
                <input type="submit" name="enviar" value="ENVIAR" class="o-button">
            </form>
            <h4 class="o-close"><a href="logout.php">CERRAR SESION</a></h4>
        </div>
    </div>
</body>

</html>