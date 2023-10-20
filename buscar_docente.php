<?php require_once('plantillas/head.php'); 
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/AuxiliarAcademicoDAO.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/DocenteDAO.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DTO/Docente.php');
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
            <h2>Buscar docente</h2>
            <br><br>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"  method="post">
                <label for=""> Buscar docente: </label>
                <input type="text" name="nombreCompletoIngresado" required maxlength="120"> 
                <button type="submit"> Buscar </button>
            
            <?php
                if($_SERVER["REQUEST_METHOD"]=="POST"){
                    header("Location:seleccionar_docente.php?nombreCompleto=".$_POST["nombreCompletoIngresado"]);
                }
            ?>
            </form> 
        </div>
    </section>
    <?php require_once('plantillas/footer.php'); ?>
</body>
</html>