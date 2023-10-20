<?php

    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/Validator/TestInput.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DTO/PersonalyEstudiante.php');

    class Docente extends PersonalyEstudiante{

        //------------------Atributos exclusivos de Docente-----------------------
        private $gradoAcademico;
        private $especialidadAcademica;
        //-----------------------------------------------------

        //------------------Constructor-----------------------
        public function __construct(){
            $this->setTipoMiembro("docente");
        }
        //-----------------------------------------------------

        //------------------Construir Objeto-----------------------
        public function construirObjeto($miembroId,$dni,$nombre,$apellidoPaterno,
        $apellidoMaterno,$fechaNacimiento,$genero,$numeroTelefonico,$gradoAcademico,
        $especialidadAcademica){
            parent::construirObjetoMiembro($miembroId,$dni,$nombre,$apellidoPaterno,$apellidoMaterno,$fechaNacimiento,$genero,$numeroTelefonico);
            $this->setGradoAcademico($gradoAcademico);
            $this->setEspecialidadAcademica($especialidadAcademica);
        }
        //-----------------------------------------------------
        
        //------------------Validar campos en común entre los miembros-----------------------
        public function validarCampos(){
            $arrayMensajes = parent::validarCampos();

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

            //------------------Validar campo del Especialidad Académica-----------------------
            if(!empty($this->getEspecialidadAcademica())){
                $this->setEspecialidadAcademica(TestInput::test_input($this->getEspecialidadAcademica()));
                if(is_numeric($this->getEspecialidadAcademica())){
                    $arrayMensajes[] = "La especialidad académica del ".$this->getTipoMiembro()." ingresado posee un formato no adecuado";
                }
                if(strlen($this->getEspecialidadAcademica())>40){
                    $arrayMensajes[] = "La especialidad académico del ".$this->getTipoMiembro()." ingresado excede del límite de caracteres establecido (40 caracteres)";
                }
            }
            else{
                $arrayMensajes[] = "La especialidad académica del ".$this->getTipoMiembro()." no ha sido ingresado";
            }
            //-----------------------------------------------------

            return $arrayMensajes;
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

        //------------------Getter y Setter de la Especialidad Académica-----------------------
        public function getEspecialidadAcademica()
        {
                return $this->especialidadAcademica;
        }
        //-----------------------------------------------------

        //-----------------------------------------------------
        public function setEspecialidadAcademica($especialidadAcademica)
        {
                $this->especialidadAcademica = $especialidadAcademica;

                return $this;
        }
        //-----------------------------------------------------

    }
?>