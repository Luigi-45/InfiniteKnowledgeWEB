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
                    $banderaErrores = false;

                    if($_SERVER["REQUEST_METHOD"]=="POST"){
                        $cursoIngresado = new Curso();
                        $cursoIngresado->construirObjeto($_POST["idCurso"],$_POST["nombreCurso"],$_POST["nHoras"],$_REQUEST["enfoqueCurso"]);
                                
                        $banderaErrores = false;
                        $arrayMensajes = $cursoIngresado->validarCampos();
                
                        if(count($arrayMensajes)>0){
                            $banderaErrores = true;
                        }
                        else{
                            try{
                                $cursoDAO->actualizar($cursoIngresado);
                                $banderaErrores = false;
                            }
                            catch(Exception $e){
                                $arrayMensajes[]=$e->getMessage();
                                $banderaErrores = true;
                            }
                        }
                
                        if(!$banderaErrores){
                            echo "<p> Curso modificado satisfactoriamente </p>";
                            header("Location: gestionar_cursos.php");
                        }
                        else{
                            foreach($arrayMensajes as $mensaje){
                                echo "<p>".$mensaje."</p>";
                            }
                        }
                    }
                    else{
                        $curso = $cursoDAO->buscarPorId($_GET["id"]);
                    }

                    if(!$banderaErrores){
                ?>
                <h1> Modificar curso: </h1>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" name="registrarEstudiante" method="post">
                <label for="">Nombre:</label>
                <input name="nombreCurso" type="text" value="<?php echo $curso->getNombre(); ?>" required maxlength="45" autocomplete="off" onKeypress="if (!(event.keyCode < 45 || event.keyCode > 57)) event.returnValue = false;">
                <br><br>
                <label for="">Número de horas:</label>
                <input name="nHoras" type="text" value="<?php echo $curso->getNHoras(); ?>" required autocomplete="off" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;">
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
            <?php } ?>
            </div>
        </section>
        <?php require_once('plantillas/footer.php'); ?>
    </body>
</html>