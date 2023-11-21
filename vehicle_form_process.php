<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

require 'src/Exceptions/CreateDirectoryException.php';
require 'src/Exceptions/MoveUploadedFileException.php';
require 'src/Exceptions/TokenCSRFException.php';
require 'src/Exceptions/FileSizeException.php';

require 'src/Vehicle.php';
require 'src/Image.php';
require 'src/lib/ValidateVehicle.php';
require 'BBDD/dbConfig.php';
require 'src/DataBase.php';

global $dbConfig;

try {
    $db = new DataBase($dbConfig);
} catch (Exception $exception) {
    die("Error de conexión a la base de datos: " . $exception->getMessage());
}

try {

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (!isset($_POST['csrf']) || $_POST['csrf'] !== $_SESSION['csrf']) {
            throw new TokenCSRFException("Token CSRF no válido. La solicitud ha sido rechazada.");
        }

        $validador = new ValidateVehicle();
        $errores = $validador->validate($_POST, $_FILES);

        if (empty($errores)) {
            $vehicle = new Vehicle();
            $vehicle->setBrand($_POST["brand"]);
            $vehicle->setModel($_POST["model"]);
            $vehicle->setColor($_POST["color"]);
            $vehicle->setPlate($_POST["plate"]);
            $vehicle->setGearShift($_POST["gearShift"]);
            $vehicle->setFuel($_POST["fuel"]);
            $vehicle->setKm((int)$_POST["km"]);
            $vehicle->setProvider($_POST["provider"]);
            $vehicle->setBuyPrice((int)$_POST["buyPrice"]);
            $vehicle->setSellPrice((int)$_POST["sellPrice"]);
            $vehicle->setIva((int)$_POST["iva"]);
            $vehicle->setRegistrationDate(new DateTime($_POST["registrationDate"]));
            $vehicle->setIsNew((bool)$_POST["isNew"]);
            $vehicle->setIncludedTransport((bool)$_POST["includedTransport"]);
            $vehicle->setNumChassis($_POST["numChassis"]);
            $vehicle->setObservedDamages($_POST["observedDamages"]);
            $vehicle->setDescription($_POST["description"]);

            $imagen = $_FILES["image"];
            $imagenObj = new Image();
            $imagenObj->setName($imagen["name"]);
            $vehicle->setImage($imagenObj);
            $targetDir = "uploads/";

            if (!file_exists($targetDir) || !is_dir($targetDir) || !is_writable($targetDir)) {
                if (!mkdir($targetDir, 0777, true)) {
                    throw new CreateDirectoryException("El directorio de destino no es válido o no se puede escribir en él.");
                }
            }
            $targetFile = $targetDir . basename($imagen["name"]);

            if ($_FILES["image"]["error"] == UPLOAD_ERR_INI_SIZE) {
                throw new FileSizeException("El tamaño del archivo excede el límite permitido (2MB).");
            }

            if (move_uploaded_file($imagen["tmp_name"], $targetFile)) {

                if ($_POST['action'] === 'add') {
                    if ($db->insertVehicle($vehicle)) {
                        echo "Datos del vehículo insertados correctamente en la base de datos.";
                    } else {
                        echo "Error al insertar los datos del vehículo.";
                    }
                } elseif ($_POST['action'] === 'edit') {
                    $vehicleId = $_POST['vehicleId'];
                    if ($db->updateVehicle($vehicleId, $vehicle)) {
                        echo "Datos del vehículo actualizados correctamente en la base de datos.";
                    } else {
                        echo "Error al actualizar los datos del vehículo.";
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
                    <table>
                        <tr>
                            <td>Marca</td>
                            <td><?= $vehicle->getBrand() ?></td>
                            <input type="hidden" name="brand" value="<?= $vehicle->getBrand() ?>">
                        </tr>
                        <tr>
                            <td>Modelo</td>
                            <td><?= $vehicle->getModel() ?></td>
                            <input type="hidden" name="model" value="<?= $vehicle->getModel() ?>">
                        </tr>
                        <tr>
                            <td>Color</td>
                            <td><?= $vehicle->getColor() ?></td>
                            <input type="hidden" name="color" value="<?= $vehicle->getColor() ?>">
                        </tr>
                        <tr>
                            <td>Matrícula</td>
                            <td><?= $vehicle->getPlate() ?></td>
                            <input type="hidden" name="plate" value="<?= $vehicle->getPlate() ?>">
                        </tr>
                        <tr>
                            <td>Transmisión</td>
                            <td><?= $vehicle->getGearShift() ?></td>
                            <input type="hidden" name="gearShift" value="<?= $vehicle->getGearShift() ?>">
                        </tr>
                        <tr>
                            <td>Carburante</td>
                            <td><?= $vehicle->getFuel() ?></td>
                            <input type="hidden" name="fuel" value="<?= $vehicle->getFuel() ?>">
                        </tr>
                        <tr>
                            <td>Kilómetros</td>
                            <td><?= $vehicle->getKm() . ' Km' ?></td>
                            <input type="hidden" name="km" value="<?= $vehicle->getKm() ?>">
                        </tr>
                        <tr>
                            <td>Proveedor</td>
                            <td><?= $vehicle->getProvider() ?></td>
                            <input type="hidden" name="provider" value="<?= $vehicle->getProvider() ?>">
                        </tr>
                        <tr>
                            <td>Precio de Compra</td>
                            <td><?= $vehicle->getBuyPrice() . '€' ?></td>
                            <input type="hidden" name="buyPrice" value="<?= $vehicle->getBuyPrice() ?>">
                        </tr>
                        <tr>
                            <td>Precio de Venta</td>
                            <td><?= $vehicle->getSellPrice() . '€' ?></td>
                            <input type="hidden" name="sellPrice" value="<?= $vehicle->getSellPrice() ?>">
                        </tr>
                        <tr>
                            <td>IVA</td>
                            <td><?= $vehicle->getIva() . '%' ?></td>
                            <input type="hidden" name="iva" value="<?= $vehicle->getIva() ?>">
                        </tr>
                        <tr>
                            <td>Fecha de Primera Matrícula</td>
                            <td><?= $vehicle->getRegistrationDate()->format('d-m-Y') ?></td>
                            <input type="hidden" name="registrationDate"
                                   value="<?= $vehicle->getRegistrationDate()->format('d-m-Y') ?>">
                        </tr>
                        <tr>
                            <td>Nuevo:</td>
                            <td><?= $vehicle->isNew() ? 'Sí' : 'No' ?></td>
                            <input type="hidden" name="isNew" value="<?= $vehicle->isNew() ?>">
                        </tr>
                        <tr>
                            <td>Transporte incluído:</td>
                            <td><?= $vehicle->isIncludedTransport() ? 'Sí' : 'No' ?></td>
                            <input type="hidden" name="includedTransport"
                                   value="<?= $vehicle->isIncludedTransport() ?>">
                        </tr>
                        <tr>
                            <td>Número de bastidor:</td>
                            <td><?= $vehicle->getNumChassis() ?></td>
                            <input type="hidden" name="numChassis" value="<?= $vehicle->getNumChassis() ?>">
                        </tr>
                        <tr>
                            <td>Daños observados</td>
                            <td><?= $vehicle->getObservedDamages() ?></td>
                            <input type="hidden" name="observedDamages" value="<?= $vehicle->getObservedDamages() ?>">
                        </tr>
                        <tr>
                            <td>Descripción comercial</td>
                            <td><?= $vehicle->getDescription() ?></td>
                            <input type="hidden" name="description" value="<?= $vehicle->getDescription() ?>">
                        </tr>
                        <tr>
                            <td>Imagen</td>
                            <td><img src="<?= /*$vehicle->getImage()->getName()*/
                                $targetFile ?>" alt="<?= $targetFile ?>"></td>
                            <input type="hidden" name="image" value="<?= /*$vehicle->getImage()->getName()*/
                            $targetFile ?>">
                        </tr>
                    </table>
                    <button type="submit" name="generarPDF">Generar PDF</button>
                </form>
                </body>
                </html>
                <?php
            } else {
                throw new MoveUploadedFileException("Error al mover la imagen.");
            }
        } else {
            echo "<h3>Hubo errores en la validación:</h3>";
            foreach ($errores as $error) {
                echo "<p>" . $error . "</p>";
            }
        }
    }
} catch (TokenCSRFException $e) {
    echo "Error CSRF: " . $e->getMessage();
} catch (CreateDirectoryException $e) {
    echo "Error al crear el directorio: " . $e->getMessage();
} catch (FileSizeException $e) {
    echo "Error: " . $e->getMessage();
} catch (MoveUploadedFileException $e) {
    echo "Error al subir la imagen: " . $e->getMessage();
} catch (Exception $e) {
    echo "Ha ocurrido un error: " . $e->getMessage();
}
