<?php require_once('plantillas/head.php'); 

    if(!empty($_SESSION['dni']) && !empty($_SESSION['rol'])){
        header("Location:miembro_principal.php");
        exit;
    }

?>

    <body>
        <?php
            require_once('plantillas/nav.php');

	        /*require_once('modelo/DAO/DirectorAcademicoDAO.php');
            require_once('modelo/DTO/DirectorAcademico.php');
            require_once('modelo/DAO/UsuarioDAO.php');
            require_once('modelo/DTO/Usuario.php');

            $directorAcademicoDAO = new DirectorAcademicoDAO();
            $directorAcademico = new DirectorAcademico();
            $directorAcademico->construirObjeto(0,'71728182','Mauricio','Gonzales','Paco','1998-10-11','Hombre','981234123',1,'Doctor');
            $directorAcademicoDAO->insertar($directorAcademico);
            $usuario2DAO = new UsuarioDAO();
            $usuario2 = new Usuario();
            $usuario2->construirObjeto(0,'71728182','mgonzalespaco@gmail.com','aasd12412ADS_@@@','aasd12412ADS_@@@',1);
            $usuario2DAO->insertar($usuario2);*/
        ?>
        <section id="iniciar-sesion">
        
            <div class="container">
            <img class="imagen" src="img/logo.png" alt="">
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" name="inicioSesion" method="post">
                    <h2>Colegio de Alto Rendimiento</h2>
                    <br><br>
                    <label for="">Correo Electrónico</label>
                    <br><br>
                    <input name="correoElectronico" type="email" required>
                    <br><br>
                    <label for="">Contraseña</label>
                    <br><br>
                    <input name="contrasenia" type="password" required>
                    <br><br>
                    <button type="submit"> Iniciar Sesion  </button>
                    <br><br>
                    <a href="">¿Olvidó la contraseña?</a>
                </form>
            </div>
        </section>
        <?php
            if($_SERVER["REQUEST_METHOD"]=="POST"){
                require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DTO/Usuario.php');
                require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/UsuarioDAO.php');
                require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/Validator/TestInput.php');
                $usuarioDAO = new UsuarioDAO();
                $respuestaInicioSesion = $usuarioDAO->realizarInicioSesion(TestInput::test_input($_POST["correoElectronico"]),TestInput::test_input($_POST["contrasenia"]));
                if($respuestaInicioSesion){
                    if(password_verify(TestInput::test_input($_POST["contrasenia"]),$respuestaInicioSesion->getContrasenia())){
                        $_SESSION["dni"]=$respuestaInicioSesion->getDni();
                        $_SESSION["rol"]=$respuestaInicioSesion->getRol();
                        header("Location:miembro_principal.php");
                    }
                }
            }
            require_once('plantillas/footer.php');
        ?>
    </body>
</html>