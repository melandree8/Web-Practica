<?php
include("conexion.php");

// Verificar si se ha enviado el formulario
if (isset($_POST["BtnGestion"])) {
    echo "Conexión exitosa.<br>";

    // Comprobar que todos los campos están completos
    if (
        !empty($_POST['Razon']) &&
        !empty($_POST['Moneda']) &&
        !empty($_POST['Monto']) &&
        !empty($_POST['Fecha_Descuento']) &&
        !empty($_POST['Fecha_Vencimiento']) &&
        !empty($_POST['Tipo_Tasa']) &&
        !empty($_POST['TasaP']) && // Añadido para verificar tipo de tasa
        !empty($_POST['Comision']) &&
        !empty($_POST['Valor_Nominal'])
    ) {
        echo "Formulario enviado.<br>";
        echo "Todos los campos están completos.<br>";

        // Sanitizar y validar los datos
        $Razon = trim($_POST['Razon']);
        $Moneda = trim($_POST['Moneda']);
        $Monto = floatval(trim($_POST['Monto']));
        $Fecha_Descuento = trim($_POST['Fecha_Descuento']);
        $Fecha_Vencimiento = trim($_POST['Fecha_Vencimiento']);
        $Tipo_Tasa = trim($_POST['Tipo_Tasa']); // 'nominal' o 'efectiva'
        $TasaP = floatval(trim($_POST['TasaP']));
        $Comision = floatval(trim($_POST['Comision']));
        $Valor_Nominal = floatval(trim($_POST['Valor_Nominal']));

        // Si la tasa es efectiva, convertir a nominal
        if ($Valor_Recibido > 0) {
            // $Tcea = (pow(($Valor_Nominal / $Valor_Recibido), 360 / $plazo_dias) - 1) * 100;
            $TasaP = (pow((1 + ($TasaP / 100)), ($plazo_dias / 360)) - 1) * 100;
           
        } else {
            echo '<h3 class="bad">¡Error en el cálculo del Valor Recibido!</h3>';
            exit;
        }

        // Calcular el plazo en días
        $date1 = new DateTime($Fecha_Descuento);
        $date2 = new DateTime($Fecha_Vencimiento);
        $interval = $date1->diff($date2);
        $plazo_dias = $interval->days;  // Número de días de diferencia

        // Cálculos financieros
        $descuento = $Valor_Nominal * (($TasaP / 100) * ($plazo_dias / 360));
        $Valor_Recibido = $Monto - $Comision - $descuento;

        // Verificar que $Valor_Recibido no sea cero o negativo para evitar errores de división
        if ($Valor_Recibido > 0) {
            $Tcea = (pow(($Valor_Nominal / $Valor_Recibido), 360 / $plazo_dias) - 1) * 100;
        } else {
            echo '<h3 class="bad">¡Error en el cálculo del Valor Recibido!</h3>';
            exit;
        }

        // Preparar la consulta para evitar inyecciones SQL
        $sql = "INSERT INTO table_reporte (Reporte_Razon, Reporte_Moneda, Reporte_Monto, Reporte_Fecha_Descuento, Reporte_Fecha_Vencimiento, Reporte_Tasa_Nominal_o_Efectiva, Reporte_TasaP, Reporte_Plazo, Reporte_Comision, Reporte_Valor_Nominal, Reporte_Valor_Recibido, Reporte_TCEA) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($conexion, $sql);

        if ($stmt) {
            // Vincular los parámetros y ejecutar la consulta
            mysqli_stmt_bind_param(
                $stmt,
                "sssdssddddd",
                $Razon,
                $Moneda,
                $Monto,
                $Fecha_Descuento,
                $Fecha_Vencimiento,
                $Tipo_Tasa,
                $TasaP,
                $Comision,
                $Valor_Nominal,
                $Valor_Recibido,
                $Tcea
            );

            $resultado = mysqli_stmt_execute($stmt);

            if ($resultado) {
                echo '<h3 class="ok">¡Te has registrado correctamente!</h3>';
            } else {
                echo '<h3 class="bad">¡Ups! Ha ocurrido un error en la ejecución!</h3>';
            }

            // Cerrar la sentencia
            mysqli_stmt_close($stmt);
        } else {
            echo '<h3 class="bad">¡Error en la preparación de la consulta SQL!</h3>';
        }
    } else {
        echo '<h3 class="bad">¡Por favor complete todos los campos!</h3>';
    }
}

