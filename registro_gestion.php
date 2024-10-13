<?php
include("conexion.php");

// Verificar si se ha enviado el formulario
if (isset($_POST["BtnGestion"])) {
    // Comprobar que todos los campos están completos
    if (
        !empty($_POST['Razon']) &&
        !empty($_POST['Moneda']) &&
        !empty($_POST['Monto']) &&
        !empty($_POST['Fecha_Descuento']) &&
        !empty($_POST['Fecha_Vencimiento']) &&
        !empty($_POST['Tipo_Tasa']) &&
        !empty($_POST['TasaP']) &&
        !empty($_POST['Comision']) &&
        !empty($_POST['Valor_Nominal'])
    ) {
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
        if ($Tipo_Tasa === 'efectiva') {
            // $TasaP = ($TasaP * 360) / (360 + ($TasaP * 360));
            $TasaP=(pow((1+($TasaP/(360/$plazo_dias))),(360/$plazo_dias))-1)*100;
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
            // $TasaP = (pow((1 + ($TasaP / 100)), ($plazo_dias / 360)) - 1) * 100;
           
        } else {
            echo '<h3 class="bad">¡Error en el cálculo del Valor Recibido!</h3>';
            exit;
        }

        $Tcea =(round($Tcea,3));
        $Valor_Recibido =round($Valor_Recibido,3);


        // Preparar la consulta para evitar inyecciones SQL
        $sql = "INSERT INTO table_reporte (Reporte_Razon, Reporte_Moneda, Reporte_Monto, Reporte_Fecha_Descuento, Reporte_Fecha_Vencimiento, Reporte_Tasa_Nominal_o_Efectiva, Reporte_TasaP, Reporte_Comision, Reporte_Valor_Nominal, Reporte_Valor_Recibido, Reporte_TCEA) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = mysqli_prepare($conexion, $sql);
        
        if ($stmt) {
            // Vincular los parámetros y ejecutar la consulta
            mysqli_stmt_bind_param($stmt, "ssdssssdddd", 
                $Razon, $Moneda, 
                $Monto, $Fecha_Descuento, $Fecha_Vencimiento, 
                $Tipo_Tasa, $TasaP, $Comision, 
                $Valor_Nominal, $Valor_Recibido, $Tcea);
                
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
