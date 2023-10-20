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
                }
            ?> </h3>
            <h3> <?php echo $miembroDAO->buscarNombreCompletoPorDNI($_SESSION['dni']); ?> </h3>
            <h3> <?php echo $usuarioDAO->buscarCorreoPorDNI($_SESSION['dni']); ?> </h3>
            <br><br>
            <h2> <?php 
                switch($_SESSION['rol']){
                    case 3:
                        echo 'Generar reporte de calificaciones:';
                        break;
                }
            ?></h2>
            <?php if($_SESSION['rol']==3){ ?>
            <form method="post" action="">
                <input type="submit" name="boton_1" id="boton_1" value="Generar reporte Excel" dir="execPHP/generarRegistroExcel.php" />
                <input type="submit" name="boton_2" id="boton_2" value="Generar reporte PDF" dir="execPHP/generarReportePDF.php" /> <br>
                <input type="submit" name="boton_3" id="boton_3" value="Generar reporte Gráfico" dir="generarReporteGrafico.php" />
                <input type="hidden" name="dni" value="<?php echo $_SESSION['dni']; ?>">
                <input type="hidden" name="idCurso" value="<?php echo $_GET['id']; ?>">
                <input type="hidden" name="salonClases" value="<?php echo $_GET['salonClases']; ?>">
                <input type="hidden" name="bimestre" value="<?php echo $_GET['bimestre']; ?>">
            </form>
            <?php } ?>
            <script>
                $(document).ready(function(){ 
                    $("input[type=submit]").click(function(e) {
                        e.preventDefault();
                        var accion = $(this).attr('dir'),
                            $form = $(this).closest('form');
                        if(typeof accion !== 'undefined'){
                            $form.attr('action', accion);
                        }
                        $form.submit();
                    });
                });
            </script>
            <br><br>
        </div>
    </section>
    <?php require_once('plantillas/footer.php'); ?>
</body>
</html>