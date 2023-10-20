<?php require_once('plantillas/head.php'); 
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/AuxiliarAcademicoDAO.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/UsuarioDAO.php');

    if((empty($_SESSION['dni']) && empty($_SESSION['rol'])) || ($_SESSION["rol"]!=2)){
        header("Location:index.php");
        exit;
    }
?>
<body>
    <?php require_once('plantillas/nav.php'); ?>
    <script src="js/busqueda.js"></script>
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
            <h3> Gestionar docentes: </h3>
            <form id="formulario" name="formulario">
                <label for='buscarNombreC'> Ingresar nombre: </label> <input type='text' name = 'buscarNombreC' id = 'buscarNombreC' autocomplete='off' maxlength="152" onKeypress="if (!(event.keyCode < 45 || event.keyCode > 57)) event.returnValue = false;">
                <button type='button' onclick='buscarDocente()'> Buscar </button> </form> 
                </form>
                <div id='subresultado'> 
                </div>
            <br>
            <button type="button"> <a href="registrar_docente.php"> Insertar </a> </button>
        </div>
    </section>
    <?php require_once('plantillas/footer.php'); ?>
</body>
</html>