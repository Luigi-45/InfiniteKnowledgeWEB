<?php

    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/Validator/TestInput.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/Validator/ValidatorAtributosGenerales.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DTO/PersonalyEstudiante.php');
    
    class AuxiliarAcademico extends PersonalyEstudiante{

        //------------------Atributos exclusivos de Auxiliar Académico-----------------------
        private $nDocentesACargo;
        private $gradoAcademico;
        //-----------------------------------------------------

        //------------------Constructor-----------------------
        public function __construct(){
            $this->setTipoMiembro("auxiliar académico");
        }
        //-----------------------------------------------------

        //------------------Construir Objeto-----------------------
        public function construirObjeto($miembroId,$dni,$nombre,$apellidoPaterno,
        $apellidoMaterno,$fechaNacimiento,$genero,$numeroTelefonico,$nDocentesACargo,
        $gradoAcademico){
            parent::construirObjetoMiembro($miembroId,$dni,$nombre,$apellidoPaterno,$apellidoMaterno,$fechaNacimiento,$genero,$numeroTelefonico);
            $this->setNDocentesACargo($nDocentesACargo);
            $this->setGradoAcademico($gradoAcademico);
        }
        //-----------------------------------------------------
    
        //------------------Validar campos en común entre los miembros-----------------------
        public function validarCampos(){
            $arrayMensajes = parent::validarCampos();

            //------------------Validar campo del Número de Docentes A Cargo-----------------------
            if(!empty($this->getNDocentesACargo())){
                $this->setNDocentesACargo(TestInput::test_input($this->getNDocentesACargo()));
                if(!ValidatorAtributosGenerales::isValorEnteroPositivo($this->getNDocentesACargo())){
                    $arrayMensajes[] = "El número de docentes a cargo del ".$this->getTipoMiembro()." ingresado posee un formato no adecuado";
                }
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

        //------------------Getter y Setter del Número de Docentes a Cargo-----------------------
        public function getNDocentesACargo()
        {
                return $this->nDocentesACargo;
        }
        //-----------------------------------------------------

        //-----------------------------------------------------
        public function setNDocentesACargo($nDocentesACargo)
        {
                $this->nDocentesACargo = $nDocentesACargo;

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