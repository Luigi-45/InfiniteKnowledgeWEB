<?php require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/plantillas/head.php'); ?>
<?php 

$docente = $_POST['docente']; 

require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/DocenteDAO.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/CursoDAO.php');
try {
      
    $docenteDAO= new DocenteDAO();
    $cursoDAO = new CursoDAO();
    $docentes = array();
    $listaCursos = array(); $cursos = array();

    $docentes=$docenteDAO->buscarPorNombreCompleto($docente);

    foreach($docentes as $i){
        $cursos = array();
        $cursos = $cursoDAO->listarCursosParaDocente($i->getDni());
        $listaCursos[] = $cursos;
    }
} 
catch (Exception $e) {     
      echo $e->getMessage();
      exit;   
     
    }
?>
<table class="modeloTabla" id="listaDocentes">
    <thead>
        <tr>
            <th>  Id Docente </th>
            <th>  Docente </th>
            <th>  Id Curso </th>
            <th>  Curso </th>
        </tr>
    </thead>
    <?php for($i=0;$i<count($docentes);$i++){ 
            for($j=0;$j<count($listaCursos[$i]);$j++){ ?>
            <tr onclick="changeIncidentValue2(this)">
                <td> <?php echo $docentes[$i]->getMiembroId(); ?> </td>
                <td> <?php echo $docentes[$i]->getNombreCompleto(); ?> </td>
                <td> <?php echo $listaCursos[$i][$j]->getCursoId(); ?> </td>
                <td> <?php echo $listaCursos[$i][$j]->getNombre(); ?> </td>
            </tr>
    <?php } 
    }?>
</table>