<?php
    class Conexion{
        
        public static function getConexion(){

            try{
                $dns = "mysql:host=localhost;dbname=infinite_knowledge;port=3306";
                $user = "root";
                $password = "123456";
                $opt = [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION];
                $conexion = new PDO($dns,$user,$password,$opt);

                return $conexion;
            }
            catch(PDOException $e){
                echo "No se pudo conectar con el servidor MYSQL: ".$e->getMessage();
            }

        }
    
    }
?>  