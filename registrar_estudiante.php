<?php require_once('plantillas/head.php'); 
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/AuxiliarAcademicoDAO.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/UsuarioDAO.php');
    
    if((empty($_SESSION['dni']) && empty($_SESSION['rol'])) ||  ($_SESSION["rol"]!=2)){
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
            <br>
            <h4>Registrar estudiante:</h4>
            <br><br>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" name="registrarEstudiante" method="post">
                <label for="">DNI:</label>
                <input name="dniEstudiante" type="text" required minlength="8" maxlength="8" autocomplete="off" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;">
                <br><br>
                <label for="">Nombre:</label>
                <input name="nombreEstudiante" type="text" required  maxlength="50" autocomplete="off" onKeypress="if (!(event.keyCode < 45 || event.keyCode > 57)) event.returnValue = false;">
                <br><br>
                <label for="">Apellido Paterno:</label>
                <input name="apellidoPaternoEstudiante" type="text" required  maxlength="50" autocomplete="off" onKeypress="if (!(event.keyCode < 45 || event.keyCode > 57)) event.returnValue = false;">
                <br><br>
                <label for="">Apellido Materno:</label>
                <input name="apellidoMaternoEstudiante" type="text" required  maxlength="50" autocomplete="off" onKeypress="if (!(event.keyCode < 45 || event.keyCode > 57)) event.returnValue = false;">
                <br><br>
                <label for="">Fecha de Nacimiento:</label>
                <input name="fechaNacimientoEstudiante" type="date" required>
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
                <label for="">Correo Electrónico:</label>
                <input name="correoElectronico" type="email" required maxlength="100" autocomplete="off">
                <br><br>
                <button type="submit"> Enviar </button>
            </form>
        </div>
    </section>
    <?php
        if($_SERVER["REQUEST_METHOD"]=="POST"){
            require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DTO/Estudiante.php');
            require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/EstudianteDAO.php');

            require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DTO/Usuario.php');
            require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/UsuarioDAO.php');

            $estudiante = new Estudiante();
            $estudiante->construirObjeto(0,$_POST["dniEstudiante"],$_POST["nombreEstudiante"],$_POST["apellidoPaternoEstudiante"],$_POST["apellidoMaternoEstudiante"],
            $_POST["fechaNacimientoEstudiante"],$_REQUEST["genero"],$_POST["numeroTelefonico"]);
            
            $usuarioEstudiante = new Usuario();
            $usuarioEstudiante->construirObjeto(0,$_POST["dniEstudiante"],$_POST["correoElectronico"],$_POST["dniEstudiante"].'aasSAD__@@',$_POST["dniEstudiante"].'aasSAD__@@',4);

            $banderaErrores = false;
            $arrayMensajes = array_merge($estudiante->validarCampos(),$usuarioEstudiante->validarCampos());

            if(count($arrayMensajes)>0){
                $banderaErrores = true;
            }
            else{
                try{
                    $usuarioDAO = new UsuarioDAO();
                    $estudianteDAO = new EstudianteDAO();

                    $estudianteDAO->insertar($estudiante);
                    $usuarioDAO->insertar($usuarioEstudiante);

                    $banderaErrores = false;
                }
                catch(Exception $e){
                    $arrayMensajes[]=$e->getMessage();
                    $banderaErrores = true;
                }
            }

            if(!$banderaErrores){
                echo "<p> Estudiante registrado satisfactoriamente </p>";
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