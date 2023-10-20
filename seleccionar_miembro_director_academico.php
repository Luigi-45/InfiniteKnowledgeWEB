<?php require_once('plantillas/head.php'); 

    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/DirectorAcademicoDAO.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/AuxiliarAcademicoDAO.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/UsuarioDAO.php');
    
    if((empty($_SESSION['dni']) && empty($_SESSION['rol'])) || ($_SESSION['rol']!=1 && $_SESSION['rol']!=2)){
        header("Location:index.php");
        exit;
    }
?>


<body>
    <?php require_once('plantillas/nav.php'); ?>
        <section id="iniciar-sesion">
            <div class="container">
                <img class="imagen" src="img/logo.png" alt="">
                <br>
                <h3> <?php
                    switch($_SESSION['rol']){
                        case 1:
                            echo 'Director Académico:';
                            break;
                        case 2: 
                            echo 'Auxiliar Académico:';
                            break;
                    }
                ?> </h3>
                <?php switch($_SESSION['rol']){
                    case 1:
                        $miembro = new DirectorAcademicoDAO();
                        break;
                    case 2:
                        $miembro = new AuxiliarAcademicoDAO();
                        break;
                }
                $usuarioDAO = new UsuarioDAO(); ?>
                <br>
                <h3> <?php 
                    switch($_SESSION['rol']){
                        case 1:
                            echo $miembro->buscarNombreCompleto();
                            break;
                        case 2:
                            echo $miembro->buscarNombreCompletoPorDNI($_SESSION['dni']);
                            break;
                    }
                ?> </h3>
                <h3> <?php echo $usuarioDAO->buscarCorreoPorDNI($_SESSION['dni']); ?> </h3>
                <br><br>
                <?php if($_SESSION['rol']==1){ ?>
                <h1> Seleccione el personal: </h1>
                <button type="button"> <a href="gestionar_director_academico.php"> Director Académico </a> </button>
                <button type="button"> <a href="gestionar_auxiliar_academico.php"> Auxiliar Académico </a> </button>
                <?php }else{ ?>
                <h1> Seleccione el personal o estudiante: </h1>
                <button type="button"> <a href="gestionar_docentes.php"> Docente </a> </button>
                <button type="button"> <a href="buscar_estudiante.php"> Estudiante </a> </button>  
                <?php } ?>
            </div>
        </section>
    <?php require_once('plantillas/footer.php'); ?>
    </body>
</html>