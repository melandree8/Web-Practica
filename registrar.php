<?php

include("conexion.php");

// Verificar si se ha enviado el formulario
if (isset($_POST['register'])) {
    // Comprobar que todos los campos están completos
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
        $stmt = mysqli_prepare($conexion, $sql);

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