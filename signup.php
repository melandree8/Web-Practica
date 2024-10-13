
<?php
include("conexion.php");

if (isset($_POST['register'])) {
    // Validar que todos los campos están llenos
    if (
        strlen($_POST['name']) >= 1 &&
        strlen($_POST['date']) >= 1 &&
        strlen($_POST['email']) >= 1 &&
        strlen($_POST['phone']) >= 1 &&
        strlen($_POST['gender']) >= 1 &&
        strlen($_POST['password']) >= 1
    ) {
        // Sanitizar y validar los datos
        $name = trim($_POST['name']);
        $date = trim($_POST['date']);
        $email = trim($_POST['email']);
        $phone = trim($_POST['phone']);
        $gender = trim($_POST['gender']);
        $password = trim($_POST['password']);
        
        // Preparar la consulta para evitar inyecciones SQL
        $sql = "INSERT INTO table_signup (Nombre, Fecha, Correo, Telefono, Genero, Contraseña) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conex, $sql);
        
        if ($stmt) {
            // Vincular los parámetros y ejecutar la consulta
            mysqli_stmt_bind_param($stmt, "ssssss", $name, $date, $email, $phone, $gender, $password);
            $resultado = mysqli_stmt_execute($stmt);

            if ($resultado) {
                echo '<h3 class="ok">¡Te has inscripto correctamente!</h3>';
            } else {
                echo '<h3 class="bad">¡Ups ha ocurrido un error!</h3>';
            }
            
            // Cerrar la sentencia
            mysqli_stmt_close($stmt);
        } else {
            echo '<h3 class="bad">¡Error en la consulta!</h3>';
        }
    } else {
        echo '<h3 class="bad">¡Por favor complete los campos!</h3>';
    }
}

// Cerrar la conexión a la base de datos
// mysqli_close($conex);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setup Form</title>
    <link rel="stylesheet" href="css/style2.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link
        href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100..900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">
</head>
<body>
    <div class="setup-container">
        <div class="setup-left">
            <h1>MAOR GROUP</h1>
            <h2>Registro</h2>
            <img src="Img/Img-Secundario.png" alt="">
            <!-- <p>It should only take a couple of minutes to pair with your watch</p> -->
        </div>
        <div class="setup-right">
            <!-- Asegúrate de que el action apunte al archivo PHP que procesa el formulario -->
            <form action="registrar.php" method="POST">
                <div class="input-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" placeholder="Name" required>
                </div>
                <div class="input-group gender-group">
                    <label>Gender</label>
                    <label><input type="radio" name="gender" value="male"> Male</label>
                    <label><input type="radio" name="gender" value="female"> Female</label>
                </div>
                <div class="input-group">
                    <label for="dob">Date of birth</label>
                    <input type="date" id="dob" name="date" required>
                </div>
                <div class="input-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="yo@seethat.com" required>
                </div>
                <div class="input-group">
                    <label for="mobile">Mobile</label>
                    <input type="tel" id="mobile" name="phone" placeholder="+51 894838409" required>
                </div>
                <div class="input-group">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password" placeholder="******************" required>
                </div>
                <div class="form-buttons">
                    <button type="button" class="cancel-button"><a href="login.php">Regresar</a></button>
                    <button type="submit" class="save-button" name="register">Save</button>
                </div>
            </form>
        </div>
    </div>

    <?php 
        include("registrar.php");
     ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
