<?php 

$docenteId = $_POST['docenteId']; 
require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/DocenteDAO.php');
try {
      
    $docenteDAO= new DocenteDAO();
    $docente = new Docente();
    $docente=$docenteDAO->buscarPorId($docenteId);
    echo json_encode($docente);

    } catch (Exception $e) {     
      echo $e->getMessage();
      exit;   
     
    }

?>