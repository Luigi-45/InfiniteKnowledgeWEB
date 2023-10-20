<?php

    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DTO/DirectorAcademico.php');

    class DirectorAcademicoDAO{

        public function insertar(DirectorAcademico $directorAcademico){
            try {
                $conexion = Conexion::getConexion();
                $sql = "CALL sp_director_academico_insertar(?,?,?,?,?,?,?,?,?)";
                $query = $conexion->prepare($sql);

                $query->bindValue(1,$directorAcademico->getDni());
                $query->bindValue(2,$directorAcademico->getNombre());
                $query->bindValue(3,$directorAcademico->getApellidoPaterno());
                $query->bindValue(4,$directorAcademico->getApellidoMaterno());
                $query->bindValue(5,$directorAcademico->getFechaNacimiento());
                $query->bindValue(6,$directorAcademico->getAniosLabor());
                $query->bindValue(7,$directorAcademico->getGenero());
                $query->bindValue(8,$directorAcademico->getNumeroTelefonico());
                $query->bindValue(9,$directorAcademico->getGradoAcademico());

                $query->execute();
            } 
            catch (PDOException $e) {
                throw $e;
                exit;
            }
        }

        public function buscarPorId(){
            try{
                    
                $conexion = Conexion::getConexion();
                $sql = "CALL sp_director_academico_buscar_por_id()";
                $query = $conexion->prepare($sql);
                
                $query->setFetchMode(PDO::FETCH_ASSOC);
                $query->execute();

                $directorAcademico = new DirectorAcademico();

                while($row = $query->fetch()){
                    
                    $directorAcademico -> construirObjeto($row["director_academico_id"],$row["dni"],$row["nombre"],$row["apellido_paterno"],
                    $row["apellido_materno"],$row["fecha_nacimiento"],$row["genero"],$row["numero_telefonico"],$row["anios_labor"],
                    $row["grado_academico"]);

                    $directorAcademico->setNombreCompleto($row["nombre_completo"]);

                }

                return $directorAcademico;
            }
            
            catch(PDOException $e){
                throw $e;
                exit;
            }
        }

        public function buscarPorDNI($dni){
            try{
                    
                $conexion = Conexion::getConexion();
                $sql = "CALL sp_director_academico_buscar_por_dni(?)";
                $query = $conexion->prepare($sql);

                $query->bindValue(1,$dni);
                
                $query->setFetchMode(PDO::FETCH_ASSOC);
                $query->execute();

                $directorAcademico = new DirectorAcademico();

                while($row = $query->fetch()){
                    $directorAcademico -> construirObjeto($row["director_academico_id"],$row["dni"],$row["nombre"],$row["apellido_paterno"],
                    $row["apellido_materno"],$row["fecha_nacimiento"],$row["genero"],$row["numero_telefonico"],$row["anios_labor"],
                    $row["grado_academico"]);

                    $directorAcademico->setNombreCompleto($row["nombre_completo"]);
                }

                return $directorAcademico;
            }
            
            catch(PDOException $e){
                throw $e;
                exit;
            }
        }

        public function buscarDatosParaEmail(){
            try{
                
                $conexion = Conexion::getConexion();
                $sql = "CALL sp_director_academico_buscar_datos_para_email()";
                $query = $conexion->prepare($sql);

                $query->setFetchMode(PDO::FETCH_ASSOC);
                $query->execute();

                $directorAcademico = new DirectorAcademico();

                while($row = $query->fetch()){
                
                    $directorAcademico -> construirObjeto($row["director_academico_id"],$row["dni"],null,null,
                    null,null,null,null,null,null);
                    $directorAcademico->setNombreCompleto($row["nombre_completo"]);

                }

                return $directorAcademico;
            }
            
            catch(PDOException $e){
                throw $e;
                exit;
            }
        }

        public function buscarNombreCompleto(){
            try{
                
                $conexion = Conexion::getConexion();
                $sql = "CALL sp_director_academico_buscar_nombre_completo()";
                $query = $conexion->prepare($sql);

                $query->setFetchMode(PDO::FETCH_ASSOC);
                $query->execute();

                $nombreCompleto = "";

                while($row = $query->fetch()){
                    $nombreCompleto = $row["nombre_completo"];
                }

                return $nombreCompleto;
            }
            
            catch(PDOException $e){
                throw $e;
                exit;
            }
        }

        public function eliminar(){
            try{
                
                $conexion = Conexion::getConexion();
                $sql = "CALL sp_director_academico_eliminar()";
                $query = $conexion->prepare($sql);

                $query->execute();

            }
            
            catch(PDOException $e){
                throw $e;
                exit;
            }
        }

        public function actualizar(DirectorAcademico $directorAcademico){
            try{
                
                $conexion = Conexion::getConexion();
                $sql = "CALL sp_director_academico_actualizar(?,?,?,?,?,?,?,?,?)";
                $query = $conexion->prepare($sql);

                $query->bindValue(1,$directorAcademico->getDni());
                $query->bindValue(2,$directorAcademico->getNombre());
                $query->bindValue(3,$directorAcademico->getApellidoPaterno());
                $query->bindValue(4,$directorAcademico->getApellidoMaterno());
                $query->bindValue(5,$directorAcademico->getFechaNacimiento());
                $query->bindValue(6,$directorAcademico->getAniosLabor());
                $query->bindValue(7,$directorAcademico->getGenero());
                $query->bindValue(8,$directorAcademico->getNumeroTelefonico());
                $query->bindValue(9,$directorAcademico->getGradoAcademico());


                $query->execute();
            }
            
            catch(PDOException $e){
                throw $e;
                exit;
            }
        }

    }

?>