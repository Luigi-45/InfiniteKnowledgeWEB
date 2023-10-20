<?php

    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DTO/Usuario.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/Conexion/Conexion.php');

    class UsuarioDAO{
        public function insertar(Usuario $usuario){
            try{
                
                $conexion = Conexion::getConexion();
                $sql = "CALL sp_usuario_insertar(?,?,?,?)";
                $query = $conexion->prepare($sql);

                $query->bindValue(1,$usuario->getDni());
                $query->bindValue(2,$usuario->getCorreoElectronico());
                $query->bindValue(3,password_hash($usuario->getContrasenia(),PASSWORD_BCRYPT));
                $query->bindValue(4,$usuario->getRol());

                $query->execute();

            }
            
            catch(PDOException $e){
                if(str_contains($e->getMessage(),'idx_usuario_correo_electronico')){
                    throw new Exception("El correo electrónico del usuario ingresado ya existe en el sistema");
                }

                throw $e;
                exit;
            }
        }

        public function actualizar(Usuario $usuario){
            try{
                
                $conexion = Conexion::getConexion();
                $sql = "CALL sp_usuario_actualizar(?,?,?,?)";
                $query = $conexion->prepare($sql);

                $query->bindValue(1,$usuario->getUsuarioId());
                $query->bindValue(2,$usuario->getCorreoElectronico());
                $query->bindValue(3,password_hash($usuario->getContrasenia(),PASSWORD_BCRYPT));
                $query->bindValue(4,$usuario->getRol());

                
                $query->execute();
            }
            
            catch(PDOException $e){
                if(str_contains($e->getMessage(),'idx_usuario_correo_electronico')){
                    throw new Exception("El correo electrónico del usuario ingresado ya existe en el sistema");
                }

            
                throw $e;
                exit;
            }
        }

        public function actualizar2(Usuario $usuario){
            try{
                
                $conexion = Conexion::getConexion();
                $sql = "CALL sp_usuario_actualizar2(?,?,?,?)";
                $query = $conexion->prepare($sql);

                $query->bindValue(1,$usuario->getUsuarioId());
                $query->bindValue(2,$usuario->getCorreoElectronico());
                $query->bindValue(3,$usuario->getContraseniaSV());
                $query->bindValue(4,$usuario->getRol());

                
                $query->execute();
            }
            
            catch(PDOException $e){
                if(str_contains($e->getMessage(),'idx_usuario_correo_electronico')){
                    throw new Exception("El correo electrónico del usuario ingresado ya existe en el sistema");
                }

            
                throw $e;
                exit;
            }
        }

        public function eliminar($usuarioId){
            try{
                
                $conexion = Conexion::getConexion();
                $sql = "CALL sp_usuario_eliminar(?)";
                $query = $conexion->prepare($sql);

                $query->bindValue(1,$usuarioId);
                
                $query->execute();
            }
            
            catch(PDOException $e){
                throw $e;
                exit;
            }
        }

        public function realizarInicioSesion($correoElectronico){
            try{
                
                $conexion = Conexion::getConexion();
                $sql = "CALL sp_usuario_realizar_inicio_de_sesión(?)";
                $query = $conexion->prepare($sql);

                $query->bindValue(1,$correoElectronico);

                $query->setFetchMode(PDO::FETCH_ASSOC);
                $query->execute();

                $usuario = new Usuario();

                while($row = $query->fetch()){
                    $usuario->construirObjeto($row["usuario_id"],$row["dni"],$correoElectronico,$row["contrasenia"],NULL,
                    $row["rol"]);
                }

                return $usuario;

            }
            
            catch(PDOException $e){
                throw $e;
                exit;
            }
        }

        public function contarUsuarioPorRol($rol){
            try{
                
                $conexion = Conexion::getConexion();
                $sql = "CALL sp_usuario_contar_usuarios_por_rol(?)";
                $query = $conexion->prepare($sql);

                $query->bindValue(1,$rol);
                
                $query->setFetchMode(PDO::FETCH_ASSOC);
                $query->execute();

                $conteo = 0;
                while($row = $query->fetch()){
                    $conteo = $row["cantidad"];
                }

                return $conteo;
            }
            
            catch(PDOException $e){
                throw $e;
                exit;
            }
        }

        public function buscarCorreoPorDNI($dni){
            try{
                
                $conexion = Conexion::getConexion();
                $sql = "CALL sp_usuario_buscar_correo_por_dni(?)";
                $query = $conexion->prepare($sql);

                $query->bindValue(1,$dni);
                
                $query->setFetchMode(PDO::FETCH_ASSOC);
                $query->execute();

                $correo = "";

                while($row = $query->fetch()){
                    $correo = $row["correo_electronico"];
                }

                return $correo;
            }
            
            catch(PDOException $e){
                throw $e;
                exit;
            }
        }

        public function buscarRolPorDNI($dni){
            try{
                
                $conexion = Conexion::getConexion();
                $sql = "CALL sp_usuario_buscar_rol_por_dni(?)";
                $query = $conexion->prepare($sql);

                $query->bindValue(1,$dni);
                
                $query->setFetchMode(PDO::FETCH_ASSOC);
                $query->execute();

                $rol = "";

                while($row = $query->fetch()){
                    $rol = $row["rol"];
                }

                return $rol;
            }
            
            catch(PDOException $e){
                throw $e;
                exit;
            }
        }

        public function buscarPorDNI($dni){
            try{
                
                $conexion = Conexion::getConexion();
                $sql = "CALL sp_usuario_buscar_por_dni(?)";
                $query = $conexion->prepare($sql);

                $query->bindValue(1,$dni);
                
                $query->setFetchMode(PDO::FETCH_ASSOC);
                $query->execute();

                $usuario = new Usuario();

                while($row = $query->fetch()){
                    $usuario->construirObjeto($row["usuario_id"],$row["dni"],$row["correo_electronico"],$row["contrasenia"],NULL,
                    $row["rol"]);
                }

                return $usuario;
            }
            
            catch(PDOException $e){
                throw $e;
                exit;
            }
        }

    }
?>
