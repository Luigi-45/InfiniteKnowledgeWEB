<?php require_once('plantillas/head.php'); 
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/DirectorAcademicoDAO.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DTO/DirectorAcademico.php');

    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/AuxiliarAcademicoDAO.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DTO/AuxiliarAcademico.php');

    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/DocenteDAO.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DTO/Docente.php');

    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/EstudianteDAO.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DTO/Estudiante.php');

    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/UsuarioDAO.php');
    
    $usuarioDAO = new UsuarioDAO();

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
            <h3> <?php echo $usuarioDAO->buscarCorreoPorDNI($_SESSION['dni']); ?> </h3>
            <br><br>
            <h2>Ver información personal</h2>
            <br><br>
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
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" >
                <label for="">DNI:</label>
                <input name="dni" type="text" required value="<?php echo $miembro->getDni(); ?>" readonly>
                <br><br>
                <label for="">Nombre:</label>
                <input name="nombre" type="text" value="<?php echo $miembro->getNombre(); ?>" readonly>
                <br><br>
                <label for="">Apellido Paterno:</label>
                <input name="apellidoPaterno" type="text" value="<?php echo $miembro->getApellidoPaterno(); ?>" readonly>
                <br><br>
                <label for="">Apellido Materno:</label>
                <input name="apellidoMaterno" type="text" value="<?php echo $miembro->getApellidoMaterno(); ?>" readonly>
                <br><br>
                <label for="">Género:</label>
                <input name="genero" type="text" value="<?php echo $miembro->getGenero(); ?>" readonly>
                <br><br>
                <label for="">Fecha de Nacimiento:</label>
                <input name="fechaNacimiento" type="date" value="<?php echo $miembro->getFechaNacimiento(); ?>" readonly>
                <br><br>
                <label for="">Número Telefónico:</label>
                <input name="numeroTelefonico" type="text" value="<?php echo $miembro->getNumeroTelefonico(); ?>" readonly>
                <br><br>
                <?php
                    if($_SESSION['rol']==3 || $_SESSION['rol']==2 || $_SESSION['rol']==1){
                ?>
                <label for="">Grado Académico:</label>
                <input name="gradoAcademico" type="text" value="<?php echo $miembro->getGradoAcademico(); ?>" readonly>
                <br><br>
                <?php } if($_SESSION['rol']==3){ ?>
                <label for="">Especialidad Académica:</label>
                <input name="especialidadAcademica" type="text" value="<?php echo $miembro->getEspecialidadAcademica(); ?>" readonly>
                <br><br>
                <?php
                } if($_SESSION['rol']==2){ 
                ?>
                <label for="">Número de docentes a cargo:</label>
                <input name="nDocentes" type="text" value="<?php echo $miembro->getNDocentesACargo(); ?>" readonly>
                <br><br>
                <?php }if($_SESSION['rol']==1){ ?>
                <label for="">Años de labor:</label>
                <input name="aniosLabor" type="text" value="<?php echo $miembro->getAniosLabor(); ?>" readonly>
                <br><br>
                <?php } ?>
            </form> 
            <button type="button"> <a href="modificar_contrasenia.php"> Modificar contraseña </a> </button>
        </div>
    </section>
    <?php require_once('plantillas/footer.php'); ?>
</body>
</html>