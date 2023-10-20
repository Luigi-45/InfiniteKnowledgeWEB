<?php require_once('plantillas/head.php'); 
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/DirectorAcademicoDAO.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/UsuarioDAO.php');

    if((empty($_SESSION['dni']) && empty($_SESSION['rol'])) || ($_SESSION['rol']!=1)){
        header("Location:index.php");
        exit;
    }
?>
<body>
    <?php require_once('plantillas/nav.php'); ?>
    <section>
        <div class="container">
            <img src="img/logo.png" alt="">
            <h3> Director Académico: </h3>
            <?php $directorAcademicoDAO = new DirectorAcademicoDAO(); $usuarioDAO = new UsuarioDAO(); ?>
            <br>
            <h3> <?php echo $directorAcademicoDAO->buscarNombreCompleto(); ?> </h3>
            <h3> <?php echo $usuarioDAO->buscarCorreoPorDNI($_SESSION['dni']); ?> </h3>
            <br><br>
            <h3> Gestionar director académico: </h3>
            <table class="modeloTabla">
                <thead>
                    <tr>
                        <th>  Id  </th>
                        <th>  DNI  </th>
                        <th>  Nombre completo  </th>
                        <th>  Fecha de Nacimiento  </th>
                        <th>  Número telefónico  </th>
                        <th>  Género  </th>
                        <th>  Grado académico  </th>
                        <th>  Años de labor  </th>
                        <th>  Correo electrónico </th>
                        <th>  Acciones  </th>
                    </tr>
                </thead>
                <?php
                    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DTO/DirectorAcademico.php');

                    $director = $directorAcademicoDAO->buscarPorId();

                    if(!empty($director->getMiembroId())){
                ?> 
                <tr>
                    <td> <?php echo $director->getMiembroId(); ?> </td>
                    <td> <?php echo $director->getDNI(); ?> </td>
                    <td> <?php echo $director->getNombreCompleto(); ?> </td>
                    <td> <?php echo $director->getFechaNacimiento(); ?> </td>
                    <td> <?php echo $director->getNumeroTelefonico(); ?> </td>
                    <td> <?php echo $director->getGenero(); ?> </td>
                    <td> <?php echo $director->getGradoAcademico(); ?> </td>
                    <td> <?php echo $director->getAniosLabor(); ?> </td>
                    <td> <?php echo $usuarioDAO->buscarCorreoPorDNI($director->getDNI()); ?> </td>
                    <td> 
                        <a href="modificar_director_academico.php"> Modificar </a> <br>
                        <a href="eliminar_director_academico.php"> Eliminar </a> <br>
                    </td>
                </tr>
                <?php }?>
            </table>
            <br>
        </div>
    </section>
    <?php require_once('plantillas/footer.php'); ?>
</body>
</html>