<?php require_once('plantillas/head.php'); 
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/EstudianteDAO.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/DocenteDAO.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/UsuarioDAO.php');
    
    if((empty($_SESSION['dni']) && empty($_SESSION['rol'])) || ($_SESSION['rol']!=4 && $_SESSION['rol']!=3)){
        header("Location:index.php");
        exit;
    }

?>

<body>
    <?php require_once('plantillas/nav.php'); ?>
    <section>
        <div class="container">
            <img src="img/logo.png" alt="">
            <h3> <?php $usuarioDAO = new UsuarioDAO();
                switch($_SESSION['rol']){
                    case 3:
                        echo 'Docente';
                        $miembroDAO = new DocenteDAO();
                        break;
                    case 4:
                        echo 'Estudiante';
                        $miembroDAO = new EstudianteDAO(); 
                        break;
                }
            ?> </h3>
            <h3> <?php echo $miembroDAO->buscarNombreCompletoPorDNI($_SESSION['dni']); ?> </h3>
            <h3> <?php echo $usuarioDAO->buscarCorreoPorDNI($_SESSION['dni']); ?> </h3>
            <br><br>
            <h1> <?php switch($_SESSION['rol']){
                case 3:
                    echo 'Gestionar calificaciones';
                    break;
                case 4:
                    echo 'Ver calificaciones';
                    break;

            }?> </h1>
            <h2>Seleccionar curso</h2>
            <br><br>
            <table class="modeloTabla">
                <thead>
                    <tr>
                        <th>Curso</th>
                    </tr>
                </thead>
                <?php
                
                    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DTO/Curso.php');
                    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/CursoDAO.php');
                    $cursoDAO = new CursoDAO();

                    switch($_SESSION['rol']){
                        case 3:
                            $cursos = $cursoDAO->listarCursosParaDocente($_SESSION['dni']);
                            break;
                        case 4:
                            $cursos = $cursoDAO->listarNombresPorDNIEstudiante2($_SESSION['dni']);
                            break;
                    }

                    foreach($cursos as $curso){
                ?>
                <tr>
                    <?php if($_SESSION['rol']==3){ ?>
                    <td> <a href="<?php echo "seleccion_salon_clases_calificaciones.php?id=".$curso->getCursoId(); ?>"> <?php echo $curso->getNombre(); ?> </a> </td>
                    <?php }else{ ?>
                    <td> <a href="<?php echo "gestionar_calificaciones.php?id=".$curso->getCursoId(); ?>"> <?php echo $curso->getNombre(); ?> </a> </td>
                    <?php } ?>
                </tr>
                <?php } ?>
            </table>
            <br>
            <br><br>
        </div>
    </section>
    <?php require_once('plantillas/footer.php'); ?>
</body>
</html>