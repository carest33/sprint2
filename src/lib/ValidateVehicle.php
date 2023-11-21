<?php

class ValidateVehicle
{
    public function validate($postData, $files)
    {
        $errors = [];


        if (empty($postData["brand"])) {
            $errors[] = "El campo Marca es obligatorio.";
        }

        if (empty($postData["model"])) {
            $errors[] = "El campo Modelo es obligatorio.";
        }

        if (empty($postData["color"])) {
            $errors[] = "El campo Color es obligatorio.";
        }

        if (!preg_match('/^[0-9]{4}[A-Z]{3}$/', $postData["plate"])) {
            $errors[] = "La matrícula debe contener 4 números seguidos de 3 letras en mayúsculas.";
        }

        if (empty($postData["gearShift"])) {
            $errors[] = "Debes seleccionar un tipo de marcha.";
        }

        if (empty($postData["fuel"])) {
            $errors[] = "El campo Combustible es obligatorio.";
        }

        if (!is_numeric($postData["km"])) {
            $errors[] = "El campo Kilómetros debe contener solo números.";
        }

        if (empty($postData["provider"])) {
            $errors[] = "El campo Proveedor es obligatorio.";
        }

        if (!is_numeric($postData["buyPrice"])) {
            $errors[] = "El campo Precio de Compra debe contener solo números.";
        }

        if (!is_numeric($postData["sellPrice"])) {
            $errors[] = "El campo Precio de Venta debe contener solo números.";
        }

        if (!is_numeric($postData["iva"])) {
            $errors[] = "El campo IVA debe contener solo números.";
        }

        if (empty($postData["registrationDate"]) || !$this->validateDate($postData["registrationDate"])) {
            $errors[] = "El campo Fecha de Primera Matrícula es obligatorio y debe tener un formato válido (Y-m-d).";
        }

        if (empty($postData["isNew"])) {
            $errors[] = "El campo Nuevo es obligatorio.";
        }

        if (empty($postData["includedTransport"])) {
            $errors[] = "El campo transporte incluido es obligatorio.";
        }

        if (empty($postData["numChassis"]) || !is_numeric($postData["numChassis"]) || strlen($postData["numChassis"]) != 17) {
            $errors[] = "El campo numero de bastidor debe contener 17 números.";
        }

        if (!$this->isValidImageFile($files["image"])) {
            $errors[] = "El archivo de imagen no es válido. Asegúrate de cargar una imagen válida (JPG, JPEG, PNG, GIF).";
        }

        return $errors;
    }

    private function validateDate($date)
    {
        $dateObj = DateTime::createFromFormat('Y-m-d', $date);
        return $dateObj && $dateObj->format('Y-m-d') === $date;
    }

    private function isValidImageFile($image)
    {
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        $extension = pathinfo($image['name'], PATHINFO_EXTENSION);
        return in_array(strtolower($extension), $allowedExtensions);
    }
}