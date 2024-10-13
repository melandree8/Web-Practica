<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportes</title>
    <link rel="stylesheet" href="css/style3.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/c32e4799d5.js" crossorigin="anonymous"></script>
</head>

<body>
    <!-- Menú de navegación -->
    <aside class="sidebar">
        <div class="container">
            <h1>MAOR GRUOP</h1>
        </div>
        <nav>
            <ul>
                <li><a href="#">Dashboard</a></li>
                <li><a href="./DGestion.php">Gestión de Letras/Facturas</a></li>
                <li><a href="#">Rechazos de Productos</a></li>
                <li><a href="./DReportes.php">Reportes</a></li>
                <li><a href="./DEquipo.php">Equipo</a></li>
                <li><a href="#">Asitencia Tecnica</a></li>
                <li><a href="./login.php">Salida</a></li>
            </ul>
        </nav>
    </aside>

    <!-- Contenedor principal -->
    <main class="main-container">
        <!-- Encabezado superior -->
        <header class="header">
            <div class="header-left">
                <h3>Reportes</h3>
            </div>
            <div class="header-right">
                <span>UNIVERSIDAD PERUANA DE CIENCIAS APLICADAS</span>
                <div class="icono">
                    <i class="fa-solid fa-user"></i>
                </div>
            </div>
        </header>

        <div>
            <table class="table table-striped">
                <thead>
                    <tr>
                    <th scope="col">ID</th>
                        <th scope="col">RAZÓN SOCIAL</th>
                        <th scope="col">MONEDA</th>
                        <th scope="col">MONTO</th>
                        <th scope="col">FECHA DESCUENTO</th>
                        <th scope="col">FECHA VENCIMIENTO</th>
                        <th scope="col">TASA NOMINAL O EFECTIVA</th>
                        <th scope="col">TASA P</th>
                        <th scope="col">COMISIÓN</th>
                        <th scope="col">VALOR NOMINAL</th>
                        <th scope="col">VALOR RECIBIDO</th>
                        <th scope="col">TCEA</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include "conexion.php";
                    $sql = $conexion->query(" select * from table_reporte");
                    while ($datos = $sql->fetch_object()) { ?>
                        <tr >
                           <td><?= $datos->Reporte_Id ?></td>
                            <td><?= $datos->Reporte_Razon ?></td>
                            <td><?= $datos->Reporte_Moneda ?></td>
                            <td><?= $datos->Reporte_Monto ?></td>
                            <td><?= $datos->Reporte_Fecha_Descuento ?></td>
                            <td><?= $datos->Reporte_Fecha_Vencimiento ?></td>
                            <td><?= $datos->Reporte_Tasa_Nominal_o_Efectiva ?></td>
                            <td><?= $datos->Reporte_TasaP ?></td>
                            <td><?= $datos->Reporte_Comision ?></td>
                            <td><?= $datos->Reporte_Valor_Nominal ?></td>
                            <td><?= $datos->Reporte_Valor_Recibido ?></td>
                            <td><?= $datos->Reporte_TCEA.'%'?></td>
                      
                        </tr>
                    <?php }
                    ?>
                </tbody>
            </table>
        </div>
        <!-- Contenido principal -->
        <!-- <main class="dashboard-content"> -->

    </main>
    </div>

   

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>