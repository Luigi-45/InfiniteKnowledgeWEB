<?php
    /*Clase que permite validar a los usuarios de la organización para
    el registro de cuentas, según rol, y el inicio de sesión en
    la aplicación
    */
    
    class ValidatorUsuario{

        //------------------Validar Correo Electrónico-----------------------
        public static function isEmail($email){
            $bandera = true;
            if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
                $bandera = false;
            }
            return $bandera;
        }
        //-----------------------------------------------------

        //------------------Validar Contraseña-----------------------
        public static function isPassword($password){
            $bandera = true;
            $expresionRegular = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])([A-Za-z\d$@$!%*?&]|[^ ]){8,50}$/';;
            /* Expresión regular que permite verificar que la contraseña tenga entre 8 y 50 caracteres,
               al menos un dígito, al menos una minúscula, al menos una mayúscula, y al menos un caracter no 
               alfanumérico
            */
            if(!preg_match($expresionRegular,$password)){
                $bandera = false;
            }
            return $bandera;
        }
        //-----------------------------------------------------

        //------------------Validar rol-----------------------
        public static function isRol($rol){
            $bandera = true;
            if(!is_numeric($rol)){
                $bandera = false;
            }
            if(($rol<1)||($rol>4)){
                $bandera = false;
            }
            return $bandera;
        }
        //-----------------------------------------------------
    }
?>