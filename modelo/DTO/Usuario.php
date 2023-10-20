<?php

    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/Validator/TestInput.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/Validator/ValidatorUsuario.php');

    class Usuario{
        //------------------Atributos exclusivos de Usuario-----------------------
        private $usuarioId;
        private $dni;
        private $correoElectronico;
        private $contrasenia;
        private $contraseniaRepetida;
        private $contraseniaSV;
        private $rol;
        //-----------------------------------------------------

        //------------------Constructor vacío-----------------------
        public function __construct(){

        }
        //-----------------------------------------------------

        //------------------Construir Objeto-----------------------
        public function construirObjeto($usuarioId,$dni,$correoElectronico,$contrasenia,$contraseniaRepetida,$rol){
            $this->usuarioId = $usuarioId;
            $this->dni = $dni;
            $this->correoElectronico = $correoElectronico;
            $this->contrasenia = $contrasenia;
            $this->contraseniaRepetida = $contraseniaRepetida;
            $this->rol = $rol;        
        }
        //-----------------------------------------------------

        public function construirObjeto2($usuarioId,$correoElectronico,$contrasenia,$rol){
            $this->usuarioId = $usuarioId;
            $this->correoElectronico = $correoElectronico;
            $this->contraseniaSV = $contrasenia;
            $this->rol = $rol;        
        }

        //------------------Validar campos en común entre los miembros-----------------------
        public function validarCampos(){

            $arrayMensajes = array();

            //------------------Validar campo del Correo Electrónico-----------------------
            if(!empty($this->getCorreoElectronico())){
                $this->setCorreoElectronico(TestInput::test_input($this->getCorreoElectronico()));
                if(!ValidatorUsuario::isEmail($this->getCorreoElectronico())){
                    $arrayMensajes[] = "El correo electrónico del Usuario ingresado posee un formato no adecuado";        
                }
                if(strlen($this->getCorreoElectronico())>100){
                    $arrayMensajes[] = "El correo electrónico del Usuario ingresado excede del límite de caracteres establecido (100 caracteres)";        
                }
            }
            else{
                $arrayMensajes[] = "El correo electrónico del Usuario no ha sido ingresado"; 
            }
            //-----------------------------------------------------

            //------------------Validar campo de la Contraseña-----------------------
            if(!empty($this->getContrasenia())){
                $this->setContrasenia(TestInput::test_input($this->getContrasenia()));
                if(!ValidatorUsuario::isPassword($this->getContrasenia())){
                    $arrayMensajes[] = "La contraseña del Usuario ingresado posee un formato no adecuado";        
                }
                if(strlen($this->getContrasenia())>50){
                    $arrayMensajes[] = "La contraseña del Usuario ingresado excede del límite de caracteres establecido (50 caracteres)";        
                }
            }
            else{
                $arrayMensajes[] = "La contraseña del Usuario no ha sido ingresado"; 
            }
            //----------------------------------------------------

            //------------------Validar campo de la Contraseña Repetido-----------------------
            if(!empty($this->getContraseniaRepetida())){
                $this->setContraseniaRepetida(TestInput::test_input($this->getContraseniaRepetida()));
                if(!ValidatorUsuario::isPassword($this->getContraseniaRepetida())){
                    $arrayMensajes[] = "La contraseña repetida del Usuario ingresado posee un formato no adecuado";        
                }
                if(strlen($this->getContraseniaRepetida())>50){
                    $arrayMensajes[] = "La contraseña repetida del Usuario ingresado excede del límite de caracteres establecido (50 caracteres)";        
                }
                if($this->getContrasenia()!=$this->getContraseniaRepetida()){
                    $arrayMensajes[] = "Las contraseñas ingresadas no coinciden";
                }
            }
            else{
                $arrayMensajes[] = "La contraseña del Usuario no ha sido ingresado"; 
            }
            //----------------------------------------------------

            //------------------Validar campo del Rol-----------------------
            if(!empty($this->getRol())){
                $this->setRol(TestInput::test_input($this->getRol()));
                if(!ValidatorUsuario::isRol($this->getRol())){
                    $arrayMensajes[] = "El rol del Usuario ingresado posee un formato no adecuado";        
                }
            }
            else{
                $arrayMensajes[] = "El rol del Usuario no ha sido ingresado"; 
            }
            //-----------------------------------------------------

            return $arrayMensajes;
        }

        public function validarCampos2(){

            $arrayMensajes = array();

            //------------------Validar campo del Correo Electrónico-----------------------
            if(!empty($this->getCorreoElectronico())){
                $this->setCorreoElectronico(TestInput::test_input($this->getCorreoElectronico()));
                if(!ValidatorUsuario::isEmail($this->getCorreoElectronico())){
                    $arrayMensajes[] = "El correo electrónico del Usuario ingresado posee un formato no adecuado";        
                }
                if(strlen($this->getCorreoElectronico())>100){
                    $arrayMensajes[] = "El correo electrónico del Usuario ingresado excede del límite de caracteres establecido (100 caracteres)";        
                }
            }
            else{
                $arrayMensajes[] = "El correo electrónico del Usuario no ha sido ingresado"; 
            }
            //-----------------------------------------------------

            //------------------Validar campo del Rol-----------------------
            if(!empty($this->getRol())){
                $this->setRol(TestInput::test_input($this->getRol()));
                if(!ValidatorUsuario::isRol($this->getRol())){
                    $arrayMensajes[] = "El rol del Usuario ingresado posee un formato no adecuado";        
                }
            }
            else{
                $arrayMensajes[] = "El rol del Usuario no ha sido ingresado"; 
            }
            //-----------------------------------------------------

            return $arrayMensajes;
        }
        
        //------------------Getter u Setter del Id de Usuario-----------------------
        public function getUsuarioId()
        {
                return $this->usuarioId;
        }
        //-----------------------------------------------------

        //-----------------------------------------------------
        public function setUsuarioId($usuarioId)
        {
                $this->usuarioId = $usuarioId;

                return $this;
        }
        //-----------------------------------------------------

        //------------------Getter u Setter del DNI del usuario-----------------------
        public function getDni()
        {
                return $this->dni;
        }
        //-----------------------------------------------------

        //-----------------------------------------------------
        public function setDni($dni)
        {
                $this->dni = $dni;

                return $this;
        }
        //-----------------------------------------------------

        //------------------Getter u Setter del Correo Electrónico-----------------------
        public function getCorreoElectronico()
        {
                return $this->correoElectronico;
        }
        //-----------------------------------------------------

        //-----------------------------------------------------
        public function setCorreoElectronico($correoElectronico)
        {
                $this->correoElectronico = $correoElectronico;

                return $this;
        }
        //-----------------------------------------------------

        //------------------Getter u Setter de la Contraseña----------------------
        public function getContrasenia()
        {
                return $this->contrasenia;
        }
        //-----------------------------------------------------

        //-----------------------------------------------------
        public function setContrasenia($contrasenia)
        {
                $this->contrasenia = $contrasenia;

                return $this;
        }
        //-----------------------------------------------------

        //------------------Getter u Setter de la Contraseña Repetida----------------------
        public function getContraseniaRepetida()
        {
                return $this->contraseniaRepetida;
        }
        //-----------------------------------------------------

        //-----------------------------------------------------
        public function setContraseniaRepetida($contraseniaRepetida)
        {
                $this->contraseniaRepetida = $contraseniaRepetida;

                return $this;
        }
        //-----------------------------------------------------

        //------------------Getter u Setter del Rol----------------------
        public function getRol()
        {
                return $this->rol;
        }
        //-----------------------------------------------------

        //-----------------------------------------------------
        public function setRol($rol)
        {
                $this->rol = $rol;

                return $this;
        }
        //-----------------------------------------------------

        public function getContraseniaSV()
        {
                return $this->contraseniaSV;
        }

        public function setContraseniaSV($contraseniaSV)
        {
                $this->contraseniaSV = $contraseniaSV;

                return $this;
        }
    }

?>