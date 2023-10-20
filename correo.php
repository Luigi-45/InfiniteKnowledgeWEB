<?php require_once('plantillas/head.php'); 
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/DirectorAcademicoDAO.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/AuxiliarAcademicoDAO.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/DocenteDAO.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/UsuarioDAO.php');

    if((empty($_SESSION['dni']) && empty($_SESSION['rol'])) || ($_SESSION['rol']!=1 && $_SESSION['rol']!=2)){
        header("Location:index.php");
        exit;
    }
?>
<body>
    <?php require_once('plantillas/nav.php'); ?>
    <section>
        <div class="container">
            <img src="img/logo.png" alt="">
            <?php
                switch($_SESSION["rol"]){
                    case 1:
                        $miembroDAO = new DirectorAcademicoDAO();
                        echo "<h3> Director Académico: </h3>";
                        break;
                    case 2:
                        $miembroDAO = new AuxiliarAcademicoDAO();
                        echo "<h3> Auxiliar Académico: </h3>";
                        break;
                }
            ?>
            <?php $usuarioDAO = new UsuarioDAO(); ?>
            <br>
            <h3> <?php 
                switch($_SESSION["rol"]){
                    case 1:
                        echo $miembroDAO->buscarNombreCompleto(); 
                        break;
                    case 2:
                        echo $miembroDAO->buscarNombreCompletoPorDNI($_SESSION['dni']);
                        break;
                }
            ?> </h3>
            <h3> <?php echo $usuarioDAO->buscarCorreoPorDNI($_SESSION['dni']); ?> </h3>
            <br><br>
            <h3> Enviar correo Gmail: </h3>
            <form method="post">
            <?php if($_SESSION["rol"]==1){ ?>
                <button type="submit"> Enviar correo a Auxiliar Académico </button>
            <?php } else{ ?>
                <select name="eleccionCorreo">
                    <option value="1"> Docentes </option>
                    <option value="2"> Director Académico </option>
                </select>
                <button type="submit"> Enviar correo </button>
            <?php } ?>
            </form>
            <?php
                if($_SERVER["REQUEST_METHOD"]=="POST"){
                    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/execPHP/Mail.php');
                    switch($_SESSION["rol"]){
                        case 1:
                            $mail = new Mail($usuarioDAO->buscarCorreoPorDNI($_SESSION['dni']),'jmmjupafjngtpqco');
                            
                            $auxiliarAcademicoDAO = new AuxiliarAcademicoDAO();
                            $listaAuxiliares = $auxiliarAcademicoDAO->listar();

                            $bodyHTML = "<h2> Solicitud de recepción de materiales de clase: ".date('d/m/y')."</h2> 
                            <br> <h3>Estimados auxiliares académicos del COAR Junín, se les comunica que; en el presente día ".date('d/m/y')." se debe recepcionar los materiales de clase y evaluar si su contenido cumple con los estándares de calidad que exige nuestra institución. </h3>
                            <br> <b>Atentamente: <br>".$miembroDAO->buscarNombreCompleto()."<br>Director Académico del COAR Junín</b>";

                            foreach($listaAuxiliares as $i){
                                $mail->enviarCorreo($usuarioDAO->buscarCorreoPorDNI($_SESSION["dni"]),$usuarioDAO->buscarCorreoPorDNI($i->getDni()),$miembroDAO->buscarNombreCompleto(),'Solicitud de recepción de materiales de clase: '.date('d/m/y'),$bodyHTML);
                            }

                            if($mail){
                                echo "<p> El correo Gmail se ha enviado satisfactoriamente </p>"; 
                            }
                            break;
                        case 2:
                            switch($_REQUEST["eleccionCorreo"]){
                                case "1":
                                    $mail = new Mail($usuarioDAO->buscarCorreoPorDNI($_SESSION['dni']),'muizlxycvgntppme');

                                    $docenteDAO = new DocenteDAO();
                                    $listaDocentes = $docenteDAO->listar();

                                    $bodyHTML = "<h2> Solicitud de envío de materiales de clase: ".date('d/m/y')."</h2> 
                                    <br> <h3>Estimados docentes del COAR Junín, se les comunica que; en el presente día ".date('d/m/y')." se debe enviar los materiales de clase para evaluar si su contenido cumple con los estándares de calidad que exige nuestra institución. </h3>
                                    <br> <b>Atentamente: <br>".$miembroDAO->buscarNombreCompletoPorDNI($_SESSION['dni'])."<br>Auxiliar Académico del COAR Junín</b>";

                                    foreach($listaDocentes as $i){
                                        $mail->enviarCorreo($usuarioDAO->buscarCorreoPorDNI($_SESSION["dni"]),$usuarioDAO->buscarCorreoPorDNI($i->getDni()),$miembroDAO->buscarNombreCompletoPorDNI($_SESSION['dni']),'Solicitud de envío de materiales de clase: '.date('d/m/y'),$bodyHTML);
                                    }

                                    if($mail){
                                        echo "<p> El correo Gmail se ha enviado satisfactoriamente </p>"; 
                                    }
                                    break;
                                case "2":
                                    $mail = new Mail($usuarioDAO->buscarCorreoPorDNI($_SESSION['dni']),'muizlxycvgntppme');

                                    $docenteDAO = new DocenteDAO();

                                    $directorAcademicoDAO = new DirectorAcademicoDAO();
                                    $directorAcademico = $directorAcademicoDAO->buscarPorId();
                                    $listaDocentes = $docenteDAO->listar();

                                    $docentes = "";

                                    foreach($listaDocentes as $i){
                                        $docentes.= "<h3>".$i->getNombreCompleto()."</h3> <br>";
                                    }

                                    $bodyHTML = "<h2> Revisión de material de clase: ".date('d/m/y')."</h2> 
                                    <br> <h3>Estimado director académico del COAR Junín, se les comunica que; en el presente día ".date('d/m/y')." los docentes: </h3> <br>".$docentes."<h3>Cumplieron con la entrega de sus materiales de clase. Asimismo, su contenido cumple con los estándares de calidad que exige nuestra institución.</h3>"."<b>Atentamente: <br>".$miembroDAO->buscarNombreCompletoPorDNI($_SESSION['dni'])."<br>Auxiliar Académico del COAR Junín</b>";

                                    $mail->enviarCorreo($usuarioDAO->buscarCorreoPorDNI($_SESSION["dni"]),$usuarioDAO->buscarCorreoPorDNI($directorAcademico->getDni()),$miembroDAO->buscarNombreCompletoPorDNI($_SESSION['dni']),'Revisión de material de clase: '.date('d/m/y'),$bodyHTML);
                                    if($mail){
                                        echo "<p> El correo Gmail se ha enviado satisfactoriamente </p>"; 
                                    }
                                    break;
                            }
                            break;
                    }
                }
            ?>
        </div>
    </section>
    <?php require_once('plantillas/footer.php'); ?>
</body>