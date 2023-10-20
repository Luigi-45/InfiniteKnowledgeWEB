<?php
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/DocenteDAO.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DTO/RegistroCalificaciones.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/RegistroCalificacionesDAO.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/library/TCPDF/tcpdf.php');

    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

    $PDF_HEADER_TITLE="COLEGIO DE ALTO RENDIMIENTO";
    $PDF_HEADER_STRING="COAR JUNÍN";
    $PDF_HEADER_LOGO="logo.png";
    $pdf->SetHeaderData($PDF_HEADER_LOGO, "20", $PDF_HEADER_TITLE, $PDF_HEADER_STRING);

    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

    $pdf->SetFont('dejavusans', '', 14, '', true);

    for($b=1;$b<5;$b++){
        $pdf->AddPage('L');
        $registroCalificacionesDAO = new RegistroCalificacionesDAO();
        $registros = $registroCalificacionesDAO->buscarParaDocente($_POST['dni'],$_POST['idCurso'],$_POST['salonClases'],strval($b));

        $html = 
        '<style>
        table,th,td{
            border: 1px solid #dee2e6;
            border-collapse: collapse;
            border-spacing: 1px;
        }

        </style>';

        $html.='<h2>Reporte de calificaciones</h2>';
        $html.='<br><b>Docente:</b> '.$registros[0][1]->getNombreCompleto();
        $html.='<br><b>Curso:</b> '.$registros[0][2]->getNombre();  
        $html.='<br><b>Salón:</b> '.$registros[0][3]->getSalonClases();
        $html.='<br><b>Bimestre:</b> '.$registros[0][3]->getBimestre();
        $html.='<br><b>Emisión:</b> '.date('d/m/y');
        $html.='<br>';
        $html.='<table>';
        $html.='<tr>';
        $html.='<th style="width: 5%;"><b>N°</b></th>';
        $html.='<th style="width: 30%;"><b>Estudiante</b></th>';
        $html.='<th style="width: 10%;"><b>Calif. 1</b></th>';
        $html.='<th style="width: 10%;"><b>Calif. 2</b></th>';
        $html.='<th style="width: 10%;"><b>Calif. 3</b></th>';
        $html.='<th style="width: 10%;"><b>Calif. 4</b></th>';
        $html.='<th style="width: 11%;"><b>Promedio</b></th>';
        $html.='<th style="width: 15%;"><b>Estado</b></th>';
        $html.='</tr>'; 
        
        $numFila=0;
        foreach($registros as $i){ 
            $numFila++;

            $html .='<tr>';
            $html .='<td>'.$numFila.'</td>';
            $html .='<td>'.$i[0]->getNombreCompleto().'</td>';
            $html .='<td>'.$i[3]->getCalif1().'</td>';
            $html .='<td>'.$i[3]->getCalif2().'</td>';
            $html .='<td>'.$i[3]->getCalif3().'</td>';
            $html .='<td>'.$i[3]->getCalif4().'</td>';
            $html .='<td>'.$i[3]->getPromedio().'</td>';
            $html .='<td>'.$i[3]->getEstadoAprobacion().'</td>';
            $html .='</tr>';

        }

        $html .='</table>';

        $pdf->writeHTML($html, true, false, true, false, '');
    }

    ob_end_clean();
    $pdf->Output('Reporte de calificaciones_'.$registros[0][1]->getNombreCompleto().'_'.$registros[0][2]->getNombre().'_'.$registros[0][3]->getSalonClases().'.pdf', 'I');
?>