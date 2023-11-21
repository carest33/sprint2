<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

require 'BBDD/dbConfig.php';
require 'src/DataBase.php';
require "src/Exceptions/NoDataByIdException.php";

global $dbConfig;

if (!isset($_SESSION['csrf'])) {
    $_SESSION['csrf'] = bin2hex(random_bytes(32));
}

try {
    $db = new DataBase($dbConfig);
} catch (Exception $exception) {
    die("Error de conexión a la base de datos: " . $exception->getMessage());
}

$brand = "";
$model = "";
$color = "";
$plate = "";
$gearShift = "";
$fuel = "";
$km = "";
$provider = "";
$buyPrice = "";
$sellPrice = "";
$iva = "";
$registrationDate = "";
$isNew = "";
$includedTransport = "";
$numChassis = "";
$observedDamages = "";
$description = "";
$image = "";


if (isset($_GET['id'])) {
    $vehicleId = $_GET['id'];
    try {
        $vehicleData = $db->getVehicleById($vehicleId);

        if ($vehicleData) {
            $brand = $vehicleData["marca"];
            $model = $vehicleData["modelo"];
            $color = $vehicleData["color"];
            $plate = $vehicleData["matricula"];
            $gearShift = $vehicleData["tipo_cambio"];
            $fuel = $vehicleData["tipo_carburante"];
            $km = $vehicleData["kilometros"];
            $provider = $vehicleData["proveedor"];
            $buyPrice = $vehicleData["precio_compra"];
            $sellPrice = $vehicleData["precio_venta"];
            $iva = $vehicleData["iva"];
            $registrationDate = $vehicleData["fecha_matriculacion"];
            $isNew = $vehicleData["nuevo"];
            $includedTransport = $vehicleData["transporte_incluido"];
            $numChassis = $vehicleData["num_bastidor"];
            $observedDamages = $vehicleData["danos"];
            $description = $vehicleData["descripcion"];
            $image = $vehicleData["imagen"];
        } else {
            throw new NoDataByIdException("No se ha encontrado ningún proveedor.");
        }

    } catch (NoDataByIdException $error) {
        echo "Error: " . $error->getMessage();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Detalles del vehículo</title>
    <link rel="stylesheet" href="./css/phpform.css">
</head>
<body>
<h2>Detalles del vehículo</h2>
<a href="index.php">
    <button style="margin: 15px; padding: 5px">Volver a la lista</button>
</a>
<form action="vehicle_pdf.php" method="post" target="_blank">
    <button style="margin-left: 15px; padding: 10px" type="submit" name="generarPDF">Generar PDF</button>
    <table>
        <tr>
            <td>Marca</td>
            <td><?= $brand ?></td>
            <input type="hidden" name="brand" value="<?= $brand ?>">
        </tr>
        <tr>
            <td>Modelo</td>
            <td><?= $model ?></td>
            <input type="hidden" name="model" value="<?= $model ?>">
        </tr>
        <tr>
            <td>Color</td>
            <td><?= $color ?></td>
            <input type="hidden" name="color" value="<?= $color ?>">
        </tr>
        <tr>
            <td>Matrícula</td>
            <td><?= $plate ?></td>
            <input type="hidden" name="plate" value="<?= $plate ?>">
        </tr>
        <tr>
            <td>Transmisión</td>
            <td><?= $gearShift ?></td>
            <input type="hidden" name="gearShift" value="<?= $gearShift ?>">
        </tr>
        <tr>
            <td>Carburante</td>
            <td><?= $fuel ?></td>
            <input type="hidden" name="fuel" value="<?= $fuel ?>">
        </tr>
        <tr>
            <td>Kilómetros</td>
            <td><?= $km . ' Km' ?></td>
            <input type="hidden" name="km" value="<?= $km ?>">
        </tr>
        <tr>
            <td>Proveedor</td>
            <td><?= $provider ?></td>
            <input type="hidden" name="provider" value="<?= $provider ?>">
        </tr>
        <tr>
            <td>Precio de Compra</td>
            <td><?= $buyPrice . '€' ?></td>
            <input type="hidden" name="buyPrice" value="<?= $buyPrice ?>">
        </tr>
        <tr>
            <td>Precio de Venta</td>
            <td><?= $sellPrice . '€' ?></td>
            <input type="hidden" name="sellPrice" value="<?= $sellPrice ?>">
        </tr>
        <tr>
            <td>IVA</td>
            <td><?= $iva . '%' ?></td>
            <input type="hidden" name="iva" value="<?= $iva ?>">
        </tr>
        <tr>
            <td>Fecha de Primera Matrícula</td>
            <td><?= $registrationDate ?></td>
            <input type="hidden" name="registrationDate" value="<?= $registrationDate ?>">
        </tr>
        <tr>
            <td>Nuevo:</td>
            <td><?= $isNew ? 'Sí' : 'No' ?></td>
            <input type="hidden" name="isNew" value="<?= $isNew ?>">
        </tr>
        <tr>
            <td>Transporte incluído:</td>
            <td><?= $includedTransport ? 'Sí' : 'No' ?></td>
            <input type="hidden" name="includedTransport" value="<?= $includedTransport ?>">
        </tr>
        <tr>
            <td>Número de bastidor:</td>
            <td><?= $numChassis ?></td>
            <input type="hidden" name="numChassis" value="<?= $numChassis ?>">
        </tr>
        <tr>
            <td>Daños observados</td>
            <td><?= $observedDamages ?></td>
            <input type="hidden" name="observedDamages" value="<?= $observedDamages ?>">
        </tr>
        <tr>
            <td>Descripción comercial</td>
            <td><?= $description ?></td>
            <input type="hidden" name="description" value="<?= $description ?>">
        </tr>
        <tr>
            <td>Imagen</td>
            <td><img src="<?= $image ?>" alt="<?= $image ?>"></td>
            <input type="hidden" name="image" value="<?= $image ?>">
        </tr>
    </table>
</form>
</body>
</html>