<?php

    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/Validator/TestInput.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/Validator/ValidatorAtributosGenerales.php');

    class Registro{

        //------------------Atributos en común entre los registros estudiantiles-----------------------
        public $docenteId;
        public $estudianteId;
        public $cursoId;
        public $salonClases;
        public $fechaEmision;

        public $docente;
        public $estudiante;
        public $curso;
        //-----------------------------------------------------

        //------------------Constructor vacío-----------------------
        public function __construct(){

        }
        //-----------------------------------------------------

        //------------------Construir Objeto-----------------------
        public function construirObjetoRegistro($docenteId,$estudianteId,$cursoId,$salonClases,$fechaEmision){
            $this->docenteId = $docenteId;
            $this->estudianteId = $estudianteId;
            $this->cursoId = $cursoId;
            $this->salonClases = $salonClases;
            $this->fechaEmision = $fechaEmision;
        }
        //-----------------------------------------------------

        //------------------Validar campos en común entre los registros estudiantiles-----------------------
        public function validarCampos(){

            $arrayMensajes = array();

            //------------------Validar campo del Id del Docente-----------------------
            if(!empty($this->getDocenteId())){
                $this->setDocenteId(TestInput::test_input($this->getDocenteId()));
                if(!ValidatorAtributosGenerales::isEntidadId($this->getDocenteId())){
                    $arrayMensajes[] = "El docente ingresado posee un formato no adecuado";
                }
            }
            else{
                $arrayMensajes[] = "El docente no ha sido ingresado";
            }
            //-----------------------------------------------------

            //------------------Validar campo del Id del Estudiante-----------------------
            if(!empty($this->getEstudianteId())){
                $this->setEstudianteId(TestInput::test_input($this->getEstudianteId()));
                if(!ValidatorAtributosGenerales::isEntidadId($this->getEstudianteId())){
                    $arrayMensajes[] = "El estudiante ingresado posee un formato no adecuado";
                }
            }
            else{
                $arrayMensajes[] = "El estudiante no ha sido ingresado";
            }
            //-----------------------------------------------------

            //------------------Validar campo del Id del Curso-----------------------
            if(!empty($this->getCursoId())){
                $this->setCursoId(TestInput::test_input($this->getCursoId()));
                if(!ValidatorAtributosGenerales::isEntidadId($this->getCursoId())){
                    $arrayMensajes[] = "El curso ingresado posee un formato no adecuado";
                }
            }
            else{
                $arrayMensajes[] = "El curso no ha sido ingresado";
            }
            //-----------------------------------------------------

            //------------------Validar campo del Salón de Clases-----------------------
            if(!empty($this->getSalonClases())){
                if(is_numeric($this->getSalonClases())){
                    $arrayMensajes[] = "El salón de clases posee un formato no adecuado";
                }
                if(strlen($this->getSalonClases())>2){
                    $arrayMensajes[] = "El salón de clases excede el límite de caracteres establecido (2 caracteres)";
                }
            }
            else{
                $arrayMensajes[] = "El salón de clases no ha sido ingresado";
            }

            $this->setFechaEmision(TestInput::test_input($this->getFechaEmision()));

            return $arrayMensajes;
        }
        //-----------------------------------------------------

        //------------------Getter y Setter del Id del Docente-----------------------
        public function getDocenteId()
        {
                return $this->docenteId;
        }
        //-----------------------------------------------------

        //-----------------------------------------------------
        public function setDocenteId($docenteId)
        {
                $this->docenteId = $docenteId;

                return $this;
        }
        //-----------------------------------------------------

        //------------------Getter y Setter del Id del Estudiante-----------------------
        public function getEstudianteId()
        {
                return $this->estudianteId;
        }
        //-----------------------------------------------------

        //-----------------------------------------------------
        public function setEstudianteId($estudianteId)
        {
                $this->estudianteId = $estudianteId;

                return $this;
        }
        //-----------------------------------------------------

        //------------------Getter y Setter del Id del Curso-----------------------
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

        //------------------Getter y Setter del Salón de Clases-----------------------
        public function getSalonClases()
        {
                return $this->salonClases;
        }
        //-----------------------------------------------------

        //-----------------------------------------------------
        public function setSalonClases($salonClases)
        {
                $this->salonClases = $salonClases;

                return $this;
        }
        //-----------------------------------------------------

        //------------------Getter y Setter de la Fecha de Emisión-----------------------
        public function getFechaEmision()
        {
                return $this->fechaEmision;
        }
        //-----------------------------------------------------

        //-----------------------------------------------------
        public function setFechaEmision($fechaEmision)
        {
                $this->fechaEmision = $fechaEmision;

                return $this;
        }
        //-----------------------------------------------------

        public function getDocente()
        {
                return $this->docente;
        }
        
        public function setDocente($docente)
        {
                $this->docente = $docente;

                return $this;
        }

        public function getEstudiante()
        {
                return $this->estudiante;
        }

        public function setEstudiante($estudiante)
        {
                $this->estudiante = $estudiante;

                return $this;
        }

        public function getCurso()
        {
                return $this->curso;
        }

        public function setCurso($curso)
        {
                $this->curso = $curso;

                return $this;
        }
    }

?>  