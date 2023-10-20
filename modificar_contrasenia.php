<?php require_once('plantillas/head.php'); 
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/DirectorAcademicoDAO.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DTO/DirectorAcademico.php');

    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/AuxiliarAcademicoDAO.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DTO/AuxiliarAcademico.php');

    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/DocenteDAO.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DTO/Docente.php');

    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/EstudianteDAO.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DTO/Estudiante.php');

    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DTO/Usuario.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/UsuarioDAO.php');
    
    $usuarioDAO = new UsuarioDAO(); $usuario = $usuarioDAO->buscarPorDNI($_SESSION['dni']);
    if(empty($_SESSION['dni']) && empty($_SESSION['rol'])){
        header("Location:index.php");
        exit;
    }
?>

<body>
    <?php require_once('plantillas/nav.php'); ?>
    <section>
        <div class="container">
            <img src="img/logo.png" alt="">
            <?php 
                switch($_SESSION['rol']){
                    case 1:
                        $miembroDAO = new DirectorAcademicoDAO();
                        $miembro = $miembroDAO->buscarPorId();
                        break;
                    case 2:
                        $miembroDAO = new AuxiliarAcademicoDAO();
                        $miembro = $miembroDAO->buscarPorDNI($_SESSION['dni']);
                        break;
                    case 3:
                        $miembroDAO = new DocenteDAO();
                        $miembro = $miembroDAO->buscarPorDNI($_SESSION['dni']);
                        break;
                    case 4: 
                        $miembroDAO = new EstudianteDAO();
                        $miembro = $miembroDAO->buscarPorDNI($_SESSION['dni']);
                        break;
                }
            ?>
            <h3> <?php echo $miembro->getNombreCompleto(); ?> </h3>
            <h3> <?php echo $usuario->getCorreoElectronico(); ?> </h3>
            <br><br>
            <h2>Cambiar contraseña: </h2>
            <br><br>
            <?php 
                $banderaErrores = false;
                if($_SERVER["REQUEST_METHOD"]=="POST"){
                    if(password_verify(TestInput::test_input($_POST["contraseniaA"]),$usuario->getContrasenia())){
                        $usuario2 = new Usuario();
                        $usuario2->construirObjeto($usuario->getUsuarioId(),$usuario->getDni(),$_POST["correoE"],$_POST["contraseniaN"],$_POST["contraseniaR"],$usuario->getRol());
                        
                        $banderaErrores = false;
                        $arrayMensajes = $usuario2->validarCampos();

                        if(count($arrayMensajes)>0){
                            $banderaErrores = true;
                        }
                        else{
                            try{
                                $usuarioDAO->actualizar($usuario2);
                            }
                            catch(Exception $e){
                                $arrayMensajes[]=$e->getMessage();
                                $banderaErrores = true;
                            }
                        }
                
                        if(!$banderaErrores){
                            header("Location: ver_informacion_personal.php");
                        }
                        else{
                            foreach($arrayMensajes as $mensaje){
                                echo "<p>".$mensaje."</p>";
                            }
                        }
                    }
                    else{
                        echo '<p> Error, la contraseña ingresada no coincide con la contraseña anterior de la cuenta </p>';
                        $banderaErrores = true;
                    }
                }

                if(!$banderaErrores){
            ?>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <label for="">Correo Electronico:</label>
                <input name="correoE" type="text" required value="<?php echo $usuario->getCorreoElectronico(); ?>" readonly>
                <br><br>
                <label for="">Contraseña antigua:</label>
                <input name="contraseniaA" type="password" required>
                <br><br>
                <label for="">Contraseña nueva:</label>
                <input name="contraseniaN" type="password" required>
                <br><br>
                <label for="">Contraseña repetida:</label>
                <input name="contraseniaR" type="password" required>
                <br><br>
                <button type="submit" value="Enviar"> Enviar </button> 
            </form> 
            <?php } ?>
        </div>
    </section>
    <?php require_once('plantillas/footer.php'); ?>
</body>
</html>