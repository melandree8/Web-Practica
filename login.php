<?php
require 'conexion.php'; // Asegúrate de que este archivo se está incluyendo correctamente y que tiene la conexión a la base de datos.

// Verificar si el formulario ha sido enviado
if (isset($_POST['login'])) {
    $correo = $_POST['email'];
    $contraseña = $_POST['password'];

    // Para evitar inyecciones SQL, es mejor utilizar sentencias preparadas (prepared statements).
    $sql = "SELECT * FROM table_signup WHERE Correo = ? AND Contraseña = ?";
    $stmt = mysqli_prepare($conexion, $sql); // Asegúrate de que el nombre de la variable de conexión sea correcto

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ss", $correo, $contraseña);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($resultado) > 0) { // Verificar si hay resultados
            header('Location: /Web-Practica/DGestion.php');
        } else {
        }

        mysqli_stmt_close($stmt); // Cerrar la sentencia después de ejecutarla
    } else {
        echo "Error en la consulta: " . mysqli_error($conex); // Asegúrate de que el nombre de la variable de conexión sea correcto
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="login-container">
        <div class="login-box">
            <h2>Hola!</h2>
            <p>Inicia sesión en tu cuenta</p>
            <form action="DGestion.php" method="POST">
                <!-- Añadido 'method="POST"' y 'action=""' para enviar el formulario a sí mismo -->
                <div class="input-group">
                    <input type="email" name="email" placeholder="E-mail" required> <!-- Añadido 'name="email"' -->
                </div>
                <div class="input-group">
                    <input type="password" name="password" placeholder="Password" required>
                    <!-- Añadido 'name="password"' -->
                    <span class="show-password">👁️</span>
                </div>
                <div class="options">
                    <label><input type="checkbox"> Recordar</label>
                    <a href="#">Olvidaste tu Contraseña?</a>
                </div>
                <button type="submit" class="signin-button" name="login">INGRESAR</button>
                <p class="create-account">No tienes una Cuenta? <a href="signup.php">Crear</a></p>
            </form>
        </div>
        <div class="welcome-back">
            <h2>MAOR GROUP</h2>
            <!-- <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et
                dolore magna aliquaa.</p> -->
            <img src="img/Img-Principal.png" alt="">    
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>