<?php
    $enlace = $_POST["enlace"];
    $nombreCurso = $_POST["nombreCurso"];
    
    if(file_exists($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/library/phpqrcode/qrlib.php')){
        require_once ($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/library/phpqrcode/qrlib.php');
        $rutaQR = $_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/img/'.$nombreCurso.'QR.png';

        $tamanio = 10;
        $level = "Q";
        $frameSize = 3;

        QRcode::png($enlace,$rutaQR,$level,$tamanio,$frameSize);

        if(file_exists($rutaQR)){
            $error = 0;
            $mensaje = "Código QR, del curso elegido, generado satisfactoriamente";
        }
    }
    else{
        $error=1;
        $mensaje="No existe la libreria";
    }

    $respuesta=[
        "error"=>$error,
        "mensaje"=>$mensaje,
        "datos"=>'img/'.$nombreCurso.'QR.png'
    ];

    echo json_encode($respuesta);
?>