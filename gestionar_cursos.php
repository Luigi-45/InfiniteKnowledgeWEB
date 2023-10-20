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
        <script src="js/busqueda.js"></script>
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
                <h1> Gestionar cursos: </h1>
                <form id="formulario" name="formulario">
                <label for='buscarNombre'> Ingresar nombre: </label> <input type='text' name = 'buscarNombre' id = 'buscarNombre' autocomplete='off' maxlength="45" onKeypress="if (!(event.keyCode < 45 || event.keyCode > 57)) event.returnValue = false;">
                <button type='button' onclick='buscarCurso()'> Buscar </button> </form> 
                </form>
                <div id='subresultado'> 
                </div>
                <button type="button"> <a href="insertar_curso_director_academico.php"> Insertar </a> </button>
            </div>
        </section>
        <?php require_once('plantillas/footer.php'); ?>
    </body>
</html>