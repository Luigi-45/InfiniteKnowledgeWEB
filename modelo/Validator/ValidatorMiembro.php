<?php
    /*Clase que permite validar atributos en común de los miembros de la organización:
        - Director Académico
        - Auxiliar Académico
        - Docentes
        - Estudiantes
        
    También permite validar el nombre del curso ingresado.
    */
    
    class ValidatorMiembro{

        //------------------Validar valor numérico fijo (DNI o Número telefónico)-----------------------
        public static function isValorNumericoFijo($valorNumericoFijo){
            $bandera = true;
            if(!is_numeric($dniIngresado)){
                $bandera = false;
            }
            return $bandera;
        }
        //-----------------------------------------------------

        //------------------Validar Nombre o Apellidos-----------------------
        public static function isNombreOApellido($nombreOApellido){
            $bandera = true;
            if(is_numeric($nombreOApellido)){
                $bandera = false;
            }
            return $bandera;
        }
        //-----------------------------------------------------
        
    }
?>