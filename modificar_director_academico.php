<?php require_once('plantillas/head.php'); 
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/DirectorAcademicoDAO.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/UsuarioDAO.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DTO/Usuario.php');

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

                $banderaErrores = false;

                if($_SERVER["REQUEST_METHOD"]=="POST"){
                    $directorAcademicoIngresado = new DirectorAcademico();
                    $directorAcademicoIngresado->construirObjeto($_POST["idDirectorAcademico"],$_POST["dniDirectorAcademico"],$_POST["nombreDirectorAcademico"],$_POST["apellidoPaternoDirectorAcademico"],$_POST["apellidoMaternoDirectorAcademico"],
                    $_POST["fechaNacimientoDirectorAcademico"],$_POST["genero"],$_POST["numeroTelefonico"],$_POST["aniosLabor"],$_REQUEST["gradoAcademico"]);

                    $usuarioIngresado = new Usuario();
                    $usuarioIngresado->construirObjeto2($_POST["idUsuario"],$_POST["correoE"],$_POST["contrasenia"],$_POST["rol"]);   
                            
                    $banderaErrores = false;
                    $arrayMensajes = array_merge($directorAcademicoIngresado->validarCampos(),$usuarioIngresado->validarCampos2());
            
                    if(count($arrayMensajes)>0){
                        $banderaErrores = true;
                    }
                    else{
                        try{
                            $directorAcademicoDAO->actualizar($directorAcademicoIngresado);
                            $usuarioDAO->actualizar2($usuarioIngresado);
                            $banderaErrores = false;
                        }
                        catch(Exception $e){
                            $arrayMensajes[]=$e->getMessage();
                            $banderaErrores = true;
                        }
                    }
            
                    if(!$banderaErrores){
                        echo "<p> Director Académico modificado satisfactoriamente </p>";
                        $_SESSION["dni"] = $_POST["dniDirectorAcademico"];
                        header("Location: gestionar_director_academico.php");
                    }
                    else{
                        foreach($arrayMensajes as $mensaje){
                            echo "<p>".$mensaje."</p>";
                        }
                    }
                }
                else{
                    $directorAcademico = $directorAcademicoDAO->buscarPorId();     
                    $usuario = $usuarioDAO->buscarPorDNI($_SESSION['dni']);               
                }

                if(!$banderaErrores){
            ?>
            <h3> Modificar director académico: </h3>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" name="" method="post">
                <label for="">DNI:</label>
                <input name="dniDirectorAcademico" type="text" value = "<?php echo $directorAcademico->getDni(); ?>" required minlength="8" maxlength="8" autocomplete="off" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;">
                <br><br>
                <label for="">Nombre:</label>
                <input name="nombreDirectorAcademico" type="text" value = "<?php echo $directorAcademico->getNombre(); ?>" required maxlength="50" autocomplete="off" onKeypress="if (!(event.keyCode < 45 || event.keyCode > 57)) event.returnValue = false;">
                <br><br>
                <label for="">Apellido Paterno:</label>
                <input name="apellidoPaternoDirectorAcademico" type="text" value = "<?php echo $directorAcademico->getApellidoPaterno(); ?>" required maxlength="50" autocomplete="off" onKeypress="if (!(event.keyCode < 45 || event.keyCode > 57)) event.returnValue = false;">
                <br><br>
                <label for="">Apellido Materno:</label>
                <input name="apellidoMaternoDirectorAcademico" type="text" value = "<?php echo $directorAcademico->getApellidoMaterno(); ?>" required maxlength="50" autocomplete="off" onKeypress="if (!(event.keyCode < 45 || event.keyCode > 57)) event.returnValue = false;">
                <br><br>
                <label for="">Fecha de Nacimiento:</label>
                <input name="fechaNacimientoDirectorAcademico" type="date" value = "<?php echo $directorAcademico->getFechaNacimiento(); ?>" required>
                <br><br>
                <label for="">Número Telefónico:</label>
                <input name="numeroTelefonico" type="text" value = "<?php echo $directorAcademico->getNumeroTelefonico(); ?>" required minlength="9" maxlength="9" autocomplete="off" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;">
                <br><br>
                <label for="">Grado Académico:</label>
                <select name="gradoAcademico" id="">
                    <option value="Licenciado" <?php if($directorAcademico->getGradoAcademico()=='Licenciado'){ ?> selected <?php } ?> >Licenciado</option>
                    <option value="Magister" <?php if($directorAcademico->getGradoAcademico()=='Magister'){ ?> selected <?php } ?>>Magister</option>
                    <option value="Doctor" <?php if($directorAcademico->getGradoAcademico()=='Doctor'){ ?> selected <?php } ?>>Doctor</option>
                </select>
                <br><br>
                <label for="">Años de labor:</label>
                <input name="aniosLabor" type="text" value = "<?php echo $directorAcademico->getAniosLabor(); ?>" required autocomplete="off" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;">
                <br><br>
                <label for="">Correo electrónico:</label>
                <input name="correoE" type="text" value = "<?php echo $usuario->getCorreoElectronico(); ?>" required autocomplete="off">
                <br><br>
                <input name="idDirectorAcademico" type="hidden" value = "<?php echo $directorAcademico->getMiembroId(); ?>">
                <input name="idUsuario" type="hidden" value = "<?php echo $usuario->getUsuarioId(); ?>">
                <input name="contrasenia" type="hidden" value = "<?php echo $usuario->getContrasenia(); ?>">
                <input name="rol" type="hidden" value = "<?php echo $usuario->getRol(); ?>">
                <input name="genero" type="hidden" value = "<?php echo $directorAcademico->getGenero(); ?>">
                <button type="submit"> Enviar </button>
            </form>
            <?php } ?>
        </div>
    </section>
    <?php require_once('plantillas/footer.php'); ?>
</body>
</html>