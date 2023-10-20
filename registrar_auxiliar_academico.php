<?php require_once('plantillas/head.php'); 
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/DirectorAcademicoDAO.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/UsuarioDAO.php');

    if((empty($_SESSION['dni']) && empty($_SESSION['rol'])) || ($_SESSION['rol']!=1)){
        header("Location:index.php");
        exit;
    }
?>

<body>
    <?php
        require_once('plantillas/nav.php');
    ?>
    <section>
        <div class="container">
            <img src="img/logo.png" alt="">
            <h3> Director Académico: </h3>
            <?php $directorAcademicoDAO = new DirectorAcademicoDAO(); $usuarioDAO = new UsuarioDAO(); ?>
            <br>
            <h3> <?php echo $directorAcademicoDAO->buscarNombreCompleto(); ?> </h3>
            <h3> <?php echo $usuarioDAO->buscarCorreoPorDNI($_SESSION['dni']); ?> </h3>
            <br><br>
            <h4>Registrar auxiliar académico:</h4>
            <br><br>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" name="registrarAuxiliarAcademico" method="post">
                <label for="">DNI:</label>
                <input name="dniAuxiliar" type="text" required minlength="8" maxlength="8" autocomplete="off" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;">
                <br><br>
                <label for="">Nombre:</label>
                <input name="nombreAuxiliar" type="text" required maxlength="50" autocomplete="off" onKeypress="if (!(event.keyCode < 45 || event.keyCode > 57)) event.returnValue = false;">
                <br><br>
                <label for="">Apellido Paterno:</label>
                <input name="apellidoPaternoAuxiliar" type="text" required maxlength="50" autocomplete="off" onKeypress="if (!(event.keyCode < 45 || event.keyCode > 57)) event.returnValue = false;">
                <br><br>
                <label for="">Apellido Materno:</label>
                <input name="apellidoMaternoAuxiliar" type="text" required maxlength="50" autocomplete="off" onKeypress="if (!(event.keyCode < 45 || event.keyCode > 57)) event.returnValue = false;">
                <br><br>
                <label for="">Fecha de Nacimiento:</label>
                <input name="fechaNacimientoAuxiliar" type="date" required>
                <br><br>
                <label for="">Número Telefónico:</label>
                <input name="numeroTelefonico" type="text" required minlength="9" maxlength="9" autocomplete="off" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;">
                <br><br>
                <label for="">Género:</label>
                <select name="genero" id="">
                    <option value="Hombre">Hombre</option>
                    <option value="Mujer">Mujer</option>
                </select>
                <br><br>
                <label for="">Grado Académico:</label>
                <select name="gradoAcademico" id="">
                    <option value="Licenciado">Licenciado</option>
                    <option value="Magister">Magister</option>
                    <option value="Doctor">Doctor</option>
                </select>
                <br><br>
                <label for="">Correo Electrónico:</label>
                <input name="correoElectronico" type="email" required maxlength="100" autocomplete="off">
                <br><br>
                <input name="nDocentesACargo" type="hidden" value="<?php 
                    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/UsuarioDAO.php');
                    $usuarioDAO = new UsuarioDAO();
                    echo $usuarioDAO->contarUsuarioPorRol(3);
                ?>">
                <br><br>
                <button type="submit"> Enviar </button>
            </form>
        </div>
    </section>
    <?php
        if($_SERVER["REQUEST_METHOD"]=="POST"){
            require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DTO/AuxiliarAcademico.php');
            require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/AuxiliarAcademicoDAO.php');

            require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DTO/Usuario.php');

            $auxiliarAcademico = new AuxiliarAcademico();
            $auxiliarAcademico->construirObjeto(0,$_POST["dniAuxiliar"],$_POST["nombreAuxiliar"],$_POST["apellidoPaternoAuxiliar"],$_POST["apellidoMaternoAuxiliar"],
            $_POST["fechaNacimientoAuxiliar"],$_REQUEST["genero"],$_POST["numeroTelefonico"],intval($_POST["nDocentesACargo"]),$_REQUEST["gradoAcademico"]);
            
            $usuarioAuxiliarAcademico = new Usuario();
            $usuarioAuxiliarAcademico->construirObjeto(0,$_POST["dniAuxiliar"],$_POST["correoElectronico"],$_POST["dniAuxiliar"].'aasSAD__@@',$_POST["dniAuxiliar"].'aasSAD__@@',2);

            $banderaErrores = false;
            $arrayMensajes = array_merge($auxiliarAcademico->validarCampos(),$usuarioAuxiliarAcademico->validarCampos());

            if(count($arrayMensajes)>0){
                $banderaErrores = true;
            }
            else{
                try{
                    $usuarioDAO = new UsuarioDAO();

                    $auxiliarAcademicoDAO = new AuxiliarAcademicoDAO();
                    $auxiliarAcademicoDAO->insertar($auxiliarAcademico);
                    $usuarioDAO->insertar($usuarioAuxiliarAcademico);
                    $banderaErrores = false;
                    
                }
                catch(Exception $e){
                    $arrayMensajes[]=$e->getMessage();
                    $banderaErrores = true;
                }
            }

            if(!$banderaErrores){
                echo "<p> Auxiliar académico registrado satisfactoriamente </p>";
            }
            else{
                foreach($arrayMensajes as $mensaje){
                    echo "<p>".$mensaje."</p>";
                }
            }
        }
        require_once('plantillas/footer.php');
    ?>
</body>
</html>