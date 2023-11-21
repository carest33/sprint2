<?php
require('fpdf/fpdf.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = [
        "Nombre completo" => $_POST["name"],
        "Dirección completa" => $_POST["completeAddress"],
        "Teléfono" => $_POST["phone"],
        "Correo electrónico" => $_POST["email"],
        "CIF" => $_POST["CIF"],
        "NIF del gerente" => $_POST["managerNIF"],
    ];

    class providerPDFs extends FPDF
    {
        function Header()
        {
            $this->SetFont('Arial', 'B', 16);
            $this->Cell(0, 15, 'Detalles de Proveedor', 0, 1, 'C');
        }
    }

    $pdf = new providerPDFs();
    $pdf->AddPage();

    foreach ($data as $label => $value) {
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(75, 10, mb_convert_encoding($label . ':', 'ISO-8859-15'), 0, 0, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 10, mb_convert_encoding($value, 'ISO-8859-15'), 0, 1, 'L');
    }

    header('Content-Type: application/pdf');
    $pdf->Output();
}