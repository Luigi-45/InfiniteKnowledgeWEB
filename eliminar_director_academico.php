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
            <?php
                require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DTO/DirectorAcademico.php');

                if($_SERVER["REQUEST_METHOD"]=="POST"){
                    $directorAcademicoDAO->eliminar();
                    session_start();
                    session_destroy();
                    header("Location:index.php");
                }
                else{
                    $directorAcademico = $directorAcademicoDAO->buscarPorId();   
                    $usuario = $usuarioDAO->buscarPorDNI($_SESSION['dni']);                   
                }

            ?>
            <h3> Eliminar director académico: </h3>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" name="" method="post">
                <label for="">DNI:</label>
                <input name="dniDirectorAcademico" type="text" value = "<?php echo $directorAcademico->getDni(); ?>" readonly>
                <br><br>
                <label for="">Nombre:</label>
                <input name="nombreDirectorAcademico" type="text" value = "<?php echo $directorAcademico->getNombre(); ?>" readonly>
                <br><br>
                <label for="">Apellido Paterno:</label>
                <input name="apellidoPaternoDirectorAcademico" type="text" value = "<?php echo $directorAcademico->getApellidoPaterno(); ?>" readonly>
                <br><br>
                <label for="">Apellido Materno:</label>
                <input name="apellidoMaternoDirectorAcademico" type="text" value = "<?php echo $directorAcademico->getApellidoMaterno(); ?>" readonly>
                <br><br>
                <label for="">Fecha de Nacimiento:</label>
                <input name="fechaNacimientoDirectorAcademico" type="date" value = "<?php echo $directorAcademico->getFechaNacimiento(); ?>" readonly>
                <br><br>
                <label for="">Número Telefónico:</label>
                <input name="numeroTelefonico" type="text" value = "<?php echo $directorAcademico->getNumeroTelefonico(); ?>" readonly>
                <br><br>
                <label for="">Grado Académico:</label>
                <select name="gradoAcademico" id="">
                    <option value="Licenciado" <?php if($directorAcademico->getGradoAcademico()=='Licenciado'){ ?> selected <?php } ?> >Licenciado</option>
                    <option value="Magister" <?php if($directorAcademico->getGradoAcademico()=='Magister'){ ?> selected <?php } ?>>Magister</option>
                    <option value="Doctor" <?php if($directorAcademico->getGradoAcademico()=='Doctor'){ ?> selected <?php } ?>>Doctor</option>
                </select>
                <br><br>
                <label for="">Años de labor:</label>
                <input name="aniosLabor" type="text" value = "<?php echo $directorAcademico->getAniosLabor(); ?>" readonly>
                <br><br>
                <label for="">Correo electrónico:</label>
                <input name="correoE" type="text" value = "<?php echo $usuario->getCorreoElectronico(); ?>" readonly>
                <br><br>
                <input name="idDirectorAcademico" type="hidden" value = "<?php echo $directorAcademico->getMiembroId(); ?>">
                <input name="genero" type="hidden" value = "<?php echo $directorAcademico->getGenero(); ?>">
                <button type="submit"> Enviar </button>
            </form>
        </div>
    </section>
    <?php require_once('plantillas/footer.php'); ?>
</body>
</html>