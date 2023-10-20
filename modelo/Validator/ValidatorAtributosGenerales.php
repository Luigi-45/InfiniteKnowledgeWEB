<?php
    /* Clase que permite validar atributos en común de todas las entidades que
    se presentarán en la aplicación Web
    - Director Académico
    - Auxiliar Académico
    - Docentes
    - Estudiantes
    - Curso
    - Registro de Calificaciones
    - Registro de Asistencias
    */
    
    class ValidatorAtributosGenerales{

        //------------------Validar Id de Entidad Relacionada (Llave foránea)-----------------------
        
        public static function isEntidadId($entidadId){
            $bandera = true;
            if(!is_numeric($entidadId)){
                $bandera = false;
            }
            if($entidadId<1){
                $bandera = false;
            }
            return $bandera;
        }
        //-----------------------------------------------------

        //------------------Validar Valor Numérico Entero Positivo-----------------------

        public static function isValorEnteroPositivo($valorEnteroPositivo){
            $bandera = true;
            if(!is_numeric($valorEnteroPositivo)){
                $bandera = false;
            }
            if($valorEnteroPositivo<0){
                $bandera = false;
            }
            return $bandera;
        }
        //-----------------------------------------------------

    }

?>