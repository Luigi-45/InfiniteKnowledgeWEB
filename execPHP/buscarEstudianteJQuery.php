<?php require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/plantillas/head.php'); ?>
<?php 

$estudiante = $_POST['estudiante']; 

require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/EstudianteDAO.php');
try {
      
    $estudianteDAO= new EstudianteDAO();
    $estudiantes = array();
    $estudiantes=$estudianteDAO->buscarPorNombreCompleto($estudiante);

    } 
catch (Exception $e) {     
      echo $e->getMessage();
      exit;   
     
    }
?>
<table class="modeloTabla" id="listaEstudiantes">
    <thead>
        <tr>
            <th>  Id  </th>
            <th>  DNI </th>
            <th>  Nombre completo </th>
            <th>  Fecha de Nacimiento </th>
        </tr>
    </thead>
    <?php foreach($estudiantes as $i){ ?>
        <tr onclick="changeIncidentValue2(this)">
            <td> <?php echo $i->getMiembroId(); ?> </td>
            <td> <?php echo $i->getDni(); ?> </td>
            <td> <?php echo $i->getNombreCompleto(); ?> </td>
            <td> <?php echo $i->getFechaNacimiento(); ?> </td>
        </tr>
    <?php } ?>
</table>