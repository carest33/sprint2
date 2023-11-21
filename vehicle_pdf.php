<?php
require('fpdf/fpdf.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = [
        "Marca" => $_POST["brand"],
        "Modelo" => $_POST["model"],
        "Color" => $_POST["color"],
        "Matrícula" => $_POST["plate"],
        "Transmisión" => $_POST["gearShift"],
        "Combustible" => $_POST["fuel"],
        "Kilómetros" => $_POST["km"] . ' Km',
        "Proveedor" => $_POST["provider"],
        "Precio de Compra" => $_POST["buyPrice"] . ' euros',
        "Precio de Venta" => $_POST["sellPrice"] . ' euros',
        "IVA" => $_POST["iva"] . '%',
        "Fecha de Primera Matrícula" => $_POST["registrationDate"],
        "Estado" => $_POST["isNew"],
        "Transporte Incluido" => $_POST["includedTransport"],
        "Número de Bastidor" => $_POST["numChassis"],
        "Daños Observados" => $_POST["observedDamages"],
        "Descripción" => $_POST["description"],
    ];

    class vehiclePDFs extends FPDF
    {
        function Header()
        {
            $this->SetFont('Arial', 'B', 16);
            $this->Cell(0, 15, mb_convert_encoding('Informe del vehículo', 'ISO-8859-1'), 0, 1, 'C');
        }

        function Footer()
        {
            $this->SetY(-15);
            $this->SetFont('Arial', 'I', 8);
            $this->Cell(0, 10, mb_convert_encoding('Página ' . $this->PageNo(), 'ISO-8859-1'), 0, 0);
        }
    }

    $pdf = new vehiclePDFs();
    $pdf->AddPage();

    foreach ($data as $label => $value) {
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(75, 10, mb_convert_encoding($label . ':', 'ISO-8859-15'), 0, 0, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 10, mb_convert_encoding($value, 'ISO-8859-15'), 0, 1, 'L');
    }

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(75, 10, mb_convert_encoding('Imagen del vehículo:', 'ISO-8859-15'), 0, 0, 'L');
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 15, '', 0, 1);
    $pdf->Image($_POST["image"], null, null, 100, 0);

    header('Content-Type: application/pdf');
    $pdf->Output();
}