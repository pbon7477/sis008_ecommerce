<?php
session_start();
require_once('./config/app.php');
include_once("dompdf/autoload.inc.php");

use Dompdf\Dompdf;
use Dompdf\Options;



if (!isset($_GET['cp']) || $_GET['cp'] == '' || !isset($_GET['id_cli']) || $_GET['id_cli'] == '') {
    exit();
}


//Id cliente solicitante y codigo
$id_cliente_solicitante = $_GET['id_cli'];
$codigo_pedido = $_GET['cp'];

if ($id_cliente_solicitante != $_SESSION['id_cliente']) {
    exit();
}

//echo "<br>Paso las validaciones.<br>";


require_once('./config/SERVER.php');

try {
    $conexion = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conexion->exec('SET CHARACTER SET UTF8');
} catch (Exception $e) {
    die('Error:' . $e->getMessage());
    exit();
}




$sql = "SELECT
        ped.id as pedido_id,
        ped.codigo as pedido_codigo,
        ped.fecha as pedido_fecha,
        ped.estado as pedido_estado,
        cli.nombre as cliente_nombre,
        cli.direccion as cliente_direccion,
        cli.telefono as cliente_telefono,
        cli.email as cliente_email,
        dest.nombre as destinatario_nombre,
        dest.direccion as destinatario_direccion,
        dest.telefono as destinatario_telefono,
        dest.email as destinatario_email

        FROM pedidos AS ped 
        
        INNER JOIN clientes as cli 
        ON ped.id_cliente = cli.id

        INNER JOIN destinatarios as dest
        ON ped.id_destinatario = dest.id 
        
        WHERE ped.codigo= :codigo_pedido AND ped.id_cliente = :id_cliente;";


$cursor = $conexion->prepare($sql);
$cursor->bindParam(':codigo_pedido', $codigo_pedido);
$cursor->bindParam(':id_cliente', $id_cliente_solicitante);
$cursor->execute();
$cliente_y_destinatario = $cursor->fetchAll(PDO::FETCH_ASSOC);


if (empty($cliente_y_destinatario)) {
    exit();
}

$data = $cliente_y_destinatario[0];




$sql2 = "SELECT 
            pr.id as producto_id,
            pr.nombre as producto_nombre,
            pr.precio_venta as producto_precio_venta,
            d_ped.cantidad as d_ped_cantidad,
            d_ped.precio_total as d_ped_precio_total


 FROM pedidos as ped
 INNER JOIN detalle_pedidos as d_ped ON d_ped.id_pedido = ped.id

 INNER JOIN productos as pr
 ON pr.id = d_ped.id_producto    
 
 WHERE ped.codigo = :codigo_pedido;";

$cursor = $conexion->prepare($sql2);
$cursor->bindParam(':codigo_pedido', $_GET['cp']);
$cursor->execute();
$detalle_productos = $cursor->fetchAll(PDO::FETCH_ASSOC);







//falta realizar las consultas y llenar el comprobante




$html = '
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>' . COMPANY . '</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        .logo_tipo{
            display:flex;
            justify-content:center;
            align-items:center;
            background;gree;
        }

        .tabla-principal {

            border-collapse: collapse;
            border: 1px solid #000;
        }

        .tabla-principal th {
            border: 1px solid;
            text-align: start;
            padding: 5px;
            font-size: 14px;
        }

        .tabla-principal td {
            border: 1px solid #000;
            padding: 8px;
            vertical-align: top;
            font-size: 12px;
        }
    </style>
</head>

<body>

<!-- Comprobante del pedido-->
    <div style="margin:10px auto; text-align:center;"><b>Comprobante del Pedido</b></div>
    <table style="width:780px; margin:10px auto; border-collapse:collapse; border: 0px solid #000; ">
        <!-- FILA 1: Logo + Titulo + Fecha y hora de Emisión -->
        <tr>
            <td style="width:35px;" >
             <img src="' . SERVER_URL . 'admin/app/Views/assets/images/logo.png" alt="logo" width="32" >                     
            </td>
            <td style="width:auto;">' . COMPANY . '</td>
            <td colspan="2" align="right" style="font-size:12px; padding:3px;">
                <small>Fecha y Hora de Emisión del comprobante:</small><br>
                <small><b>' . date("d/m/Y H:i:s") . '</b></small>
            </td>
            
        </tr>
    </table>
    
    
    <!-- tabla 2 titulos -->
    <!-- Detalle Cliente-->
    <div style="margin:10px auto; text-align:center;"><b>Detalle de cliente</b></div>
    
    <table class="tabla-principal" style="width:780px; margin:10px auto; border-collapse:collapse; border: 1px solid #000;">

        <thead>
            <tr>
                <th>Cliente</th>
                <th>Destinatario</th>
                <th>Datos del pedido</th>
                </tr>
                </thead>
                
        <tbody>
            <tr>
                <td><b>Nombre: </b>' . $data["cliente_nombre"] . '</td>
                <td><b>Nombre: </b>' . $data["destinatario_nombre"] . '</td>
                <td><b>Codigo: </b>' . $data["pedido_codigo"] . '</td>
            </tr>
            <tr>
                <td><b>Dirección: </b>' . $data["cliente_direccion"] . '</td>
                <td><b>Dirección: </b>' . $data["destinatario_direccion"] . '</td>
                <td><b>Fecha: </b>' . $data["pedido_fecha"] . '</td>
            </tr>
            <tr>
                <td><b>Teléfono: </b>' . $data["cliente_telefono"]  . '</td>
                <td><b>Teléfono: </b>' . $data["destinatario_telefono"] . '</td>
                <td><b>Estado: </b>' . ucwords($data["pedido_estado"]) . '</td>
            </tr>
            <tr>
                <td><b>Email: </b>' . $data["cliente_email"] . '</td>
                <td><b>Email: </b>' . $data["destinatario_email"] . '</td>
                <td></td>
            </tr>

        </tbody>
    </table>

    <!-- Productos-->
    <div style="margin:10px auto; text-align:center;"><b>Detalle de productos</b></div>
    <table class="tabla-principal" style="width: 780px; margin:10px auto;">
        <thead>
            <tr>
                <th>N°</th>
                <th>Nombre</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Total</th>
            </tr>
        </thead>

        <tbody>';


$contador = 0;
$total_final = 0;

foreach ($detalle_productos as $detalle) {
    $contador++;
    $total_final += $detalle["d_ped_precio_total"];
    $html .= "<tr>";
    $html .= "<td>" . $contador . "</td>";
    $html .= "<td>" . ucwords($detalle["producto_nombre"]) . "</td>";
    $html .= "<td>" . $detalle["d_ped_cantidad"] . "</td>";
    $html .= "<td>$" . $detalle["producto_precio_venta"] . "</td>";
    $html .= "<td>$" . $detalle["d_ped_precio_total"] . "</td>";
    $html .= "</tr>";
}


$html .= '</tbody>
        <tfoot>
            <tr>
                
                <td colspan="4" style="text-align:right;"><b>Total:</b></td>
                <td><b>$' . $total_final . '</b></td>


            </tr>
        </tfoot>

    </table>
    <div style="margin:5px auto; text-align:center; font-size:12px;">' . SERVER_URL . '</div>




</body>

</html>';

$options = new Options();
$options->set('defaultFont', 'Arial');
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', true);

$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();

$dompdf->stream('comprobante_pedido_' . $codigo_pedido . '.pdf', array("Attachmnt" => 0));
