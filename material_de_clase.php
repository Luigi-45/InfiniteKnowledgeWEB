<?php require_once('plantillas/head.php'); 
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/EstudianteDAO.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/DocenteDAO.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/UsuarioDAO.php');
    
    if((empty($_SESSION['dni']) && empty($_SESSION['rol'])) || ($_SESSION['rol']!=3 && $_SESSION['rol']!=4)){
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
                        echo 'Docente:';
                        $miembroDAO = new DocenteDAO();
                        break;
                    case 4:
                        echo 'Estudiante:';
                        $miembroDAO = new EstudianteDAO();
                        break;
                }
            ?> </h3>
            <br>
            <h3> <?php echo $miembroDAO->buscarNombreCompletoPorDNI($_SESSION['dni']); ?> </h3>
            <h3> <?php echo $usuarioDAO->buscarCorreoPorDNI($_SESSION['dni']); ?> </h3>
            <br><br>
            <?php if($_SESSION['rol']==4){ ?>   
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
                    
                    if($_SESSION['rol']==3){
                        $cursos = $cursoDAO->listarCursosParaDocente($_SESSION['dni']);
                    }
                    else{
                        $cursos = $cursoDAO->listarNombresPorDNIEstudiante($_SESSION['dni']);
                    }

                    foreach($cursos as $curso){
                ?>
                <tr>
                    <td> <a href="<?php echo "https://www.dropbox.com/home/".$curso->getNombre(); ?>"> <?php echo $curso->getNombre(); ?> </a> </td>
                </tr>
                <?php } ?>
            </table>

            <h2> Generar código QR: </h2>
            <select name="nombreCursos" id="nombreCursos">
                <?php foreach($cursos as $i){?>
                <option value="<?php echo $i->getNombre(); ?>"> <?php echo $i->getNombre(); ?> </option>
                <?php } ?>
            </select>
            <button type="button" id="enviar" onclick="javascript:enviar_datos();"> Generar </button>
            <div id="codigoQR" name="codigoQR">
            </div>

            <script>
                function enviar_datos(){
                    var nombreCurso = $("#nombreCursos option:selected").text();
                    var enlace = "https://www.dropbox.com/home/"+nombreCurso;
                    $.ajax({
                        url: "execPHP/generarCodigoQR.php",
                        type: "POST",
                        data: {nombreCurso:nombreCurso,enlace:enlace},
                        success: function(resp){
                            datos = JSON.parse(resp);
                            alert(datos.mensaje);
                            $("#codigoQR").html("<img src='"+datos.datos+"' width='200' height'200' id='codigoQR'>");
                        }
                    })
                }
            </script>

            <?php }else{ ?>
            <form method="post" enctype="multipart/form-data">
                <h2>Seleccionar material de clase:</h2>
                <br>
                <input type="file" name="file" id="file">
                <br> <br>
                <?php 
                    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/CursoDAO.php');
                    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DTO/Curso.php');

                    $cursoDAO = new CursoDAO(); $cursosListados = $cursoDAO->listarCursosParaDocente($_SESSION["dni"]); 
                ?>
                <h2>Seleccionar el curso:</h2>
                <br>
                <select name="cursos">
                    <?php foreach($cursosListados as $curso){ ?>
                    <option value="<?php echo $curso->getNombre(); ?>"> <?php echo $curso->getNombre(); ?> </option>
                    <?php } ?>
                </select>
                <br> <br>
                <button type="submit"> Enviar </button>
            </form>
            <?php } require_once('execPHP/subirMaterialDeClase.php'); ?>
            <br>
        </div>
    </section>
    <?php require_once('plantillas/footer.php'); ?>
</body>
</html>