<?php

    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/Validator/TestInput.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/Validator/ValidatorRegistro.php');

    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DTO/Registro.php');

    class RegistroCalificaciones extends Registro{

        //------------------Atributos exclusivos del Registro de Calificaciones-----------------------
        public $bimestre;
        public $estadoAprobacion;
        public $calif1;
        public $calif2;
        public $calif3;
        public $calif4;
        public $promedio;
        //-----------------------------------------------------

        //------------------Constructor vacío-----------------------
        public function __construct(){

        }
        //-----------------------------------------------------

        //------------------Construir Objeto-----------------------
        public function construirObjeto($docenteId,$estudianteId,$cursoId,$salonClases,
        $calif1,$calif2,$calif3,$calif4,$fechaEmision,$bimestre){
            parent::construirObjetoRegistro($docenteId,$estudianteId,$cursoId,$salonClases,$fechaEmision);
            $this->bimestre = $bimestre;
            $this->calif1 = $calif1;
            $this->calif2 = $calif2;
            $this->calif3 = $calif3;
            $this->calif4 = $calif4;
        }
        //-----------------------------------------------------

        //------------------Validar campos del Registro de Calificaciones-----------------------
        public function validarCampos(){

            $arrayMensajes = parent::validarCampos();

            if(!empty($this->getBimestre())){
                $this->setBimestre(TestInput::test_input($this->getBimestre()));
                if(strlen($this->getBimestre())!=1){
                    $arrayMensajes[] = "El bimestre ingresado no posee un formato no adecuado";
                }
            }
            else{
                $arrayMensajes[] = "El bimestre no ha sido ingresado";
            }

            //------------------Validar campo de la Primera Calificación-----------------------
            if(!empty($this->getCalif1())){
                $this->setCalif1(TestInput::test_input($this->getCalif1()));
                if(!ValidatorRegistro::isCalificacion($this->getCalif1())){
                    $arrayMensajes[] = "La primera calificación ingresada posee un formato no adecuado";
                }
            }
            //-----------------------------------------------------

            //------------------Validar campo de la Segunda Calificación-----------------------
            if(!empty($this->getCalif2())){
                $this->setCalif2(TestInput::test_input($this->getCalif2()));
                if(!ValidatorRegistro::isCalificacion($this->getCalif2())){
                    $arrayMensajes[] = "La segunda calificación ingresada posee un formato no adecuado";
                }
            }
            //-----------------------------------------------------

            //------------------Validar campo de la Tercera Calificación-----------------------
            if(!empty($this->getCalif3())){
                $this->setCalif3(TestInput::test_input($this->getCalif3()));
                if(!ValidatorRegistro::isCalificacion($this->getCalif3())){
                    $arrayMensajes[] = "La tercera calificación ingresada posee un formato no adecuado";
                }
            }
            //-----------------------------------------------------

            if(!empty($this->getCalif4())){
                $this->setCalif4(TestInput::test_input($this->getCalif4()));
                if(!ValidatorRegistro::isCalificacion($this->getCalif4())){
                    $arrayMensajes[] = "La cuarta calificación ingresada posee un formato no adecuado";
                }
            }

            return $arrayMensajes;
        }
        //-----------------------------------------------------

        public function getBimestre()
        {
                return $this->bimestre;
        }

        public function setBimestre($bimestre)
        {
                $this->bimestre = $bimestre;

                return $this;
        }
        
        //------------------Getter y Setter del Id del Estado de Aprobación-----------------------
        public function getEstadoAprobacion()
        {
                return $this->estadoAprobacion;
        }
        //-----------------------------------------------------
        
        //-----------------------------------------------------
        public function setEstadoAprobacion($estadoAprobacion)
        {
                $this->estadoAprobacion = $estadoAprobacion;

                return $this;
        }
        //-----------------------------------------------------

        //------------------Getter y Setter de la Primera Calificación-----------------------
        public function getCalif1()
        {
                return $this->calif1;
        }
        //-----------------------------------------------------

        //-----------------------------------------------------
        public function setCalif1($calif1)
        {
                $this->calif1 = $calif1;

                return $this;
        }
        //-----------------------------------------------------

        //------------------Getter y Setter de la Segunda Calificación-----------------------
        public function getCalif2()
        {
                return $this->calif2;
        }
        //-----------------------------------------------------

        //-----------------------------------------------------
        public function setCalif2($calif2)
        {
                $this->calif2 = $calif2;

                return $this;
        }
        //-----------------------------------------------------

        //------------------Getter y Setter de la Tercera Calificación-----------------------
        public function getCalif3()
        {
                return $this->calif3;
        }
        //-----------------------------------------------------

        //-----------------------------------------------------
        public function setCalif3($calif3)
        {
                $this->calif3 = $calif3;

                return $this;
        }
        //-----------------------------------------------------

        public function getCalif4()
        {
                return $this->calif4;
        }
        
        public function setCalif4($calif4)
        {
                $this->calif4 = $calif4;

                return $this;
        }

        //------------------Getter y Setter del Promedio-----------------------
        public function getPromedio()
        {
                return $this->promedio;
        }
        //-----------------------------------------------------

        //-----------------------------------------------------
        public function setPromedio($promedio)
        {
                $this->promedio = $promedio;

                return $this;
        }
        //-----------------------------------------------------

    }

?>