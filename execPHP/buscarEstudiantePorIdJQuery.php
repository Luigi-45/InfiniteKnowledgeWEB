<?php 

$estudianteId = $_POST['estudianteId']; 
require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/EstudianteDAO.php');
try {
      
    $estudianteDAO= new EstudianteDAO();
    $estudiante = new Estudiante();
    $estudiante=$estudianteDAO->buscarPorId($estudianteId);
    echo json_encode($estudiante);

    } catch (Exception $e) {     
      echo $e->getMessage();
      exit;   
     
    }

?>