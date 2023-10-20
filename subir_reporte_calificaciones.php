<?php require_once('plantillas/head.php'); 
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/UsuarioDAO.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/DocenteDAO.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DTO/Docente.php');

    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DTO/AuxiliarAcademico.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/AuxiliarAcademicoDAO.php');

    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DTO/Curso.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/CursoDAO.php');

    $cursoDAO = new CursoDAO(); $cursosListados = $cursoDAO->listar();
    
    if((empty($_SESSION['dni']) && empty($_SESSION['rol'])) || ($_SESSION['rol']!=2)){
        header("Location:index.php");
        exit;
    }

?>
<body>
    <?php require_once('plantillas/nav.php'); ?>
    <section>
        <div class="container">
            <img src="img/logo.png" alt="">
            <h3> Auxiliar Académico: </h3>
            <?php $auxiliarAcademicoDAO = new AuxiliarAcademicoDAO(); $usuarioDAO = new UsuarioDAO(); ?>
            <h3> <?php echo $auxiliarAcademicoDAO->buscarNombreCompletoPorDNI($_SESSION['dni']); ?> </h3>
            <h3> <?php echo $usuarioDAO->buscarCorreoPorDNI($_SESSION['dni']); ?> </h3>
            <br>
            <form method="post" enctype="multipart/form-data">
                <h2>Seleccionar reporte de calificaciones:</h2>
                <br>
                <input type="file" name="file" id="file">
                <br> <br>
                <button type="submit"> Enviar </button>
            </form>
            <?php require_once('execPHP/subirReportes.php'); ?>
            <br>
        </div>
    </section>
    <?php require_once('plantillas/footer.php'); ?>
</body>