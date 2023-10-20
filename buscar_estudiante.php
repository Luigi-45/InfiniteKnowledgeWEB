<?php require_once('plantillas/head.php'); 
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/AuxiliarAcademicoDAO.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/UsuarioDAO.php');
    
    if((empty($_SESSION['dni']) && empty($_SESSION['rol'])) ||  ($_SESSION["rol"]!=2)){
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
            <h2>Buscar estudiantes</h2>
            <br><br>
            <form method="post">
                <label for=""> Buscar estudiante: </label>
                <input type="text" name="nombreCompletoIngresado" required maxlength="120" onKeypress="if (!(event.keyCode < 45 || event.keyCode > 57)) event.returnValue = false;"> 
                <button type="submit"> Buscar </button>
                <?php
                    if($_SERVER["REQUEST_METHOD"]=="POST"){
                        header("Location:gestionar_estudiantes.php?nombreCompleto=".$_POST["nombreCompletoIngresado"]);
                    }
                ?>
            </form> 
            <?php 
                if($_SESSION['rol']==2){
            ?>
            <button type="button"> <a href="registrar_estudiante.php"> Insertar </a> </button>
            <?php } ?>
        </div>
    </section>
    <?php require_once('plantillas/footer.php'); ?>
</body>
</html>