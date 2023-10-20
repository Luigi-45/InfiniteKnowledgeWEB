<?php require_once('plantillas/head.php'); 
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/AuxiliarAcademicoDAO.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/UsuarioDAO.php');

    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DTO/Estudiante.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/EstudianteDAO.php');

    $estudianteDAO = new EstudianteDAO();
    
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
            <h4>Modificar estudiante:</h4>
            <br><br>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" name="modificarEstudianteDocente" method="post">
            <?php
            $banderaErrores = false;
            if($_SERVER["REQUEST_METHOD"]=="POST"){
                $estudiante = new Estudiante();
                $estudiante->construirObjeto($_POST["idEstudiante"],$_POST["dniEstudiante"],$_POST["nombreEstudiante"],$_POST["apellidoPaternoEstudiante"],$_POST["apellidoMaternoEstudiante"],
                $_POST["fechaNacimientoEstudiante"],$_POST["genero"],$_POST["numeroTelefonico"]);
                
                $usuarioIngresado = new Usuario();
                $usuarioIngresado->construirObjeto2($_POST["idUsuario"],$_POST["correoE"],$_POST["contrasenia"],$_POST["rol"]); 

                $banderaErrores = false;
                $arrayMensajes = array_merge($estudiante->validarCampos(),$usuarioIngresado->validarCampos2());

                if(count($arrayMensajes)>0){
                    $banderaErrores = true;
                }
                else{
                    try{
                        $estudianteDAO->actualizar($estudiante);
                        $usuarioDAO->actualizar2($usuarioIngresado);
                        $banderaErrores = false;
                    }
                    catch(Exception $e){
                        $arrayMensajes[]=$e->getMessage();
                        $banderaErrores = true;
                    }
                }

                if(!$banderaErrores){
                    echo "<p> Estudiante modificado satisfactoriamente </p>";
                    header("Location: buscar_estudiante.php");
                }
                else{
                    foreach($arrayMensajes as $mensaje){
                        echo "<p>".$mensaje."</p>";
                    }
                }
            }
            else{
                $estudianteAsignado = $estudianteDAO->buscarPorId($_GET['id']);
                $usuario = $usuarioDAO->buscarPorDNI($estudianteAsignado->getDni());    
            }

            if(!$banderaErrores){
            ?> 
                <input name="idEstudiante" type="hidden" required value="<?php echo $estudianteAsignado->getMiembroId(); ?>">
                <label for="">DNI:</label>
                <input name="dniEstudiante" type="text" required value="<?php echo $estudianteAsignado->getDni(); ?>" required minlength="8" maxlength="8" autocomplete="off" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;"> 
                <br><br>
                <label for="">Nombre:</label>
                <input name="nombreEstudiante" type="text" value="<?php echo $estudianteAsignado->getNombre(); ?>" required maxlength="50" autocomplete="off" onKeypress="if (!(event.keyCode < 45 || event.keyCode > 57)) event.returnValue = false;"> 
                <br><br>
                <label for="">Apellido Paterno:</label>
                <input name="apellidoPaternoEstudiante" type="text" value="<?php echo $estudianteAsignado->getApellidoPaterno(); ?>" required maxlength="50" autocomplete="off" onKeypress="if (!(event.keyCode < 45 || event.keyCode > 57)) event.returnValue = false;"> 
                <br><br>
                <label for="">Apellido Materno:</label>
                <input name="apellidoMaternoEstudiante" type="text" value="<?php echo $estudianteAsignado->getApellidoMaterno(); ?>" required maxlength="50" autocomplete="off" onKeypress="if (!(event.keyCode < 45 || event.keyCode > 57)) event.returnValue = false;">
                <br><br>
                <label for="">Fecha de Nacimiento:</label>
                <input name="fechaNacimientoEstudiante" type="date" value="<?php echo $estudianteAsignado->getFechaNacimiento(); ?>" required>
                <br><br>
                <label for="">Número Telefónico:</label>
                <input name="numeroTelefonico" type="text" value="<?php echo $estudianteAsignado->getNumeroTelefonico(); ?>" required minlength="9" maxlength="9" autocomplete="off" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;">
                <br><br>
                <label for="">Correo electrónico:</label>
                <input name="correoE" type="text" value = "<?php echo $usuario->getCorreoElectronico(); ?>" required autocomplete="off">
                <br><br>
                <input name="idUsuario" type="hidden" value = "<?php echo $usuario->getUsuarioId(); ?>">
                <input name="contrasenia" type="hidden" value = "<?php echo $usuario->getContrasenia(); ?>">
                <input name="rol" type="hidden" value = "<?php echo $usuario->getRol(); ?>">
                <input name="genero" type="hidden" required value="<?php echo $estudianteAsignado->getGenero(); ?>">
                <button type="submit"> Enviar </button>
            </form>
            <?php } ?>
        </div>
    </section>
    <?php require_once('plantillas/footer.php'); ?>
</body>