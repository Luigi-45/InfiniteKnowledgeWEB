<?php require_once('plantillas/head.php'); 
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/EstudianteDAO.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/DocenteDAO.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/UsuarioDAO.php');
    
    if((empty($_SESSION['dni']) && empty($_SESSION['rol'])) || ($_SESSION['rol']!=3)){
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
                }
            ?> </h3>
            <h3> <?php echo $miembroDAO->buscarNombreCompletoPorDNI($_SESSION['dni']); ?> </h3>
            <h3> <?php echo $usuarioDAO->buscarCorreoPorDNI($_SESSION['dni']); ?> </h3>
            <br><br>
            <h1> <?php switch($_SESSION['rol']){
                case 3:
                    echo 'Gestionar calificaciones';
                    break;

            }?> </h1>
            <br><br>
            <form method="post">
                <h2>Seleccionar salón de clases: </h2>
                <input type="text" required minlength="2" maxlength="2" name="salonClases">
                <input type="hidden" name="cursoId" value="<?php echo $_GET["id"]?>">
                <br>
                <h2>Seleccionar bimestre: </h2>
                <select name="seleccionarBimestre">
                <?php
                    for($i=1;$i<5;$i++){
                ?>
                    <option value="<?php echo $i; ?>"> <?php echo $i; ?> </option>
                <?php }?>
                </select>
                <button type="submit" value="Enviar"> Seleccionar </button>
            </form>
            <?php
                if($_SERVER["REQUEST_METHOD"]=="POST"){
                    header("Location:gestionar_calificaciones.php?id=".$_POST["cursoId"]."&salonClases=".$_POST["salonClases"]."&bimestre=".strval($_REQUEST["seleccionarBimestre"]));
                }
            ?>
        </div>
    </section>
    <?php require_once('plantillas/footer.php'); ?>
</body>
</html>