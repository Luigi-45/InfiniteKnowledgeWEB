<?php

    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/Validator/TestInput.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/Validator/ValidatorAtributosGenerales.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DTO/PersonalyEstudiante.php');

    class DirectorAcademico extends PersonalyEstudiante{

         //------------------Atributos exclusivos de Director Académico-----------------------
        private $aniosLabor;
        private $gradoAcademico;
        //-----------------------------------------------------

        //------------------Constructor-----------------------
        public function __construct(){
            $this->setTipoMiembro("director académico");
        }
        //-----------------------------------------------------

        //------------------Construir Objeto-----------------------
        public function construirObjeto($miembroId,$dni,$nombre,$apellidoPaterno,
        $apellidoMaterno,$fechaNacimiento,$genero,$numeroTelefonico,$aniosLabor,
        $gradoAcademico){
            parent::construirObjetoMiembro($miembroId,$dni,$nombre,$apellidoPaterno,$apellidoMaterno,$fechaNacimiento,$genero,$numeroTelefonico);
            $this->setAniosLabor($aniosLabor);
            $this->setGradoAcademico($gradoAcademico);
        }
        //-----------------------------------------------------
    
        //------------------Validar campos en común entre los miembros-----------------------
        public function validarCampos(){
            $arrayMensajes = parent::validarCampos();

            //------------------Validar campo de los Años de Labor-----------------------
            if(!empty($this->getAniosLabor())){
                $this->setAniosLabor(TestInput::test_input($this->getAniosLabor()));
                if(!ValidatorAtributosGenerales::isValorEnteroPositivo($this->getAniosLabor())){
                    $arrayMensajes[] = "Los años de labor a cargo del ".$this->getTipoMiembro()." ingresado posee un formato no adecuado";
                }
            }
            else{
                $arrayMensajes[] = "Los años de labor a cargo del ".$this->getTipoMiembro()." no ha sido ingresado";
            }
            //-----------------------------------------------------

            //------------------Validar campo del Grado Académico-----------------------
            if(!empty($this->getGradoAcademico())){
                $this->setGradoAcademico(TestInput::test_input($this->getGradoAcademico()));
                if(is_numeric($this->getGradoAcademico())){
                    $arrayMensajes[] = "El grado académico del ".$this->getTipoMiembro()." ingresado posee un formato no adecuado";
                }
                if(strlen($this->getGradoAcademico())>40){
                    $arrayMensajes[] = "El grado académico del ".$this->getTipoMiembro()." ingresado excede del límite de caracteres establecido (40 caracteres)";
                }
            }
            else{
                $arrayMensajes[] = "El grado académico del ".$this->getTipoMiembro()." no ha sido ingresado";
            }
            //-----------------------------------------------------

            return $arrayMensajes;
        }

        //------------------Getter y Setter de los Años de Labor-----------------------
        public function getAniosLabor()
        {
                return $this->aniosLabor;
        }

        public function setAniosLabor($aniosLabor)
        {
                $this->aniosLabor = $aniosLabor;

                return $this;
        }
        //-----------------------------------------------------

        //------------------Getter y Setter del Grado Académico-----------------------
        public function getGradoAcademico()
        {
                return $this->gradoAcademico;
        }
        //-----------------------------------------------------

        //-----------------------------------------------------
        public function setGradoAcademico($gradoAcademico)
        {
                $this->gradoAcademico = $gradoAcademico;

                return $this;
        }
        //-----------------------------------------------------

    }
?>