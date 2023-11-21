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


try {
    if (isset($_GET['edit'])) {
        $vehicleId = $_GET['edit'];

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
    }
} catch (NoDataByIdException $error) {
    echo "Error: " . $error->getMessage();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css"/>
    <title>Dar de alta un vehículo</title>
</head>

<body>
<h1>Dar de alta un vehículo</h1>
<section>
    <article>
        <a href="index.php">
            <button style="margin: 15px; padding: 5px">Volver a la lista</button>
        </a>
        <form method="post" enctype="multipart/form-data" action="vehicle_form_process.php">
            <!-- Campo oculto para el ID del vehículo (si está en modo de edición) -->
            <input type="hidden" id="vehicleId" name="vehicleId"
                   value="<?php echo isset($_GET['edit']) ? $_GET['edit'] : ''; ?>">
            <!-- Campo oculto para indicar la acción (alta o edición) -->
            <input type="hidden" id="action" name="action" value="<?php echo isset($_GET['edit']) ? 'edit' : 'add'; ?>">

            <!-- Marca del vehículo -->
            <div>
                <label for="brand">Marca:</label>
                <input type="text" required id="brand" name="brand" pattern="^[A-Za-z0-9\s]+$"
                       title="Solo se permiten letras, números y espacios" value="<?= $brand ?>">
            </div>

            <!-- Modelo del vehículo respecto a su marca -->
            <div>
                <label for="model">Modelo:</label>
                <input type="text" required id="model" name="model" pattern="^[A-Za-z0-9\s]+$"
                       title="Solo se permiten letras, números y espacios" value="<?= $model ?>">
            </div>

            <!-- Color -->
            <div>
                <label for="color">Color:</label>
                <input type="text" required id="color" name="color" pattern="^[A-Za-z0-9\s]+$"
                       title="Solo se permiten letras, números y espacios" value="<?= $color ?>">
            </div>

            <!-- Matrícula Española 4 números y 3 letras -->
            <div>
                <label for="plate">Matrícula <abbr title="required" aria-label="required">*</abbr>:</label>
                <input type="text" required id="plate" name="plate" pattern="^\d{4}[A-Z]{3}$"
                       title="Debe contener 4 números seguidos de 3 letras en mayúsculas" value="<?= $plate ?>">
            </div>

            <!-- Tipo de marchas que tiene el coche Automaticas / Manuales -->
            <div>
                <label for="gearShift">Tipo de Marcha:</label>
                <input type="radio" id="gearShift-manual" name="gearShift" value="manual" <?php echo (isset($_GET['edit']) && $gearShift === 'manual') ? 'checked' : ''; ?>>
                <label for="gearShift-manual">Manual</label>
                <input type="radio" id="gearShift-auto" name="gearShift" value="auto" <?php echo (isset($_GET['edit']) && $gearShift === 'auto') ? 'checked' : ''; ?>>
                <label for="gearShift-auto">Automático</label>
            </div>

            <!-- Tipo de carburante -->
            <div>
                <label for="fuel">Tipo de Carburante:</label>
                <select name="fuel" id="fuel">
                    <option value="diesel" <?php echo (isset($_GET['edit']) && $fuel === 'diesel') ? 'selected' : ''; ?>>Diesel</option>
                    <option value="gasolina" <?php echo (isset($_GET['edit']) && $fuel === 'gasolina') ? 'selected' : ''; ?>>Gasolina</option>
                    <option value="electrico" <?php echo (isset($_GET['edit']) && $fuel === 'electrico') ? 'selected' : ''; ?>>Eléctrico</option>
                    <option value="hibrido" <?php echo (isset($_GET['edit']) && $fuel === 'hibrido') ? 'selected' : ''; ?>>Híbrido</option>
                </select>
            </div>

            <!-- Kilometraje que tiene el vehículo -->
            <div>
                <label for="km">Kilómetros del vehículo <abbr title="required" aria-label="required">*</abbr>:</label>
                <input type="number" required id="km" name="km" pattern="\d+"
                       title="Debe ser un número entero" value="<?= $km ?>">
            </div>

            <!-- Proveedor -->
            <div>
                <label for="provider">Proveedor:</label>
                <input type="text" required id="provider" name="provider" pattern="^[A-Za-z0-9\s]+$"
                       title="Solo se permiten letras, números y espacios" value="<?= $provider ?>">
            </div>

            <!-- Precio de compra al proveedor -->
            <div>
                <label for="buyPrice">Precio de Compra:</label>
                <input type="number" required id="buyPrice" name="buyPrice" step="0.01" pattern="\d+(\.\d{2})?"
                       title="Debe ser un número (puede incluir hasta 2 decimales)" value="<?= $buyPrice ?>">
            </div>

            <!-- Precio de venta al cliente "P.V.P" -->
            <div>
                <label for="sellPrice">Precio de Venta:</label>
                <input type="number" required id="sellPrice" name="sellPrice" step="0.01" pattern="\d+(\.\d{2})?"
                       title="Debe ser un número (puede incluir hasta 2 decimales)" value="<?= $sellPrice ?>">
            </div>

            <!-- IVA correspondiente establecida por La Agencia Estatal de Administración Tributaria -->
            <div>
                <label for="iva">iva <abbr title="required" aria-label="required">*</abbr>:</label>
                <input type="number" required id="iva" name="iva" step="0.01" pattern="\d+(\.\d{2})?"
                       title="Debe ser un número (puede incluir hasta 2 decimales)" value="21" readonly/>
            </div>

            <!-- Fecha de la primera matriculación del vehículo -->
            <div>
                <label for="registrationDate">Fecha de Primera Matrícula <abbr title="required" aria-label="required">*</abbr>:</label>
                <input type="date" required id="registrationDate" name="registrationDate" value="<?= $registrationDate ?>">
            </div>

            <!-- Señalización del estado del vehículo, Nuevo / Segunda mano -->
            <div>
                <label for="isNew">Nuevo:</label>
                <input type="radio" name="isNew" value="Si" id="isNew-si" <?= ($isNew === 0) ? 'checked' : ''; ?>>
                <label for="isNew-si">Si</label>
                <input type="radio" name="isNew" value="No" id="isNew-no" <?= ($isNew === 1) ? 'checked' : ''; ?>>
                <label for="isNew-no">No</label>
            </div>

            <!-- Señalización sobre el transporte incluido en el precio -->
            <div>
                <label for="includedTransport">Transporte incluido en el Precio:</label>
                <input type="radio" name="includedTransport" value="Si" id="includedTransport-si" <?= ($includedTransport === 0) ? 'checked' : ''; ?>>
                <label for="includedTransport-si">Si</label>
                <input type="radio" name="includedTransport" value="No" id="includedTransport-no" <?= ($includedTransport === 1) ? 'checked' : ''; ?>>
                <label for="includedTransport-no">No</label>
            </div>

            <!-- Número de Bastidor del vehículo -->
            <div>
                <label for="numChassis">Número de Bastidor <abbr title="required" aria-label="required">*</abbr>:</label>
                <input type="text" required id="numChassis" name="numChassis" pattern="^[A-HJ-NPR-Z0-9]{17}$"
                       title="Debe contener 17 caracteres alfanuméricos" value="<?= $numChassis ?>">
            </div>

            <!-- Daños observados y especificación en caso de ser afirmativo -->
            <div>
                <label for="observedDamages">Daños Observados:</label>
                <textarea id="observedDamages" name="observedDamages"><?= $observedDamages ?></textarea>
            </div>

            <!-- Descripción del vehículo -->
            <div>
                <label for="description">Descripción:</label>
                <textarea id="description" name="description"><?= $description ?></textarea>
            </div>

            <!-- Imagen del vehículo -->
            <div>
                <label for="image">Imagen <abbr title="required" aria-label="required">*</abbr>:</label><br>
                <?php if (!empty($image)) { ?>
                    <img style="margin: 15px" src="<?php echo $image; ?>" alt="Imagen del vehículo" height="200" />
                <?php } ?><br>
                <input type="file" id="image" name="image" required/>
            </div>


            <!-- Agrega un campo oculto con el token CSRF en el formulario -->
            <div>
                <input type="hidden" id="csrf" name="csrf" value="<?php echo $_SESSION['csrf']; ?>"/>
            </div>
            <button type="submit" value="Enviar">Enviar</button>
        </form>
    </article>
</section>

<footer>
</footer>
</body>

</html>