<?php require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/plantillas/head.php'); ?>
<?php 

$estudiante2 = $_POST['estudiante2']; 

require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/RegistroCalificacionesDAO.php');
try {
    $registroCalificacionesDAO = new RegistroCalificacionesDAO();
    $registros = $registroCalificacionesDAO->buscarPorNombreEstudiante($estudiante2);
} 
catch (Exception $e) {     
      echo $e->getMessage();
      exit;   
     
    }
?>
<table class="modeloTabla" id="listaDocentes">
    <thead>
        <tr>
            <th>  Id Estudiante </th>
            <th>  Estudiante </th>
            <th>  Id Docente </th>
            <th>  Docente </th>
            <th>  Id Curso </th>
            <th>  Curso </th>
            <th>  Salón de clases </th>
        </tr>
    </thead>
    <?php
        for($i=0;$i<count($registros);$i++){ ?>
            <tr onclick="changeIncidentValue3(this)">
                <td> <?php echo $registros[$i]->getEstudianteId(); ?> </td>
                <td> <?php echo $registros[$i]->getEstudiante(); ?> </td>
                <td> <?php echo $registros[$i]->getDocenteId(); ?> </td>
                <td> <?php echo $registros[$i]->getDocente(); ?> </td>
                <td> <?php echo $registros[$i]->getCursoId(); ?> </td>
                <td> <?php echo $registros[$i]->getCurso(); ?> </td>
                <td> <?php echo $registros[$i]->getSalonClases(); ?> </td>
            </tr>
    <?php } 
    ?>
</table>