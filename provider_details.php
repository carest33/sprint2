<?php
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

$name = "";
$completeAddress = "";
$phone = "";
$email = "";
$CIF = "";
$managerNIF = "";

if (isset($_GET['id'])) {
    $providerId = $_GET['id'];

    try {
        $providerData = $db->getProviderById($providerId);

        if ($providerData) {
            $name = $providerData['nombre'];
            $completeAddress = $providerData['domicilio_completo'];
            $phone = $providerData['telefono'];
            $email = $providerData['correo_electronico'];
            $CIF = $providerData['CIF'];
            $managerNIF = $providerData['NIF_Gerente'];
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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles de Proveedor</title>
    <link rel="stylesheet" href="./css/phpform.css">
</head>
<body>
<h1>Detalles de Proveedor</h1>
<a href="index.php">
    <button style="margin: 15px; padding: 5px">Volver a la lista</button>
</a>
<form action="provider_pdf.php" method="post" target="_blank">
    <button style="margin-left: 15px; padding: 10px" type="submit" name="generarPDF">Generar PDF</button>
    <table>
        <tr>
            <td>Nombre</td>
            <td><?= $name ?></td>
            <input type="hidden" name="name" value="<?= $name ?>">
        </tr>
        <tr>
            <td>Domicilio</td>
            <td><?= $completeAddress ?></td>
            <input type="hidden" name="completeAddress" value="<?= $completeAddress ?>">
        </tr>
        <tr>
            <td>Teléfono</td>
            <td><?= $phone ?></td>
            <input type="hidden" name="phone" value="<?= $phone ?>">
        </tr>
        <tr>
            <td>Email</td>
            <td><?= $email ?></td>
            <input type="hidden" name="email" value="<?= $email ?>">
        </tr>
        <tr>
            <td>CIF</td>
            <td><?= $CIF ?></td>
            <input type="hidden" name="CIF" value="<?= $CIF ?>">
        </tr>
        <tr>
            <td>NIF del Gerente</td>
            <td><?= $managerNIF ?></td>
            <input type="hidden" name="managerNIF" value="<?= $managerNIF ?>">
        </tr>
    </table>
</form>
</body>
</html>