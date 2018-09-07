<?php

class PDFCONTRACT extends FPDF {

    private $nit;
    private $direccion;
    private $telefono;

// Cabecera de página
    function Header() {
        // Logo
        $this->Image(IMAGES . SL . 'logo.png', 82, 15, 0);  
        $this->Ln(30);
        // Arial bold 15
        $this->SetFont('Arial', 'B', 10);                 
        // Título 
        $this->Cell(180, 5, $this->nit, 0, 0, 'C');
        $this->Ln();         
        $this->Cell(180, 5, $this->direccion, 0, 0, 'C');
        $this->Ln();        
        $this->Cell(180, 5, 'BOGOTA D.C.', 0, 0, 'C');
        $this->Ln();        
        $this->Cell(180, 5, 'COLOMBIA', 0, 0, 'C');
        $this->Ln();        
        $this->Cell(180, 5, 'TEL: ' . $this->telefono, 0, 0, 'C');        
        // Salto de línea
        $this->Ln(10);
    }

// Pie de página
    function Footer() {
        // Posición: a 1,5 cm del final
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 9);
        // Número de página
        $this->Cell(0, 10, 'Pagina ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

    function FancyTable($header, $data) {
        // Colores, ancho de línea y fuente en negrita
        $this->SetFillColor(54, 152, 8);
        $this->SetTextColor(255);
        $this->SetDrawColor(0, 0, 0);
        $this->SetLineWidth(.3);
        $this->SetFont('Arial', 'B');
        // Cabecera
        $w = array(20, 50, 30, 40, 40);
        for ($i = 0; $i < count($header); $i++)
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', true);
        $this->Ln();
        // Restauración de colores y fuentes
        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
        // Datos
        $fill = true;
        foreach ($data as $row) {
            $this->Cell($w[0], 6, $row["cantidad"], 'LTRB', 0, 'C', $fill);
            $this->Cell($w[1], 6, $row["nombre"], 'LTRB', 0, 'L', $fill);
            $this->Cell($w[2], 6, $row["referencia"], 'LTRB', 0, 'L', $fill);
            $this->Cell($w[3], 6, number_format($row["preciounitarioiva"], 0, ",", "."), 'LTRB', 0, 'R', $fill);
            $this->Cell($w[4], 6, number_format($row["preciototalitem"], 0, ",", "."), 'LTRB', 0, 'R', $fill);
            $this->Ln();
            $fill = !$fill;
        }
        // Línea de cierre
        //$this->Cell(array_sum($w), 0, '', 'T');
    }
    
     function ImprovedTable($header, $data) {
        // Anchuras de las columnas
        $this->SetFont('Times', 'B', 10);
        $w = array(120, 30);
        // Cabeceras
        for ($i = 0; $i < count($header); $i++)
            $this->Cell($w[$i], 5, $header[$i], 1, 0, 'C');
        $this->Ln();
        // Datos
        $this->SetFont('Times', '', 8);
        foreach ($data as $row) {
            $this->Cell($w[0], 5, $row[0], 'LR');
            $this->Cell($w[1], 5, $row[1], 'LR', 0, 'C');
            $this->Ln();
        }
        // Línea de cierre
        $this->Cell(array_sum($w), 0, '', 'T');
    }  

    function setInfo($nit, $direccion, $telefono) {
        $this->nit = $nit;
        $this->direccion = $direccion;
        $this->telefono = $telefono;
    }

}

?>