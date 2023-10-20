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
                require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/AuxiliarAcademicoDAO.php');
                require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DTO/AuxiliarAcademico.php');
                $auxiliarAcademicoDAO = new AuxiliarAcademicoDAO();
                $banderaErrores = false;
                
                if($_SERVER["REQUEST_METHOD"]=="POST"){
                    $auxiliarAcademicoIngresado = new AuxiliarAcademico();
                    $auxiliarAcademicoIngresado->construirObjeto($_POST["idAuxiliarAcademico"],$_POST["dniAuxiliarAcademico"],$_POST["nombreAuxiliarAcademico"],$_POST["apellidoPaternoAuxiliarAcademico"],$_POST["apellidoMaternoAuxiliarAcademico"],
                    $_POST["fechaNacimientoAuxiliarAcademico"],$_POST["genero"],$_POST["numeroTelefonico"],intval($_POST["nDocentesACargo"]),$_REQUEST["gradoAcademico"]);
                            
                    $usuarioIngresado = new Usuario();
                    $usuarioIngresado->construirObjeto2($_POST["idUsuario"],$_POST["correoE"],$_POST["contrasenia"],$_POST["rol"]);
                    
                    $banderaErrores = false;
                    $arrayMensajes = array_merge($auxiliarAcademicoIngresado->validarCampos(),$usuarioIngresado->validarCampos2());
            
                    if(count($arrayMensajes)>0){
                        $banderaErrores = true;
                    }
                    else{
                        try{
                            $auxiliarAcademicoDAO->actualizar($auxiliarAcademicoIngresado);
                            $usuarioDAO->actualizar2($usuarioIngresado);
                            $banderaErrores = false;
                        }
                        catch(Exception $e){
                            $arrayMensajes[]=$e->getMessage();
                            $banderaErrores = true;
                        }
                    }

                    if(!$banderaErrores){
                        echo "<p> Auxiliar Académico modificado satisfactoriamente </p>";
                        header("Location: gestionar_auxiliar_academico.php");
                    }
                    else{
                        foreach($arrayMensajes as $mensaje){
                            echo "<p>".$mensaje."</p>";
                        }
                    }
                }
                else{
                    $auxiliarAcademico = $auxiliarAcademicoDAO->buscarPorId($_GET["id"]);   
                    $usuario = $usuarioDAO->buscarPorDNI($auxiliarAcademico->getDni());  
                }

                if(!$banderaErrores){
            ?>
            <h3> Modificar auxiliar académico: </h3>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" name="" method="post">
                <label for="">DNI:</label>
                <input name="dniAuxiliarAcademico" type="text" value = "<?php echo $auxiliarAcademico->getDni(); ?>" required minlength="8" maxlength="8" autocomplete="off" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;"> 
                <br><br>
                <label for="">Nombre:</label>
                <input name="nombreAuxiliarAcademico" type="text" value = "<?php echo $auxiliarAcademico->getNombre(); ?>" required maxlength="50" autocomplete="off" onKeypress="if (!(event.keyCode < 45 || event.keyCode > 57)) event.returnValue = false;">
                <br><br>
                <label for="">Apellido Paterno:</label>
                <input name="apellidoPaternoAuxiliarAcademico" type="text" value = "<?php echo $auxiliarAcademico->getApellidoPaterno(); ?>" required maxlength="50" autocomplete="off" onKeypress="if (!(event.keyCode < 45 || event.keyCode > 57)) event.returnValue = false;">
                <br><br>
                <label for="">Apellido Materno:</label>
                <input name="apellidoMaternoAuxiliarAcademico" type="text" value = "<?php echo $auxiliarAcademico->getApellidoMaterno(); ?>" required maxlength="50" autocomplete="off" onKeypress="if (!(event.keyCode < 45 || event.keyCode > 57)) event.returnValue = false;"">
                <br><br>
                <label for="">Fecha de Nacimiento:</label>
                <input name="fechaNacimientoAuxiliarAcademico" type="date" value = "<?php echo $auxiliarAcademico->getFechaNacimiento(); ?>" required>
                <br><br>
                <label for="">Número Telefónico:</label>
                <input name="numeroTelefonico" type="text" value = "<?php echo $auxiliarAcademico->getNumeroTelefonico(); ?>" required minlength="9" maxlength="9" autocomplete="off" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;">
                <br><br>
                <label for="">Grado Académico:</label>
                <select name="gradoAcademico" id="">
                    <option value="Licenciado" <?php if($auxiliarAcademico->getGradoAcademico()=='Licenciado'){ ?> selected <?php } ?> >Licenciado</option>
                    <option value="Magister" <?php if($auxiliarAcademico->getGradoAcademico()=='Magister'){ ?> selected <?php } ?>>Magister</option>
                    <option value="Doctor" <?php if($auxiliarAcademico->getGradoAcademico()=='Doctor'){ ?> selected <?php } ?>>Doctor</option>
                </select>
                <br><br>
                <label for="">Correo electrónico:</label>
                <input name="correoE" type="text" value = "<?php echo $usuario->getCorreoElectronico(); ?>" required autocomplete="off">
                <br><br>
                <input name="idAuxiliarAcademico" type="hidden" value = "<?php echo $auxiliarAcademico->getMiembroId(); ?>">
                <input name="idUsuario" type="hidden" value = "<?php echo $usuario->getUsuarioId(); ?>">
                <input name="contrasenia" type="hidden" value = "<?php echo $usuario->getContrasenia(); ?>">
                <input name="rol" type="hidden" value = "<?php echo $usuario->getRol(); ?>">
                <input name="genero" type="hidden" value = "<?php echo $auxiliarAcademico->getGenero(); ?>">
                <input name="nDocentesACargo" type="hidden" value = "<?php echo $auxiliarAcademico->getNDocentesACargo(); ?>">
                <button type="submit"> Enviar </button>
            </form>
            <?php }?>
        </div>
    </section>
    <?php require_once('plantillas/footer.php'); ?>
</body>
</html>