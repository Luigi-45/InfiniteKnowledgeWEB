<?php
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DTO/Docente.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/Conexion/Conexion.php');

    class DocenteDAO{

        public function insertar(Docente $docente){

            try{
                
                $conexion = Conexion::getConexion();
                $sql = "CALL sp_docente_insertar(?,?,?,?,?,?,?,?,?)";
                $query = $conexion->prepare($sql);

                $query->bindValue(1,$docente->getDni());
                $query->bindValue(2,$docente->getNombre());
                $query->bindValue(3,$docente->getApellidoPaterno());
                $query->bindValue(4,$docente->getApellidoMaterno());
                $query->bindValue(5,$docente->getFechaNacimiento());
                $query->bindValue(6,$docente->getGenero());
                $query->bindValue(7,$docente->getNumeroTelefonico());
                $query->bindValue(8,$docente->getGradoAcademico());
                $query->bindValue(9,$docente->getEspecialidadAcademica());

                $query->execute();

            }
            
            catch(PDOException $e){
                if(str_contains($e->getMessage(),'idx_docente_dni')){
                    throw new Exception("El dni del docente ingresado ya existe en el sistema");
                }

                if(str_contains($e->getMessage(),'idx_docente_numero_telefonico')){
                    throw new Exception("El número telefónico del docente ingresado ya existe en el sistema");
                }

                throw $e;
                exit;
            }

        }

        public function buscarPorId($docenteId){
            try{
                
                $conexion = Conexion::getConexion();
                $sql = "CALL sp_docente_buscar_por_id(?)";
                $query = $conexion->prepare($sql);

                $query->bindValue(1,$docenteId);
                
                $query->setFetchMode(PDO::FETCH_ASSOC);
                $query->execute();

                $docente = new Docente();

                while($row = $query->fetch()){

                    $docente -> construirObjeto($row["docente_id"],$row["dni"],$row["nombre"],$row["apellido_paterno"],
                    $row["apellido_materno"],$row["fecha_nacimiento"],$row["genero"],$row["numero_telefonico"], $row["grado_academico"], 
                    $row["especialidad_academica"]);

                    $docente->setNombreCompleto($row["nombre_completo"]);
                }

                return $docente;
            }
            
            catch(PDOException $e){
                throw $e;
                exit;
            }
        }

        public function buscarPorDNI($dniDocente){
            try{
                
                $conexion = Conexion::getConexion();
                $sql = "CALL sp_docente_buscar_por_dni(?)";
                $query = $conexion->prepare($sql);

                $query->bindValue(1,$dniDocente);
                
                $query->setFetchMode(PDO::FETCH_ASSOC);
                $query->execute();

                $docente = new Docente();

                while($row = $query->fetch()){
                    $docente -> construirObjeto($row["docente_id"],$row["dni"],$row["nombre"],$row["apellido_paterno"],
                    $row["apellido_materno"],$row["fecha_nacimiento"],$row["genero"],$row["numero_telefonico"], $row["grado_academico"], 
                    $row["especialidad_academica"]);

                    $docente->setNombreCompleto($row["nombre_completo"]);
                }

                return $docente;
            }
            
            catch(PDOException $e){
                throw $e;
                exit;
            }
        }

        public function buscarPorNombreCompleto($nombreCompleto){
            try{
                
                $conexion = Conexion::getConexion();
                $sql = "CALL sp_docente_buscar_por_nombre_completo(?)";
                $query = $conexion->prepare($sql);

                $query->bindValue(1,$nombreCompleto);
                
                $query->setFetchMode(PDO::FETCH_ASSOC);
                $query->execute();

                $docentesListados = array();

                while($row = $query->fetch()){
                    $docente = new Docente();

                    $docente -> construirObjeto($row["docente_id"],$row["dni"],NULL,NULL,
                    NULL,$row["fecha_nacimiento"],$row["genero"],$row["numero_telefonico"],$row["grado_academico"], $row["especialidad_academica"]);

                    $docente->setNombreCompleto($row["nombre_completo"]);
                
                    $docentesListados[] = $docente;
                }
                
                return $docentesListados;
            }
            
            catch(PDOException $e){
                throw $e;
                exit;
            }
        }

        public function buscarDatosParaEmail($docenteId){
            try{
                
                $conexion = Conexion::getConexion();
                $sql = "CALL sp_docente_buscar_datos_para_email(?)";
                $query = $conexion->prepare($sql);

                $query->bindValue(1,$docenteId);
                
                $query->setFetchMode(PDO::FETCH_ASSOC);
                $query->execute();

                $docente = new Docente();

                while($row = $query->fetch()){

                    $docente -> construirObjeto($row["docente_id"],$row["dni"],NULL,NULL,
                    NULL,NULL,NULL,NULL,NULL,NULL);

                    $docente->setNombreCompleto($row["nombre_completo"]);
                }

                return $docente;
            }
            
            catch(PDOException $e){
                throw $e;
                exit;
            }
        }

        public function buscarDatosParaInformeDeVerificacion($docenteId){
            try{
                
                $conexion = Conexion::getConexion();
                $sql = "CALL sp_docente_buscar_datos_para_informe_de_verificacion(?)";
                $query = $conexion->prepare($sql);

                $query->bindValue(1,$docenteId);
                
                $query->setFetchMode(PDO::FETCH_ASSOC);
                $query->execute();

                $docente = new Docente();

                while($row = $query->fetch()){
                    $docente -> construirObjeto($row["docente_id"],$row["dni"],NULL,NULL,
                    NULL,NULL,NULL,NULL,$row["grado_academico"], $row["especialidad_academica"]);

                    $docente->setNombreCompleto($row["nombre_completo"]);
                }

                return $docente;
            }
            
            catch(PDOException $e){
                throw $e;
                exit;
            }
        }

        public function buscarNombreCompletoPorDNI($dniDocente){
            try{
                
                $conexion = Conexion::getConexion();
                $sql = "CALL sp_docente_buscar_nombre_completo_por_dni(?)";
                $query = $conexion->prepare($sql);

                $query->bindValue(1,$dniDocente);
                
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

        public function listar(){
            try{
                
                $conexion = Conexion::getConexion();
                $sql = "CALL sp_docente_listar()";
                $query = $conexion->prepare($sql);
                
                $query->setFetchMode(PDO::FETCH_ASSOC);
                $query->execute();

                $docentesListados = array();

                while($row = $query->fetch()){
                    $docente = new Docente();

                    $docente -> construirObjeto($row["docente_id"],$row["dni"],$row["nombre"],$row["apellido_paterno"],
                    $row["apellido_materno"],$row["fecha_nacimiento"],$row["genero"],$row["numero_telefonico"], $row["grado_academico"], 
                    $row["especialidad_academica"]);

                    $docente->setNombreCompleto($row["nombre_completo"]);
                
                    $docentesListados[] = $docente;
                }

                return $docentesListados;
            }
            
            catch(PDOException $e){
                throw $e;
                exit;
            }
        }

        public function eliminar($docenteId){
            try{
                
                $conexion = Conexion::getConexion();
                $sql = "CALL sp_docente_eliminar(?)";
                $query = $conexion->prepare($sql);

                $query->bindValue(1,$docenteId);

                $query->execute();
            }
            
            catch(PDOException $e){
                throw $e;
                exit;
            }
        }

        public function actualizar(Docente $docente){
            try{
                
                $conexion = Conexion::getConexion();
                $sql = "CALL sp_docente_actualizar(?,?,?,?,?,?,?,?,?,?)";
                $query = $conexion->prepare($sql);

                $query->bindValue(1,$docente->getMiembroId());
                $query->bindValue(2,$docente->getDni());
                $query->bindValue(3,$docente->getNombre());
                $query->bindValue(4,$docente->getApellidoPaterno());
                $query->bindValue(5,$docente->getApellidoMaterno());
                $query->bindValue(6,$docente->getFechaNacimiento());
                $query->bindValue(7,$docente->getGenero());
                $query->bindValue(8,$docente->getNumeroTelefonico());
                $query->bindValue(9,$docente->getGradoAcademico());
                $query->bindValue(10,$docente->getEspecialidadAcademica());

                $query->execute();
            }
            
            catch(PDOException $e){
                if(str_contains($e->getMessage(),'idx_docente_dni')){
                    throw new Exception("El dni del docente ingresado ya existe en el sistema");
                }

                if(str_contains($e->getMessage(),'idx_docente_numero_telefonico')){
                    throw new Exception("El número telefónico del docente ingresado ya existe en el sistema");
                }

                throw $e;
                exit;
            }
        }
    }
?>