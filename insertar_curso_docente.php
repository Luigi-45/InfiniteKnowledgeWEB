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
            <h4> Gestionar asignaciones de curso para docente: </h4>
            <br>
            <form name="gestionarAsignaciones" id="gestionarAsignaciones" method="post">
                <br><br>
                <label for="">Docente:</label>
                <input type="hidden"  name="idDocente" id="idDocente">
                <input type="hidden"  name="idCurso" id="idCurso">
                <input name="nombreDocente" type="text" id="nombreDocente" readonly> 
                <button type="button" id="buscarDocente">  Buscar docente  </button>
                <br><br>
                <label for="">Curso:</label>
                <select name="curso" id="curso">
                    <?php
                        foreach($cursosListados as $curso){
                    ?>
                    <option value="<?php echo $curso->getCursoId(); ?>" <?php
                        if(!empty($_REQUEST["idCurso"])){
                    ?> selected <?php } ?>
                    > <?php echo $curso->getNombre(); ?> </option>
                    <?php
                        }
                    ?>
                </select>
                <br><br>
                <button type="submit" value="1" name="accion"> Insertar </button> <br><br>
                <button type="button" id="buscarAsignacion">  Buscar asignación  </button> <br><br>
                <button type="submit" value="2" name="accion"> Modificar </button> <button type="submit" value="3" name="accion"> Eliminar </button> 
            </form>

            <form id="buscarDocenteForm" runat="server">
                <div id="dialog">
                    Docente: 
                    <br><input  class="form-control" type="text" name="docente" id="docente" autocomplete="off"  size="50">
                    <br><br>
                    <div id="resultado">
                    </div>
                </div>
            </form>

            <form id="buscarAsignacion" runat="server">
                <div id="dialog2">
                    Asignación: 
                    <br><input  class="form-control" type="text" name="docenteNombre" id="docenteNombre" autocomplete="off"  size="50">
                    <br><br>
                    <div id="resultado2">
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
                            'Buscar docente': buscarDocente,
                            'Cancel': function () {
                                dialogDiv.dialog('close');
                                clearInputFields();
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
                                    $("#resultado").html(response);
                                }
                        });
                    } 

                    function clearInputFields() {               
                        $("#resultado").html('');
                    }

                    $('#buscarDocente').click(function () {
                        dialogDiv.dialog("open");
                    });




                    var dialogDiv2 = $('#dialog2');

                    dialogDiv2.dialog({
                        autoOpen: false,
                        modal: true,
                        height: "auto",
                        width: "auto",
                        buttons: {
                            'Buscar asignación': buscarAsignacion,
                            'Cancel': function () {
                                dialogDiv2.dialog('close');
                                clearInputFields();
                            }
                        }
                    });

                    function buscarAsignacion(){
                        docente = $('#docenteNombre').val();
                        var parametros = {
                            "docente" : docente               
                        };
                        $.ajax({
                                data:  parametros,
                                url:   'execPHP/buscarAsignacionJQuery.php',
                                type:  'post',
                                success:  function (response) {
                                    $("#resultado2").html(response);
                                }
                        });
                    } 

                    function clearInputFields2() {               
                        $("#resultado2").html('');
                    }

                    $('#buscarAsignacion').click(function () {
                        dialogDiv2.dialog("open");
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

                        $('#idDocente').val(docente.miembroId);
                        $('#nombreDocente').val(docente.nombreCompleto); 
                    }
                    });
                }

                function changeIncidentValue2(elem){

                    var docenteId=$(elem).find('td:first').text();          
                    var cursoId=$(elem).find('td:nth-child(3)').text();

                    $.ajax({
                    type:'POST',
                    url:'execPHP/buscarAsignacionPorIdJQuery.php',
                    data:{docenteId:docenteId,cursoId:cursoId},
                    success:function(data){

                        let arrayObjectos = JSON.parse(data);
                       
                        $('#idDocente').val(arrayObjectos[0].miembroId);
                        $('#nombreDocente').val(arrayObjectos[0].nombreCompleto); 
                        $('#idCurso').val(arrayObjectos[1].cursoId);
                        $('#curso option[value="'+arrayObjectos[1].cursoId+'"]').attr("selected",true); 
                    }
                    });
                }

            </script>
            <br>
            <?php
                if($_SERVER["REQUEST_METHOD"]=="POST"){
                    switch($_REQUEST["accion"]){
                        case "1":
                            $cursoDAO->insertarParaDocente($_POST["idDocente"],$_REQUEST["curso"]);
                            echo "<p> El docente se ha registrado en el curso satisfactoriamente </p>";
                            break;
                        case "2":
                            $cursoDAO->actualizarParaDocente($_POST["idDocente"],$_POST["idCurso"],$_REQUEST["curso"]);
                            echo "<p> Se ha modificado al docente en el curso seleccionado satisfactoriamente </p>";
                            break;
                        case "3":
                            $cursoDAO->eliminarParaDocente($_POST["idDocente"],$_POST["idCurso"]);
                            echo "<p> Se ha eliminado al docente en el curso seleccionado satisfactoriamente </p>";
                            break;
                    }
                }
            ?>
        </div>
    </section>
    <?php require_once('plantillas/footer.php'); ?>
</body>
</html>