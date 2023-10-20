<?php
    session_start();
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/UsuarioDAO.php');
    
    if((empty($_SESSION['dni']) && empty($_SESSION['rol'])) || ($_SESSION['rol']!=3)){
        header("Location:index.php");
        exit;
    }
?>
<?php 
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/RegistroCalificacionesDAO.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/CursoDAO.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/DocenteDAO.php');

    $registroCalificacionesDAO = new RegistroCalificacionesDAO();
    $nValores = $registroCalificacionesDAO->buscarNEstadoAprobacion($_POST["dni"],$_POST["idCurso"],$_POST["bimestre"]);

    $cursoDAO = new CursoDAO();
    $curso = $cursoDAO->buscarPorId($_POST["idCurso"]);

    $docenteDAO = new DocenteDAO();
    $docente = $docenteDAO->buscarPorDNI($_POST["dni"]); 
  ?>
<html>
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/style.css">
  <link rel="icon" href="img/logo.png">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://kit.fontawesome.com/7e5b2d153f.js" crossorigin="anonymous"></script>
  <script defer src="js/nav.js"></script>
  <link rel="stylesheet" href="css/nav.css">

  <title>Infinite Knowledge</title>

  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

      var data = google.visualization.arrayToDataTable([
        ['Estado de aprobación', 'Número'],
        ['Desaprobados',  <?php echo $nValores[0]; ?>],
        ['Aprobados',     <?php echo $nValores[1]; ?>],
        ['Aprobados con mérito', <?php echo $nValores[2]; ?>]
      ]);

      var options = {
        title:  'Estado de aprobación - '+'<?php echo $docente->getNombreCompleto();?>'+' - '+'<?php echo $curso->getNombre()." - ".$_POST["salonClases"]." - ".$_POST["bimestre"];?>'
      };

      var chart = new google.visualization.PieChart(document.getElementById('piechart'));

      chart.draw(data, options);
    }
  </script>

  <?php
    $arrayV = array();
    for($i=1;$i<5;$i++){
      $nValores2 = $registroCalificacionesDAO->buscarNEstadoAprobacion($_POST["dni"],$_POST["idCurso"],strval($i));
      $arrayV[] = $nValores2;
    }
  ?>

  <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart2);

      function drawChart2() {

        var data = google.visualization.arrayToDataTable([
          ['Estado de aprobación', 'Desaprobados','Aprobados','Aprobados con mérito'],
          ["Bimestre 1", <?php echo $arrayV[0][0]; ?>, <?php echo $arrayV[0][1]; ?>, <?php echo $arrayV[0][2]; ?>],
          ["Bimestre 2", <?php echo $arrayV[1][0]; ?>, <?php echo $arrayV[1][1]; ?>, <?php echo $arrayV[1][2]; ?>],
          ["Bimestre 3", <?php echo $arrayV[2][0]; ?>, <?php echo $arrayV[2][1]; ?>, <?php echo $arrayV[2][2]; ?>],
          ["Bimestre 4", <?php echo $arrayV[3][0]; ?>, <?php echo $arrayV[3][1]; ?>, <?php echo $arrayV[3][2]; ?>]
        ]);

        var options = {
          title:  'Estado de aprobación - '+'<?php echo $docente->getNombreCompleto();?>'+' - '+'<?php echo $curso->getNombre()." - ".$_POST["salonClases"];?>'
        };

        var chart2 = new google.visualization.ColumnChart(document.getElementById('barras'));

        chart2.draw(data, options);
      }
    </script>
</head>
<body>
  <?php require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/plantillas/nav.php'); ?>
  <section>
    <div class="container">
            <br><br><br><br>
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
            <br>
            <h2> <?php 
                switch($_SESSION['rol']){
                    case 3:
                        echo 'Reporte Gráfico (Pastel): ';
                        break;
                }
            ?></h2>
      <div id="piechart" style="width: 900px; height: 500px;"></div>
      <?php echo '<h1> Reporte Gráfico (Barras): </h1>' ?>
      <div id="barras" style="width: 900px; height: 500px;"></div>
    </div>
  </section>
  <?php require_once('plantillas/footer.php'); ?>
</body>
</html>