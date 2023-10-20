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
            <h3> Modificar docente: </h3>
            <?php
                require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/DocenteDAO.php');
                require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DTO/Docente.php');

                $banderaErrores = false;

                if($_SERVER["REQUEST_METHOD"]=="POST"){
                    $docenteIngresado = new Docente();
                    $docenteIngresado->construirObjeto($_POST["idDocente"],$_POST["dniDocente"],$_POST["nombreDocente"],$_POST["apellidoPaternoDocente"],$_POST["apellidoMaternoDocente"],
                    $_POST["fechaNacimientoDocente"],$_POST["genero"],$_POST["numeroTelefonico"],$_REQUEST["gradoAcademico"],$_REQUEST["especialidadAcademica"]);
                    
                    $usuarioIngresado = new Usuario();
                    $usuarioIngresado->construirObjeto2($_POST["idUsuario"],$_POST["correoE"],$_POST["contrasenia"],$_POST["rol"]); 

                    $docenteDAO = new DocenteDAO();
                    $banderaErrores = false;
                    $arrayMensajes = array_merge($docenteIngresado->validarCampos(),$usuarioIngresado->validarCampos2());
    
                    if(count($arrayMensajes)>0){
                        $banderaErrores = true;
                    }
                    else{
                        try{
                            $docenteDAO->actualizar($docenteIngresado);
                            $usuarioDAO->actualizar2($usuarioIngresado);
                            $banderaErrores = false;
                        }
                        catch(Exception $e){
                            $arrayMensajes[]=$e->getMessage();
                            $banderaErrores = true;
                        }
                    }
    
                    if(!$banderaErrores){
                        echo "<p> Docente modificado satisfactoriamente </p>";
                        header("Location: gestionar_docentes.php");
                    }
                    else{
                        foreach($arrayMensajes as $mensaje){
                            echo "<p>".$mensaje."</p>";
                        }
                    }
                }
                else{
                    $docenteDAO = new DocenteDAO();
                    $docente = $docenteDAO->buscarPorId($_GET["idDocente"]);
                    $usuario = $usuarioDAO->buscarPorDNI($docente->getDni());                           
                }

                if(!$banderaErrores){
            ?>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" name="" method="post">
                <label for="">DNI:</label>
                <input name="dniDocente" type="text" required value = "<?php echo $docente->getDni(); ?>" required minlength="8" maxlength="8" autocomplete="off" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;">
                <br><br>
                <label for="">Nombre:</label>
                <input name="nombreDocente" type="text" value = "<?php echo $docente->getNombre(); ?>" required maxlength="50" autocomplete="off" onKeypress="if (!(event.keyCode < 45 || event.keyCode > 57)) event.returnValue = false;">
                <br><br>
                <label for="">Apellido Paterno:</label>
                <input name="apellidoPaternoDocente" type="text" value = "<?php echo $docente->getApellidoPaterno(); ?>" required maxlength="50" autocomplete="off" onKeypress="if (!(event.keyCode < 45 || event.keyCode > 57)) event.returnValue = false;">
                <br><br>
                <label for="">Apellido Materno:</label>
                <input name="apellidoMaternoDocente" type="text" value = "<?php echo $docente->getApellidoMaterno(); ?>" required maxlength="50" autocomplete="off" onKeypress="if (!(event.keyCode < 45 || event.keyCode > 57)) event.returnValue = false;">
                <br><br>
                <label for="">Fecha de Nacimiento:</label>
                <input name="fechaNacimientoDocente" type="date" value = "<?php echo $docente->getFechaNacimiento(); ?>" required>
                <br><br>
                <label for="">Número Telefónico:</label>
                <input name="numeroTelefonico" type="text" value = "<?php echo $docente->getNumeroTelefonico(); ?>" required minlength="9" maxlength="9" autocomplete="off" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;">
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
                <input name="correoE" type="text" value = "<?php echo $usuario->getCorreoElectronico(); ?>" required autocomplete="off">
                <br><br>
                <input name="idDocente" type="hidden" value = "<?php echo $docente->getMiembroId(); ?>">
                <input name="idUsuario" type="hidden" value = "<?php echo $usuario->getUsuarioId(); ?>">
                <input name="contrasenia" type="hidden" value = "<?php echo $usuario->getContrasenia(); ?>">
                <input name="rol" type="hidden" value = "<?php echo $usuario->getRol(); ?>">
                <input name="genero" type="hidden" value = "<?php echo $docente->getGenero(); ?>">
                <button type="submit"> Enviar </button>
            </form>

            <?php } ?>
        </div>
    </section>
    <?php require_once('plantillas/footer.php'); ?>
</body>
</html>