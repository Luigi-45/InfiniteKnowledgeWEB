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
            <h4>Eliminar estudiante:</h4>
            <br><br>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" name="  " method="post">
            <?php
            if($_SERVER["REQUEST_METHOD"]=="POST"){
                $estudianteDAO->eliminar($_POST["idEstudiante"]);
                header("Location: buscar_estudiante.php");
            }
            else{
                $estudianteAsignado = $estudianteDAO->buscarPorId($_GET['id']);
                $usuario = $usuarioDAO->buscarPorDNI($estudianteAsignado->getDni()); 
                if(empty($estudianteAsignado->getMiembroId())){
                    $htmlResult .= "<p> *Error, el estudiante buscado no existe </p>";
                }
            }
            ?> 
                <input name="idEstudiante" type="hidden" required value="<?php echo $estudianteAsignado->getMiembroId(); ?>" readonly>
                <label for="">DNI:</label>
                <input name="dniEstudiante" type="text" required value="<?php echo $estudianteAsignado->getDni(); ?>" readonly>
                <br><br>
                <label for="">Nombre:</label>
                <input name="nombreEstudiante" type="text" value="<?php echo $estudianteAsignado->getNombre(); ?>" readonly>
                <br><br>
                <label for="">Apellido Paterno:</label>
                <input name="apellidoPaternoEstudiante" type="text" value="<?php echo $estudianteAsignado->getApellidoPaterno(); ?>" readonly>
                <br><br>
                <label for="">Apellido Materno:</label>
                <input name="apellidoMaternoEstudiante" type="text" value="<?php echo $estudianteAsignado->getApellidoMaterno(); ?>" readonly>
                <br><br>
                <label for="">Fecha de Nacimiento:</label>
                <input name="fechaNacimientoEstudiante" type="date" value="<?php echo $estudianteAsignado->getFechaNacimiento(); ?>" readonly>
                <br><br>
                <label for="">Número Telefónico:</label>
                <input name="numeroTelefonico" type="text" value="<?php echo $estudianteAsignado->getNumeroTelefonico(); ?>" readonly>
                <br><br>
                <label for="">Correo electrónico:</label>
                <input name="correoE" type="text" value = "<?php echo $usuario->getCorreoElectronico(); ?>" readonly>
                <br><br>
                <input name="genero" type="hidden" required value="<?php echo $estudianteAsignado->getGenero(); ?>">
                <button type="submit"> Enviar </button>
            </form>
        </div>
    </section>
    <?php require_once('plantillas/footer.php'); ?>
</body>