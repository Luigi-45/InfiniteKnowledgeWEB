<?php 

$docenteId = $_POST['docenteId'];
$cursoId = $_POST['cursoId'];

require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/DocenteDAO.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/CursoDAO.php');
try {
      
    $docenteDAO = new DocenteDAO(); $cursoDAO = new CursoDAO();
    $conjuntoObjetos = array(); $conjuntoObjetos[] = $docenteDAO->buscarPorId($docenteId); $conjuntoObjetos[] = $cursoDAO->buscarPorId($cursoId);
    echo json_encode($conjuntoObjetos);
} 
catch (Exception $e) {     
      echo $e->getMessage();
      exit;   
     
    }
?>