<?php require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/plantillas/head.php'); ?>
<?php 

$docente = $_POST['docente']; 

require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/DocenteDAO.php');
try {
      
    $docenteDAO= new DocenteDAO();
    $docentes = array();
    $docentes=$docenteDAO->buscarPorNombreCompleto($docente);

    } 
catch (Exception $e) {     
      echo $e->getMessage();
      exit;   
     
    }
?>
<table class="modeloTabla" id="listaDocentes">
    <thead>
        <tr>
            <th>  Id  </th>
            <th>  DNI </th>
            <th>  Nombre completo </th>
            <th>  Fecha de Nacimiento </th>
        </tr>
    </thead>
    <?php foreach($docentes as $docente){ ?>
        <tr onclick="changeIncidentValue(this)">
            <td> <?php echo $docente->getMiembroId(); ?> </td>
            <td> <?php echo $docente->getDni(); ?> </td>
            <td> <?php echo $docente->getNombreCompleto(); ?> </td>
            <td> <?php echo $docente->getFechaNacimiento(); ?> </td>
        </tr>
    <?php } ?>
</table>