<?php require_once('plantillas/head.php'); 
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/AuxiliarAcademicoDAO.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/UsuarioDAO.php');

    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DTO/Estudiante.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/EstudianteDAO.php');

    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DTO/Docente.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/DocenteDAO.php');

    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DTO/Curso.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/CursoDAO.php');

    $estudianteDAO = new EstudianteDAO(); 
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
            <h4> Gestionar asignaciones de registros a estudiantes: </h4>
            <br>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" name="" method="post">
            
                <label for="">Estudiante:</label>
                <input name="estudiante" type="text" value="" readonly autocomplete="off" id="nombreEstudiante"> <button type="button" value="Buscar" id="buscarEstudiante">  Buscar estudiante </button>
                <br><br>
                <label for="">Docente:</label>
                <input name="docente" type="text" value="" readonly autocomplete="off" id="nombreDocente"> <button type="button" value="Buscar" id="buscarDocente">  Buscar docente </button>
                <br><br>
                <label for="">Curso:</label>
                <select name="curso" id="cursos">
                    <?php
                        foreach($cursosListados as $curso){
                    ?>
                    <option value="<?php echo $curso->getCursoId(); ?>"> <?php echo $curso->getNombre(); ?> </option>
                    <?php
                        }
                    ?>
                </select>
                <br><br>
                <label for="">Salón de clases:</label>
                <input name="salonClases" type="text" minlength="2" maxlength="2" autocomplete="off" id="salonClases">
                <br><br>
                <label for="">Fecha de emisión:</label>
                <input name="fechaDeEmision" type="date">
                <br><br>
                <input name="estudianteid" type="hidden" id="estudianteid">
                <input name="docenteId" type="hidden" id="docenteId">
                <button type="submit" name="boton" value="1"> Insertar </button><br>
                <button type="button" name="boton" id="buscarAsignacionEstudiante"> Buscar asignación </button><br>
                <button type="submit" name="boton" value="2"> Modificar </button> <button type="submit" name="boton" value="3"> Eliminar </button>
            </form>
        </div>
    </section>

    <form id="buscarEstudianteForm" runat="server">
        <div id="dialog">
            Estudiante: 
            <br><input  class="form-control" type="text" name="estudiante" id="estudiante" autocomplete="off"  size="50">
            <br><br>
            <div id="resultado">
            </div>
        </div>
    </form>

    <form id="buscarDocenteForm" runat="server">
        <div id="dialog2">
            Docente: 
            <br><input  class="form-control" type="text" name="docente" id="docente" autocomplete="off"  size="50">
            <br><br>
            <div id="resultado2">
            </div>
        </div>
    </form>

    <form id="buscarAsignacionEstudianteForm" runat="server">
        <div id="dialog3">
            Asignación a estudiante: 
            <br><input  class="form-control" type="text" name="estudiante2" id="estudiante2" autocomplete="off"  size="50">
            <br><br>
            <div id="resultado3">
            </div>
        </div>
    </form>

    <script type="text/javascript">

        $(document).ready(function () {

            var dialogDiv = $('#dialog');

            dialogDiv.dialog({
                autoOpen: false,
                modal: true,
                height: "auto",
                width: "auto",
                buttons: {
                    'Buscar estudiante': buscarEstudiante,
                    'Cancel': function () {
                        dialogDiv.dialog('close');
                        clearInputFields();
                    }
                }
            });

            function buscarEstudiante(){
                estudiante = $('#estudiante').val();
                var parametros = {
                    "estudiante" : estudiante               
                };
                $.ajax({
                        data:  parametros,
                        url:   'execPHP/buscarEstudianteJQuery.php',
                        type:  'post',
                        success:  function (response) {
                            $("#resultado").html(response);
                        }
                });
            } 

            function clearInputFields() {               
                $("#resultado").html('');
            }

            $('#buscarEstudiante').click(function () {
                dialogDiv.dialog("open");
            });



            var dialogDiv2 = $('#dialog2');

            dialogDiv2.dialog({
                autoOpen: false,
                modal: true,
                height: "auto",
                width: "auto",
                buttons: {
                    'Buscar docente': buscarDocente,
                    'Cancel': function () {
                        dialogDiv2.dialog('close');
                        clearInputFields2();
                    }
                }
            });

            function buscarDocente(){
                docente = $('#docente').val();
                var parametros = {
                    "docente" : docente               
                };
                $.ajax({
                        data:  parametros,
                        url:   'execPHP/buscarDocenteJQuery.php',
                        type:  'post',
                        success:  function (response) {
                            $("#resultado2").html(response);
                        }
                });
            } 

            function clearInputFields2() {               
                $("#resultado2").html('');
            }

            $('#buscarDocente').click(function () {
                dialogDiv2.dialog("open");
            });


            var dialogDiv3 = $('#dialog3');

            dialogDiv3.dialog({
                autoOpen: false,
                modal: true,
                height: "auto",
                width: "auto",
                buttons: {
                    'Buscar asignación a estudiante': buscarAsignacionEstudiante,
                    'Cancel': function () {
                        dialogDiv3.dialog('close');
                        clearInputFields3();
                    }
                }
            });

            function buscarAsignacionEstudiante(){
                estudiante2 = $('#estudiante2').val();
                var parametros = {
                    "estudiante2" : estudiante2               
                };
                $.ajax({
                        data:  parametros,
                        url:   'execPHP/buscarAsignacionEstudianteJQuery.php',
                        type:  'post',
                        success:  function (response) {
                            $("#resultado3").html(response);
                        }
                });
            } 

            function clearInputFields3() {               
                $("#resultado3").html('');
            }

            $('#buscarAsignacionEstudiante').click(function () {
                dialogDiv3.dialog("open");
            });
        });

        function changeIncidentValue(elem){

            var docenteId=$(elem).find('td:first').text();          


            $.ajax({
            type:'POST',
            url:'execPHP/buscarDocentePorIdJQuery.php',
            data:{docenteId:docenteId},
            success:function(data){
                
                let docente = JSON.parse(data);

                $('#docenteId').val(docente.miembroId);
                $('#nombreDocente').val(docente.nombreCompleto); 
            }
            });
        }

        function changeIncidentValue2(elem){

            var estudianteId=$(elem).find('td:first').text();          

            $.ajax({
            type:'POST',
            url:'execPHP/buscarEstudiantePorIdJQuery.php',
            data:{estudianteId:estudianteId},
            success:function(data){
                
                let estudiante = JSON.parse(data);

                $('#estudianteid').val(estudiante.miembroId);
                $('#nombreEstudiante').val(estudiante.nombreCompleto); 
            }
            });
        }

        function changeIncidentValue3(elem){

            var estudianteId=$(elem).find('td:first').text();
            var docenteId=$(elem).find('td:nth-child(3)').text();          
            var cursoId=$(elem).find('td:nth-child(5)').text();

            $.ajax({
            type:'POST',
            url:'execPHP/buscarAsignacionEstudiantePorIdJQuery.php',
            data:{estudianteId:estudianteId,docenteId:docenteId,cursoId:cursoId},
            success:function(data){
                try{
                    let registro = JSON.parse(data);

                    $('#nombreEstudiante').val(registro.estudiante); 
                    $('#nombreDocente').val(registro.docente); 
                    $('#cursos option[value="'+registro.cursoId+'"]').attr("selected",true); 
                    $('#salonClases').val(registro.salonClases);
                    $('#estudianteid').val(registro.estudianteId);
                    $('#docenteId').val(registro.docenteId);
                }
                catch(ex){
                    alert(ex);
                }
            }
            });
        }
        </script>

    <?php
        if($_SERVER["REQUEST_METHOD"]=="POST"){
            require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DTO/RegistroCalificaciones.php');
            require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/RegistroCalificacionesDAO.php');

            $registroCalificacionesDAO = new RegistroCalificacionesDAO();
            $registroCalificaciones = new RegistroCalificaciones();

            switch($_REQUEST["boton"]){
                case "1":
                    $registroCalificaciones->construirObjeto($_POST["docenteId"],$_POST["estudianteid"],$_REQUEST["curso"],$_POST["salonClases"],NULL,
                    NULL,NULL,NULL,date("d/m/y"),5);

                    $banderaErrores = false;
                    $arrayMensajes = $registroCalificaciones->validarCampos();
            
                    if(count($arrayMensajes)>0){
                        $banderaErrores = true;
                    }
                    else{
                        try{
                            $registroCalificacionesDAO->insertarCompleto($_POST["docenteId"],$_POST["estudianteid"],$_REQUEST["curso"],$_POST["salonClases"]);
                            $banderaErrores = false;
                        }
                        catch(Exception $e){
                            $arrayMensajes[]=$e->getMessage();
                            $banderaErrores = true;
                        }
                    }
            
                    if(!$banderaErrores){
                        echo "<br> <p> Insertó la asignación de registro satisfactoriamente </p>";
                    }
                    else{
                        foreach($arrayMensajes as $mensaje){
                            echo "<p>".$mensaje."</p>";
                        }
                    }
                    break;

                case "2":
                    $registroCalificaciones->construirObjeto($_POST["docenteId"],$_POST["estudianteid"],$_REQUEST["curso"],$_POST["salonClases"],NULL,
                    NULL,NULL,NULL,date("d/m/y"),5);

                    $banderaErrores = false;
                    $arrayMensajes = $registroCalificaciones->validarCampos();
            
                    if(count($arrayMensajes)>0){
                        $banderaErrores = true;
                    }
                    else{
                        try{
                            $registroCalificacionesDAO->actualizarCompleto($_POST["docenteId"],$_POST["estudianteid"],$_REQUEST["curso"],$_POST["salonClases"]);
                            $banderaErrores = false;
                        }
                        catch(Exception $e){
                            $arrayMensajes[]=$e->getMessage();
                            $banderaErrores = true;
                        }
                    }
            
                    if(!$banderaErrores){
                        echo "<br> <p> Modificó la asignación de registro satisfactoriamente </p>";
                    }
                    else{
                        foreach($arrayMensajes as $mensaje){
                            echo "<p>".$mensaje."</p>";
                        }
                    }
                    break;
                case "3":
                    $registroCalificacionesDAO->eliminarCompleto($_POST["docenteId"],$_POST["estudianteid"],$_REQUEST["curso"]);
                    echo "<br> <p> Eliminó la asignación de registro satisfactoriamente </p>";
                    break;
            }
        }
        require_once('plantillas/footer.php'); 
    ?>
</body>
</html>