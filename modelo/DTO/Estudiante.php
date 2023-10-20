<?php
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DTO/PersonalyEstudiante.php');
    class Estudiante extends PersonalyEstudiante{

        //------------------Constructor-----------------------
        public function __construct(){
            $this->setTipoMiembro("estudiante");
        }
        //-----------------------------------------------------
        
        //------------------Construir Objeto-----------------------
        public function construirObjeto($miembroId,$dni,$nombre,$apellidoPaterno,
        $apellidoMaterno,$fechaNacimiento,$genero,$numeroTelefonico){
            parent::construirObjetoMiembro($miembroId,$dni,$nombre,$apellidoPaterno,$apellidoMaterno,$fechaNacimiento,$genero,$numeroTelefonico);
        }
        //-----------------------------------------------------
    }
?>