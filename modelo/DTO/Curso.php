<?php

    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/Validator/TestInput.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/Validator/ValidatorAtributosGenerales.php');

    class Curso{
        //------------------Atributos exclusivos de Curso-----------------------
        public $cursoId;
        private $nombre;
        private $nHoras;
        private $enfoqueCurso;
        //-----------------------------------------------------

        //------------------Constructor vacío-----------------------
        public function __construct(){

        }
        //-----------------------------------------------------

        //------------------Construir Objeto-----------------------
        public function construirObjeto($cursoId,$nombre,$nHoras,$enfoqueCurso){
            $this->cursoId = $cursoId;
            $this->nombre = $nombre;
            $this->nHoras = $nHoras;
            $this->enfoqueCurso = $enfoqueCurso;
        }
        //-----------------------------------------------------

        //------------------Validar campos de Curso-----------------------
        public function validarCampos(){

            $arrayMensajes = array();
            
            //------------------Validar campo del Nombre-----------------------
            if(!empty($this->getNombre())){
                $this->setNombre(TestInput::test_input($this->getNombre()));
                if(is_numeric($this->getNombre())){
                    $arrayMensajes[] = "El nombre del Curso ingresado posee un formato no adecuado";
                }
                if(strlen($this->getNombre())>45){
                    $arrayMensajes[] = "El nombre del Curso ingresado excede el límite de caracteres establecido (45 caracteres) ";
                }
            }
            else{
                $arrayMensajes[] = "El nombre del Curso no ha sido ingresado";
            }
            //-----------------------------------------------------
            
            //------------------Validar campo del Número de Horas-----------------------
            if(!empty($this->getNHoras())){
                $this->setNHoras(TestInput::test_input($this->getNHoras()));
                if(!ValidatorAtributosGenerales::isValorEnteroPositivo($this->getNHoras())){
                    $arrayMensajes[] = "El nombre del Curso ingresado posee un formato no adecuado";        
                }
            }
            else{
                $arrayMensajes[] = "El nombre del Curso no ha sido ingresado";  
            }
            //-----------------------------------------------------

            //------------------Validar campo del Enfoque de Curso-----------------------
            if(!empty($this->getEnfoqueCurso())){
                $this->setEnfoqueCurso(TestInput::test_input($this->getEnfoqueCurso()));
                if(is_numeric($this->getEnfoqueCurso())){
                    $arrayMensajes[] = "El enfoque del Curso ingresado posee un formato no adecuado";        
                }
                if(strlen($this->getEnfoqueCurso())>50){
                    $arrayMensajes[] = "El enfoque del Curso ingresado excede el límite de caracteres establecido (50 caracteres) ";
                }
            }
            else{
                $arrayMensajes[] = "El enfoque del Curso no ha sido ingresado";  
            }
            //-----------------------------------------------------

            return $arrayMensajes;
        }

        //------------------Getter y Setter del Id de Curso-----------------------
        public function getCursoId()
        {       
                return $this->cursoId;
        }
        //-----------------------------------------------------

        //-----------------------------------------------------
        public function setCursoId($cursoId)
        {
                $this->cursoId = $cursoId;

                return $this;
        }
        //-----------------------------------------------------

        //------------------Getter y Setter del Nombre de Curso-----------------------
        public function getNombre()
        {
                return $this->nombre;
        }
        //-----------------------------------------------------

        //-----------------------------------------------------
        public function setNombre($nombre)
        {
                $this->nombre = $nombre;

                return $this;
        }
        //-----------------------------------------------------

        //------------------Getter y Setter del Número de Horas-----------------------
        public function getNHoras()
        {
                return $this->nHoras;
        }
        //-----------------------------------------------------

        //-----------------------------------------------------
        public function setNHoras($nHoras)
        {
                $this->nHoras = $nHoras;

                return $this;
        }
        //-----------------------------------------------------

        //------------------Getter y Setter del Enfoque de Curso-----------------------
        
        public function getEnfoqueCurso()
        {
                return $this->enfoqueCurso;
        }
        //-----------------------------------------------------

        //-----------------------------------------------------
        public function setEnfoqueCurso($enfoqueCurso)
        {
                $this->enfoqueCurso = $enfoqueCurso;

                return $this;
        }
        //-----------------------------------------------------
    }
?>