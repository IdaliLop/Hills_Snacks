<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../Util/css/registroN.css" rel="stylesheet" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Información de Negocio</title>
</head>
<body>
    <div class="wrapper">
        <form action="">
            <h1>REGISTRO RESTAURANTE</h1>
            <fieldset>
                <legend>Información del Negocio</legend>
            <div class="input-group">
                <div class="input-box">
                    <i class='bx bx-user'></i>
                    <input type="text" placeholder="Nombre del Negocio" required>
                </div>
            </div>
            </fieldset>
            <fieldset>
                <legend>Informacion de Contacto</legend>
                <div class="input-box">
                    <i class='bx bx-map'></i>
                    <input type="text" placeholder="Dirección del Negocio" required> 
                </div>
                <div class="input-box">
                    <i class='bx bx-phone'></i>
                    <input type="tel" pattern="[0-9]{10}" placeholder="Telefono del Negocio" required> 
                </div>
                <!-- <div class="input-box">
                    <i class='bx bx-envelope' ></i>
                    <input type="email" placeholder="Correo del Negocio" required>
                </div> -->
            </fieldset>

            <button type="submit" onclick="continuar()" class="btn">Contunuar</button>
            <a href="../index.php">index</a>
    </div>
</form>

    <script>
        function continuar(){
        window.location.href="index.php";
        }
    </script>

</body>
</html>