<?php require_once('plantillas/head.php'); 
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
            <h3> Eliminar docente: </h3>
            <?php
                require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/DocenteDAO.php');

                if($_SERVER["REQUEST_METHOD"]=="POST"){
                    $docenteDAO = new DocenteDAO();
                    $docenteDAO->eliminar($_POST["idDocente"]);
                    header("Location:gestionar_docentes.php");
                }
                else{
                    $docenteDAO = new DocenteDAO();
                    $docente = $docenteDAO->buscarPorId($_GET["idDocente"]);
                    $usuario = $usuarioDAO->buscarPorDNI($docente->getDni());                
                }

            ?>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" name="" method="post">
                <label for="">DNI:</label>
                <input name="dniDocente" type="text" required value = "<?php echo $docente->getDni(); ?>" readonly>
                <br><br>
                <label for="">Nombre:</label>
                <input name="nombreDocente" type="text" value = "<?php echo $docente->getNombre(); ?>" readonly>
                <br><br>
                <label for="">Apellido Paterno:</label>
                <input name="apellidoPaternoDocente" type="text" value = "<?php echo $docente->getApellidoPaterno(); ?>" readonly>
                <br><br>
                <label for="">Apellido Materno:</label>
                <input name="apellidoMaternoDocente" type="text" value = "<?php echo $docente->getApellidoMaterno(); ?>" readonly>
                <br><br>
                <label for="">Fecha de Nacimiento:</label>
                <input name="fechaNacimientoDocente" type="date" value = "<?php echo $docente->getFechaNacimiento(); ?>" readonly>
                <br><br>
                <label for="">Número Telefónico:</label>
                <input name="numeroTelefonico" type="text" value = "<?php echo $docente->getNumeroTelefonico(); ?>" readonly>
                <br><br>
                <label for="">Grado Académico:</label>
                <select name="gradoAcademico" id="">
                    <option value="Licenciado" <?php if($docente->getGradoAcademico()=='Licenciado'){ ?> selected <?php } ?> >Licenciado</option>
                    <option value="Magister" <?php if($docente->getGradoAcademico()=='Magister'){ ?> selected <?php } ?>>Magister</option>
                    <option value="Doctor" <?php if($docente->getGradoAcademico()=='Doctor'){ ?> selected <?php } ?>>Doctor</option>
                </select>
                <br><br>
                <label for="">Especialidad Académica:</label>
                <select name="especialidadAcademica" id="">
                    <option value="Ciencias" <?php if($docente->getEspecialidadAcademica()=='Ciencias'){ ?> selected <?php } ?> >Ciencias</option>
                    <option value="Humanidades" <?php if($docente->getEspecialidadAcademica()=='Humanidades'){ ?> selected <?php } ?>>Humanidades</option>
                </select>
                <br><br>
                <label for="">Correo electrónico:</label>
                <input name="correoE" type="text" value = "<?php echo $usuario->getCorreoElectronico(); ?>" readonly>
                <br><br>
                <input name="idDocente" type="hidden" value = "<?php echo $docente->getMiembroId(); ?>">
                <input name="genero" type="hidden" value = "<?php echo $docente->getGenero(); ?>">
                <button type="submit"> Enviar </button>
            </form>
        </div>
    </section>
    <?php require_once('plantillas/footer.php'); ?>
</body>
</html>