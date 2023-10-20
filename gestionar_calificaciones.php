<?php require_once('plantillas/head.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/DocenteDAO.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/EstudianteDAO.php');
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
            <h2> <?php 
                switch($_SESSION['rol']){
                    case 3:
                        echo 'Gestión de calificaciones:';
                        break;
                    case 4:
                        echo 'Registro de calificaciones';
                        break;
                }
            ?></h2>
            <form method="post">
            <table class="modeloTabla">
                <thead>
                    <tr>
                        <th>  Estudiante  </th>
                        <th>  Docente  </th>
                        <th>  Curso  </th>
                        <th>  Salón  </th>
                        <?php if($_SESSION["rol"]==4){?>
                        <th>  Bimestre </th>
                        <?php } ?>
                        <th>  Calificación 1  </th>
                        <th>  Calificación 2  </th>
                        <th>  Calificación 3  </th>
                        <th>  Calificación 4  </th>
                        <th>  Promedio Final  </th>
                        <th>  Estado  </th>
                        <th>  Fecha de emisión  </th>
                    </tr>
                </thead>
                <?php
                    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DTO/RegistroCalificaciones.php');
                    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/RegistroCalificacionesDAO.php');
                    $registroCalificacionesDAO = new RegistroCalificacionesDAO();

                    
                    if($_SESSION['rol']==3){
                        $registros = $registroCalificacionesDAO->buscarParaDocente($_SESSION['dni'],$_GET['id'],$_GET['salonClases'],strval($_GET['bimestre']));
                    }
                    else{
                        $registros = $registroCalificacionesDAO->buscarPorDNIEstudiante3($_SESSION['dni'],$_GET['id']);
                    }

                    foreach($registros as $registro){
                ?>
                <tr>
                    <td> <?php echo $registro[0]->getNombreCompleto() ?> </td>
                    <td> <?php echo $registro[1]->getNombreCompleto() ?> </td>
                    <td> <?php echo $registro[2]->getNombre() ?> </td>
                    <td> <?php echo $registro[3]->getSalonClases() ?> </td>
                    <?php
                        if($_SESSION["rol"]==4){
                    ?>
                    <td> <?php echo $registro[3]->getBimestre(); ?>
                    <?php
                        }
                    ?>
                    <td> <input type="text" name="calificaciones[]" value="<?php
                    if($registro[3]->getCalif1()==NULL){
                        echo 0;
                    }else{
                        echo $registro[3]->getCalif1(); 
                    } ?>" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;">
                    </td>
                    <td> <input type="text" name="calificaciones[]" value="<?php
                    if($registro[3]->getCalif2()==NULL){
                        echo 0;
                    }else{
                        echo $registro[3]->getCalif2(); 
                    } ?>" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;">
                    </td>
                    <td> <input type="text" name="calificaciones[]" value="<?php
                    if($registro[3]->getCalif3()==NULL){
                        echo 0;
                    }else{
                        echo $registro[3]->getCalif3(); 
                    } ?>" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;">
                    </td>
                    <td> <input type="text" name="calificaciones[]" value="<?php
                    if($registro[3]->getCalif4()==NULL){
                        echo 0;
                    }else{
                        echo $registro[3]->getCalif4(); 
                    } ?>" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;">
                    </td>
                    <td> <?php echo $registro[3]->getPromedio() ?> </td>
                    <td> <?php echo $registro[3]->getEstadoAprobacion() ?> </td>
                    <td> <?php echo $registro[3]->getFechaEmision() ?> </td>
                </tr>
                <?php } ?>
            </table>
            <br>
            <?php if($_SESSION['rol']==3){ ?>
                <input type="hidden" name="idCurso" value="<?php echo $_GET['id']; ?>" >
                <input type="hidden" name="saloNClases" value="<?php echo $_GET['salonClases']; ?>" >
                <input type="hidden" name="biMestre" value="<?php echo $_GET['bimestre']; ?>" >
                <button type="submit"> Guardar </button>
            </form>
            <button type="button"> <a href="<?php echo "generar_reporte_calificacion.php?id=".$_GET['id']."&salonClases=".$_GET['salonClases']."&bimestre=".$_GET["bimestre"]; ?>"> Generar Reporte </a> </button>
            <?php }
            if($_SERVER["REQUEST_METHOD"]=="POST"){
                $registros = $registroCalificacionesDAO->buscarParaDocente($_SESSION['dni'],$_GET['id'],$_GET['salonClases'],strval($_GET['bimestre']));
                $registrosCalificaciones = array();
                foreach($registros as $i){
                    $registrosCalificaciones[] = $i[3];
                }

                $calificaciones = array();
                foreach($_POST['calificaciones'] as $key => $value){
                    $calificaciones[]=$value;
                }

                $contador = 0;
                $actualizar = true;
                $arrayErrores = array();
                foreach($registrosCalificaciones as $i){
                    $i->setCalif1($calificaciones[$contador]);
                    $i->setCalif2($calificaciones[$contador+1]);
                    $i->setCalif3($calificaciones[$contador+2]);
                    $i->setCalif4($calificaciones[$contador+3]);
                    
                    try{
                        $i->setPromedio(($i->getCalif1()+$i->getCalif2()+$i->getCalif3()+$i->getCalif4())/4);
                    }
                    catch(TypeError $e){
                        
                    }

                    if($i->getPromedio()<11){
                        $i->setEstadoAprobacion("Desaprobado");
                    }
                    else if($i->getPromedio()>17){
                        $i->setEstadoAprobacion("Aprobado con mérito");
                    }
                    else{
                        $i->setEstadoAprobacion("Aprobado");
                    }

                    $arrayErrores = $i->validarCampos();
                    if(count($arrayErrores)>0){
                        $actualizar = false;
                        break;
                    }

                    $contador+=4;
                }

                if($actualizar){
                    $registroCalificacionesDAO->actualizarCompleto2($registrosCalificaciones);
                    echo "<script> window.location='gestionar_calificaciones.php?id=".$_POST['idCurso']."&salonClases=".$_POST['saloNClases']."&bimestre=".$_POST['biMestre']."'</script>";
                }
                else{
                    foreach($arrayErrores as $j){
                        echo "<p>".$j."</p>";
                    }
                }

            }
            ?>
            <br><br>
        </div>
    </section>
    <?php require_once('plantillas/footer.php'); ?>
</body>
</html>