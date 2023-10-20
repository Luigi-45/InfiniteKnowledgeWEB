<?php 

$estudianteId = $_POST['estudianteId'];
$docenteId = $_POST['docenteId'];
$cursoId = $_POST['cursoId'];

/*echo $estudianteId;
echo $docenteId;
echo $cursoId;*/

/*$estudianteId = $_GET['estudianteId'];
$docenteId = $_GET['docenteId'];
$cursoId = $_GET['cursoId'];*/

require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/RegistroCalificacionesDAO.php');
try {
      
    $registroCalificacionesDAO = new RegistroCalificacionesDAO();
    $registro = $registroCalificacionesDAO->buscarPorId($estudianteId,$docenteId,$cursoId);

    $data = array();

    $data["estudianteId"] = $registro->estudianteId;
    $data["docenteId"] = $registro->docenteId;
    $data["cursoId"] = $registro->cursoId;
    $data["salonClases"] = $registro->salonClases;
    $data["estudiante"] = $registro->estudiante;
    $data["docente"] = $registro->docente;
    $data["curso"] = $registro->curso;

    echo json_encode($data);
    
} 
catch (Exception $e) {     
      echo $e->getMessage();
      exit;   
     
    }
?>