<?php require_once('plantillas/head.php'); 

    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/DirectorAcademicoDAO.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/UsuarioDAO.php');
    
    if((empty($_SESSION['dni']) && empty($_SESSION['rol'])) || ($_SESSION['rol']!=1)){
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
                <h3> Director Académico: </h3>
                <?php $directorAcadémicoDAO = new DirectorAcademicoDAO(); $usuarioDAO = new UsuarioDAO(); ?>
                <br>
                <h3> <?php echo $directorAcadémicoDAO->buscarNombreCompleto(); ?> </h3>
                <h3> <?php echo $usuarioDAO->buscarCorreoPorDNI($_SESSION['dni']); ?> </h3>
                <br><br>
                <?php
                    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/CursoDAO.php');
                    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DTO/Curso.php');

                    $cursoDAO = new CursoDAO();

                    if($_SERVER["REQUEST_METHOD"]=="POST"){
                        $cursoDAO->eliminar($_POST["idCurso"]);
                        header("Location:gestionar_cursos.php");
                    }
                    else{
                        $curso = $cursoDAO->buscarPorId($_GET["id"]);
                    }
                ?>
                <h1> Eliminar curso: </h1>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" name="registrarEstudiante" method="post">
                <label for="">Nombre:</label>
                <input name="nombreCurso" type="text" value="<?php echo $curso->getNombre(); ?>" readonly>
                <br><br>
                <label for="">Número de horas:</label>
                <input name="nHoras" type="text" value="<?php echo $curso->getNHoras(); ?>" readonly>
                <br><br>
                <label for="">Enfoque:</label>
                <select name="enfoqueCurso" id="">
                    <option value="Ciencias" <?php if($curso->getEnfoqueCurso()=='Ciencias'){ ?> selected <?php }?>>Ciencias</option>
                    <option value="Humanidades" <?php if($curso->getEnfoqueCurso()=='Humanidades'){ ?> selected <?php }?>>Humanidades</option>
                </select>
                <input name="idCurso" type="hidden" value="<?php echo $curso->getCursoId(); ?>">
                <br>
                <button type="submit"> Enviar </button>
            </form>
            </div>
        </section>
        <?php require_once('plantillas/footer.php'); ?>
    </body>
</html>