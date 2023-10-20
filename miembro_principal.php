<?php require_once('plantillas/head.php'); 
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/DirectorAcademicoDAO.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/AuxiliarAcademicoDAO.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/DocenteDAO.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/EstudianteDAO.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/UsuarioDAO.php');
    
    if(empty($_SESSION['dni']) && empty($_SESSION['rol'])){
        header("Location:index.php");
        exit;
    }
?>

    <body>
        <?php require_once('plantillas/nav.php'); ?>
        <section id="iniciar-sesion">
            <div class="container">
                <img class="imagen" src="img/logo.png" alt="">
                <br> <br> 
                <h3> <?php $usuarioDAO = new UsuarioDAO();
                    switch($_SESSION['rol']){
                        case 1:
                            echo 'Director Académico:';
                            $miembroDAO = new DirectorAcademicoDAO();
                            break;
                        case 2:
                            echo 'Auxiliar Académico:';
                            $miembroDAO = new AuxiliarAcademicoDAO();
                            break;
                        case 3:
                            echo 'Docente:';
                            $miembroDAO = new DocenteDAO();
                            break;
                        case 4:
                            echo 'Estudiante:';
                            $miembroDAO = new EstudianteDAO();
                            break;
                    }
                ?></h3>
                <br>
                <h3> <?php if($_SESSION['rol']==1){
                    echo $miembroDAO->buscarNombreCompleto();
                } 
                else{
                    echo $miembroDAO->buscarNombreCompletoPorDNI($_SESSION['dni']);
                } ?> </h3>
                <h3> <?php echo $usuarioDAO->buscarCorreoPorDNI($_SESSION['dni']); ?> </h3>
            </div>
        </section>
        <?php require_once('plantillas/footer.php'); ?>
    </body>
</html>