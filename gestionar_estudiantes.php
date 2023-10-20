<?php require_once('plantillas/head.php'); 
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/DocenteDAO.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/AuxiliarAcademicoDAO.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/UsuarioDAO.php');
    
    if((empty($_SESSION['dni']) && empty($_SESSION['rol'])) || ($_SESSION["rol"]!=2)){
        header("Location:index.php");
        exit;
    }
?>

<body>
    <?php require_once('plantillas/nav.php'); ?>
    <section>
        <div class="container">
            <img src="img/logo.png" alt="">
            <h3> <?php 
                if($_SESSION["rol"]==2){ 
                    echo "Auxiliar Académico"; 
                }
                ?> 
            </h3>
            <?php $usuarioDAO = new UsuarioDAO(); 
                if($_SESSION["rol"]==2){ 
                    $auxiliarAcademicoDAO = new AuxiliarAcademicoDAO(); 
                }
                ?>
            <br>
            <h3> <?php                 
                if($_SESSION["rol"]==2){ 
                    echo $auxiliarAcademicoDAO->buscarNombreCompletoPorDNI($_SESSION['dni']);
                }
                ?> 
            </h3>
            <h3> <?php echo $usuarioDAO->buscarCorreoPorDNI($_SESSION['dni']); ?> </h3>
            <br><br>
            <h2>Registro de estudiantes</h2>
            <br><br>
            <table class="modeloTabla">
                <thead>
                    <tr>
                        <th> Id </th>
                        <th> DNI </th>
                        <th> Nombre completo </th>
                        <th> Fecha de Nacimiento </th>
                        <th> Número telefónico </th>
                        <th> Género </th>
                        <th> Correo electrónico </th>
                        <th> Acciones </th>
                    </tr>
                </thead>
                <?php
                    if($_SERVER["REQUEST_METHOD"]=="GET"){
                        require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DTO/Estudiante.php');
                        require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/EstudianteDAO.php');
                        $estudianteDAO = new EstudianteDAO();

                        $estudiantes = $estudianteDAO->buscarPorNombreCompleto($_GET["nombreCompleto"]);

                        foreach($estudiantes as $estudiante){
                ?>
                <tr>
                    <td> <?php echo $estudiante->getMiembroId(); ?> </td>
                    <td> <?php echo $estudiante->getDni(); ?> </td>
                    <td> <?php echo $estudiante->getNombreCompleto(); ?> </td>
                    <td> <?php echo $estudiante->getFechaNacimiento(); ?> </td>
                    <td> <?php echo $estudiante->getNumeroTelefonico(); ?> </td>
                    <td> <?php echo $estudiante->getGenero(); ?> </td>
                    <td> <?php echo $usuarioDAO->buscarCorreoPorDNI($estudiante->getDni()); ?> </td>
                    <?php if($_SESSION['rol']==2){?>
                    <td> <a href="<?php echo "modificar_estudiante.php?id=".$estudiante->getMiembroId(); ?>"> Modificar 
                    <br>
                    <a href="<?php echo "eliminar_estudiante.php?id=".$estudiante->getMiembroId(); ?>"> Eliminar </td>
                    <?php }?>
                </tr>
                <?php } 
                }?>
            </table>
            <br>
            <br><br>
        </div>
    </section>
    <?php require_once('plantillas/footer.php'); ?>
</body>
</html>