<?php require_once('plantillas/head.php'); 
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/UsuarioDAO.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/DocenteDAO.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DTO/Docente.php');

    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DTO/AuxiliarAcademico.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/AuxiliarAcademicoDAO.php');

    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DTO/Curso.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/CursoDAO.php');

    $cursoDAO = new CursoDAO(); 
    
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
            <h2>Registro de docentes en curso</h2>
            <br><br>
            <table class="modeloTabla">
                <thead>
                    <tr>
                        <th> Curso </th>
                        <th> Acciones </th>
                    </tr>
                </thead>
                <?php
                    if($_SERVER["REQUEST_METHOD"]=="GET"){
                        $docenteDAO = new DocenteDAO(); 
                        $docente = $docenteDAO->buscarPorId($_GET['idDoc']);
                        $cursosListados = $cursoDAO->listarCursosParaDocente($docente->getDni());
                        foreach($cursosListados as $curso){
                ?>
                <tr>
                    <td> <?php echo $curso->getNombre(); ?> </td>
                    <td> <a href="<?php echo "insertar_curso_docente.php?id=".$_GET['idDoc']."&idCurso=".$curso->getCursoId()."&option=2"; ?>"> Modificar </a>
                    <br>  <a href="<?php echo "insertar_curso_docente.php?id=".$_GET['idDoc']."&idCurso=".$curso->getCursoId()."&option=3"; ?>"> Eliminar </a> </td>
                </tr>
                <?php } 
                }?>
            </table>
            <br>
            <br><br>
        </div>
    </section>
    <?php require_once('plantillas/footer.php'); ?>
</body>
</html>