// Cerrar la conexión a la base de datos
// mysqli_close($conexion);
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion Letras/Factura</title>
    <link rel="stylesheet" href="css/style3.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100..900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">
    <script src="https://kit.fontawesome.com/c32e4799d5.js" crossorigin="anonymous"></script>
</head>

<body>
    <!-- Menú de navegación -->
    <aside class="sidebar">
        <div class="container">
            <h1>MAOR GROUP</h1>
        </div>
        <nav>
            <ul>
                <li><a href="#">Dashboard</a></li>
                <li><a href="./DGestion.php">Gestión de Letras/Facturas</a></li>
                <li><a href="#">Rechazos de Productos</a></li>
                <li><a href="./DReportes.php">Reportes</a></li>
                <li><a href="./DEquipo.php">Equipo</a></li>
                <li><a href="#">Asistencia Técnica</a></li>
                <li><a href="./login.php">Salida</a></li>
            </ul>
        </nav>
    </aside>

    <!-- Contenedor principal -->
    <main class="main-container">
        <!-- Encabezado superior -->
        <header class="header">
            <div class="header-left">
                <h3>Gestión de Letras/Facturas</h3>
            </div>
            <div class="header-right">
                <span>UNIVERSIDAD PERUANA DE CIENCIAS APLICADAS</span>
                <div class="icono">
                    <i class="fa-solid fa-user"></i>
                </div>
            </div>
        </header>

        <!-- Contenido principal -->
        <form class="form" action="registro_gestion.php" method="POST">



            <div class="container">
                <div class="row ms-4 mt-4">
                    <div class="col-4">
                        <label for="name">Razón Social</label>
                        <input type="text" class="form-control" name="Razon" required>
                    </div>
                    <div class="col-4">
                        <label for="inputState">Moneda</label>
                        <select id="inputState" class="form-select" name="Moneda">
                            <option selected>Soles</option>
                            <option>Dólares</option>
                        </select>
                    </div>
                    <div class="col-4">
                        <label for="name">Monto</label>
                        <input type="text" class="form-control" name="Monto" required>
                    </div>


                </div>
                <div class="row ms-4 mt-4">
                    <div class="col-3">
                        <div class="input-group">
                            <label for="dob">Fecha de Descuento</label>
                            <input class="date" type="date" id="dob" name="Fecha_Descuento" required>
                        </div>
                    </div>

                    <div class="col-3">
                        <div class="input-group">
                            <label for="dob">Fecha de Vencimiento</label>
                            <input class="date" type="date" id="dob" name="Fecha_Vencimiento" required>
                        </div>
                    </div>
                    <div class="col-3">
                        <label for="inputState">Tipo de Tasa</label>
                        <select id="inputState" class="form-select" name="Tipo_Tasa">
                            <option selected>Nominal</option>
                            <option>Efectiva</option>
                        </select>
                    </div>
                    <div class="col-3">
                        <label for="name">Tasa (%)</label>
                        <input type="text" class="form-control" name="TasaP" required>
                    </div>

                </div>
                <div class="row ms-4 mt-4">
                    <div class="col-6">
                        <label for="name">Comisión</label>
                        <input type="text" class="form-control" name="Comision" required>
                    </div>
                    <div class="col-6">
                        <label for="name">Valor Nominal</label>
                        <input type="text" class="form-control" name="Valor_Nominal" required>
                    </div>
                </div>
                <div class="row ms-3 mt-4">
                    <div class="col-12 d-flex justify-content-center">
                        <div class="d-grid gap-2">
                            <button class="btn btn-success .custom-width" type="submit" name="BtnGestion"  value="ok">Guardar</button>
                            
                        </div>
                    </div>
                </div>
            </div>


        </form>

    </main>
</body>

<?php
include("registro_gestion.php");
?>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>


</html>