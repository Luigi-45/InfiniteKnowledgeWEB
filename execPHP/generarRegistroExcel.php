<?php
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/DocenteDAO.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DTO/RegistroCalificaciones.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/RegistroCalificacionesDAO.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/library/vendor/autoload.php');
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\IOFactory;

    if($_SERVER["REQUEST_METHOD"]=="POST"){
        $registroCalificacionesDAO = new RegistroCalificacionesDAO();

        $registros = $registroCalificacionesDAO->buscarParaDocente($_POST['dni'],$_POST['idCurso'],$_POST['salonClases'],'1');

        $miembroDAO = new DocenteDAO();
        $spreadsheet = new Spreadsheet();
        $spreadsheet->getProperties()->setCreator($miembroDAO->buscarNombreCompletoPorDNI($_POST['dni']));
        
        $spreadsheet->setActiveSheetIndex(0);
        $spreadsheet->getActiveSheet()->setTitle("Bimestre 1");

        if(count($registros)!=0){
            $hojaActiva = $spreadsheet->getActiveSheet();

            $hojaActiva->setCellValue('A1','Docente:');
            $hojaActiva->setCellValue('A2','Curso:');
            $hojaActiva->setCellValue('A3','Salón:');
            $hojaActiva->setCellValue('A4','Bimestre:');
            $hojaActiva->setCellValue('A5','Emisión:');

            $hojaActiva->setCellValue('B1',$registros[0][1]->getNombreCompleto());
            $hojaActiva->setCellValue('B2',$registros[0][2]->getNombre());
            $hojaActiva->setCellValue('B3',$registros[0][3]->getSalonClases());
            $hojaActiva->setCellValue('B4',$registros[0][3]->getBimestre());
            $hojaActiva->setCellValue('B5',date('d/m/y'));

            $hojaActiva->setCellValue('A6','N°');
            $hojaActiva->setCellValue('B6','Estudiante');
            $hojaActiva->setCellValue('C6','Calif. 1');
            $hojaActiva->setCellValue('D6','Calif. 2');
            $hojaActiva->setCellValue('E6','Calif. 3');
            $hojaActiva->setCellValue('F6','Calif. 4');
            $hojaActiva->setCellValue('G6','Promedio');
            $hojaActiva->setCellValue('H6','Estado');

            for($i=7;$i<count($registros)+7;$i++){
                $hojaActiva->setCellValue('A'.strval($i),$i-6);
                $hojaActiva->setCellValue('B'.strval($i),$registros[$i-7][0]->getNombreCompleto());
                $hojaActiva->setCellValue('C'.strval($i),$registros[$i-7][3]->getCalif1());
                $hojaActiva->setCellValue('D'.strval($i),$registros[$i-7][3]->getCalif2());
                $hojaActiva->setCellValue('E'.strval($i),$registros[$i-7][3]->getCalif3());
                $hojaActiva->setCellValue('F'.strval($i),$registros[$i-7][3]->getCalif4());
                $hojaActiva->setCellValue('G'.strval($i),$registros[$i-7][3]->getPromedio());
                $hojaActiva->setCellValue('H'.strval($i),$registros[$i-7][3]->getEstadoAprobacion());
            }
        }

        $spreadsheet->createSheet(1)->setTitle("Bimestre 2");
        $spreadsheet->setActiveSheetIndex(1);

        $registros = $registroCalificacionesDAO->buscarParaDocente($_POST['dni'],$_POST['idCurso'],$_POST['salonClases'],'2');

        if(count($registros)!=0){
            $hojaActiva = $spreadsheet->getActiveSheet();

            $hojaActiva->setCellValue('A1','Docente:');
            $hojaActiva->setCellValue('A2','Curso:');
            $hojaActiva->setCellValue('A3','Salón:');
            $hojaActiva->setCellValue('A4','Bimestre:');
            $hojaActiva->setCellValue('A5','Emisión:');

            $hojaActiva->setCellValue('B1',$registros[0][1]->getNombreCompleto());
            $hojaActiva->setCellValue('B2',$registros[0][2]->getNombre());
            $hojaActiva->setCellValue('B3',$registros[0][3]->getSalonClases());
            $hojaActiva->setCellValue('B4',$registros[0][3]->getBimestre());
            $hojaActiva->setCellValue('B5',date('d/m/y'));

            $hojaActiva->setCellValue('A6','N°');
            $hojaActiva->setCellValue('B6','Estudiante');
            $hojaActiva->setCellValue('C6','Calif. 1');
            $hojaActiva->setCellValue('D6','Calif. 2');
            $hojaActiva->setCellValue('E6','Calif. 3');
            $hojaActiva->setCellValue('F6','Calif. 4');
            $hojaActiva->setCellValue('G6','Promedio');
            $hojaActiva->setCellValue('H6','Estado');

            for($i=7;$i<count($registros)+7;$i++){
                $hojaActiva->setCellValue('A'.strval($i),$i-6);
                $hojaActiva->setCellValue('B'.strval($i),$registros[$i-7][0]->getNombreCompleto());
                $hojaActiva->setCellValue('C'.strval($i),$registros[$i-7][3]->getCalif1());
                $hojaActiva->setCellValue('D'.strval($i),$registros[$i-7][3]->getCalif2());
                $hojaActiva->setCellValue('E'.strval($i),$registros[$i-7][3]->getCalif3());
                $hojaActiva->setCellValue('F'.strval($i),$registros[$i-7][3]->getCalif4());
                $hojaActiva->setCellValue('G'.strval($i),$registros[$i-7][3]->getPromedio());
                $hojaActiva->setCellValue('H'.strval($i),$registros[$i-7][3]->getEstadoAprobacion());
            }
        }

        $spreadsheet->createSheet(2)->setTitle("Bimestre 3");
        $spreadsheet->setActiveSheetIndex(2);
        
        $registros = $registroCalificacionesDAO->buscarParaDocente($_POST['dni'],$_POST['idCurso'],$_POST['salonClases'],'3');

        if(count($registros)!=0){
            $hojaActiva = $spreadsheet->getActiveSheet();

            $hojaActiva->setCellValue('A1','Docente:');
            $hojaActiva->setCellValue('A2','Curso:');
            $hojaActiva->setCellValue('A3','Salón:');
            $hojaActiva->setCellValue('A4','Bimestre:');
            $hojaActiva->setCellValue('A5','Emisión:');

            $hojaActiva->setCellValue('B1',$registros[0][1]->getNombreCompleto());
            $hojaActiva->setCellValue('B2',$registros[0][2]->getNombre());
            $hojaActiva->setCellValue('B3',$registros[0][3]->getSalonClases());
            $hojaActiva->setCellValue('B4',$registros[0][3]->getBimestre());
            $hojaActiva->setCellValue('B5',date('d/m/y'));

            $hojaActiva->setCellValue('A6','N°');
            $hojaActiva->setCellValue('B6','Estudiante');
            $hojaActiva->setCellValue('C6','Calif. 1');
            $hojaActiva->setCellValue('D6','Calif. 2');
            $hojaActiva->setCellValue('E6','Calif. 3');
            $hojaActiva->setCellValue('F6','Calif. 4');
            $hojaActiva->setCellValue('G6','Promedio');
            $hojaActiva->setCellValue('H6','Estado');

            for($i=7;$i<count($registros)+7;$i++){
                $hojaActiva->setCellValue('A'.strval($i),$i-6);
                $hojaActiva->setCellValue('B'.strval($i),$registros[$i-7][0]->getNombreCompleto());
                $hojaActiva->setCellValue('C'.strval($i),$registros[$i-7][3]->getCalif1());
                $hojaActiva->setCellValue('D'.strval($i),$registros[$i-7][3]->getCalif2());
                $hojaActiva->setCellValue('E'.strval($i),$registros[$i-7][3]->getCalif3());
                $hojaActiva->setCellValue('F'.strval($i),$registros[$i-7][3]->getCalif4());
                $hojaActiva->setCellValue('G'.strval($i),$registros[$i-7][3]->getPromedio());
                $hojaActiva->setCellValue('H'.strval($i),$registros[$i-7][3]->getEstadoAprobacion());
            }
        }

        $spreadsheet->createSheet(3)->setTitle("Bimestre 4");
        $spreadsheet->setActiveSheetIndex(3);

        $registros = $registroCalificacionesDAO->buscarParaDocente($_POST['dni'],$_POST['idCurso'],$_POST['salonClases'],'4');

        if(count($registros)!=0){
            $hojaActiva = $spreadsheet->getActiveSheet();

            $hojaActiva->setCellValue('A1','Docente:');
            $hojaActiva->setCellValue('A2','Curso:');
            $hojaActiva->setCellValue('A3','Salón:');
            $hojaActiva->setCellValue('A4','Bimestre:');
            $hojaActiva->setCellValue('A5','Emisión:');

            $hojaActiva->setCellValue('B1',$registros[0][1]->getNombreCompleto());
            $hojaActiva->setCellValue('B2',$registros[0][2]->getNombre());
            $hojaActiva->setCellValue('B3',$registros[0][3]->getSalonClases());
            $hojaActiva->setCellValue('B4',$registros[0][3]->getBimestre());
            $hojaActiva->setCellValue('B5',date('d/m/y'));

            $hojaActiva->setCellValue('A6','N°');
            $hojaActiva->setCellValue('B6','Estudiante');
            $hojaActiva->setCellValue('C6','Calif. 1');
            $hojaActiva->setCellValue('D6','Calif. 2');
            $hojaActiva->setCellValue('E6','Calif. 3');
            $hojaActiva->setCellValue('F6','Calif. 4');
            $hojaActiva->setCellValue('G6','Promedio');
            $hojaActiva->setCellValue('H6','Estado');

            for($i=7;$i<count($registros)+7;$i++){
                $hojaActiva->setCellValue('A'.strval($i),$i-6);
                $hojaActiva->setCellValue('B'.strval($i),$registros[$i-7][0]->getNombreCompleto());
                $hojaActiva->setCellValue('C'.strval($i),$registros[$i-7][3]->getCalif1());
                $hojaActiva->setCellValue('D'.strval($i),$registros[$i-7][3]->getCalif2());
                $hojaActiva->setCellValue('E'.strval($i),$registros[$i-7][3]->getCalif3());
                $hojaActiva->setCellValue('F'.strval($i),$registros[$i-7][3]->getCalif4());
                $hojaActiva->setCellValue('G'.strval($i),$registros[$i-7][3]->getPromedio());
                $hojaActiva->setCellValue('H'.strval($i),$registros[$i-7][3]->getEstadoAprobacion());
            }
        }

        ob_end_clean();
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Reporte de calificaciones_'.$registros[0][1]->getNombreCompleto().'_'.$registros[0][2]->getNombre().'_'.$registros[0][3]->getSalonClases().'.xlsx"');
        header('Cache-Control: max-age=0');
        
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
    }
?>