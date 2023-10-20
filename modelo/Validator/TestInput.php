<?php
    //Clase que permitr evitar ataques de inyección para la ejecución maliciosa de scripts en la aplicación
    
    class TestInput{

        //------------------Evitar ataques de inyección-----------------------
        public static function test_input($string){
            return htmlspecialchars(stripslashes(trim($string)));
        }
        //-----------------------------------------------------

    }
?>