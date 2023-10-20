<?php

    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DTO/RegistroCalificaciones.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DTO/RegistroCalificacionesJSON.php');

    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DTO/Estudiante.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DTO/Docente.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DTO/Curso.php');

    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/Conexion/Conexion.php');

    class RegistroCalificacionesDAO{
        public function insertar(RegistroCalificaciones $registroCalificaciones){
            try{
                
                $conexion = Conexion::getConexion();
                $sql = "CALL sp_registro_calificaciones_insertar(?,?,?,?,?,?,?,?,?,?)";
                $query = $conexion->prepare($sql);

                $query->bindValue(1,$registroCalificaciones->getDocenteId());
                $query->bindValue(2,$registroCalificaciones->getEstudianteId());
                $query->bindValue(3,$registroCalificaciones->getCursoId());
                $query->bindValue(4,$registroCalificaciones->getSalonClases());
                $query->bindValue(5,$registroCalificaciones->getBimestre());

                if(empty($registroCalificaciones->getCalif1())){
                    $query->bindValue(6,'NULL',PDO::PARAM_NULL);
                }
                else{
                    $query->bindValue(6,$registroCalificaciones->getCalif1());
                }

                if(empty($registroCalificaciones->getCalif2())){
                    $query->bindValue(7,'NULL',PDO::PARAM_NULL);
                }
                else{
                    $query->bindValue(7,$registroCalificaciones->getCalif2());
                }

                if(empty($registroCalificaciones->getCalif3())){
                    $query->bindValue(8,'NULL',PDO::PARAM_NULL);
                }
                else{
                    $query->bindValue(8,$registroCalificaciones->getCalif3());
                }

                if(empty($registroCalificaciones->getCalif4())){
                    $query->bindValue(9,'NULL',PDO::PARAM_NULL);
                }
                else{
                    $query->bindValue(9,$registroCalificaciones->getCalif4());
                }

                if(empty($registroCalificaciones->getFechaEmision())){
                    $query->bindValue(10,'NULL',PDO::PARAM_NULL);
                }
                else{
                    $query->bindValue(10,$registroCalificaciones->getFechaEmision());
                }
                
                $query->execute();

            }
            
            catch(PDOException $e){
                throw $e;
                exit;
            }
            
        }

        public function insertarCompleto($docenteId,$estudianteId,$cursoId,$salonClases){
            try{
                
                $conexion = Conexion::getConexion();

                $conexion->beginTransaction();

                $sql = "CALL sp_registro_calificaciones_insertar(?,?,?,?,?,?,?,?,?,?)";
                $query = $conexion->prepare($sql);

                for($i=1;$i<5;$i++){
                    $query->bindValue(1,$docenteId);
                    $query->bindValue(2,$estudianteId);
                    $query->bindValue(3,$cursoId);
                    $query->bindValue(4,$salonClases);
                    $query->bindValue(5,strval($i));
                    $query->bindValue(6,'NULL',PDO::PARAM_NULL);
                    $query->bindValue(7,'NULL',PDO::PARAM_NULL);
                    $query->bindValue(8,'NULL',PDO::PARAM_NULL);
                    $query->bindValue(9,'NULL',PDO::PARAM_NULL);
                    $query->bindValue(10,date('d/m/y'));

                    $query->execute();
                }

                $conexion->commit();
            }
            
            catch(PDOException $e){
                $conexion->rollBack();
                throw $e;
                exit;
            }
            
        }

        public function actualizar(RegistroCalificaciones $registroCalificaciones, $bimestreCambiado){
            try{
                
                $conexion = Conexion::getConexion();
                $sql = "CALL sp_registro_calificaciones_actualizar(?,?,?,?,?,?,?,?,?,?,?,?,?)";
                $query = $conexion->prepare($sql);

                $query->bindValue(1,$registroCalificaciones->getDocenteId());
                $query->bindValue(2,$registroCalificaciones->getEstudianteId());
                $query->bindValue(3,$registroCalificaciones->getCursoId());
                $query->bindValue(4,$registroCalificaciones->getSalonClases());
                $query->bindValue(5,$registroCalificaciones->getBimestre());
                $query->bindValue(6,$bimestreCambiado);

                if(empty($registroCalificaciones->getCalif1())){
                    $query->bindValue(7,'NULL',PDO::PARAM_NULL);
                }
                else{
                    $query->bindValue(7,$registroCalificaciones->getCalif1());
                }

                if(empty($registroCalificaciones->getCalif2())){
                    $query->bindValue(8,'NULL',PDO::PARAM_NULL);
                }
                else{
                    $query->bindValue(8,$registroCalificaciones->getCalif2());
                }

                if(empty($registroCalificaciones->getCalif3())){
                    $query->bindValue(9,'NULL',PDO::PARAM_NULL);
                }
                else{
                    $query->bindValue(9,$registroCalificaciones->getCalif3());
                }

                if(empty($registroCalificaciones->getCalif4())){
                    $query->bindValue(10,'NULL',PDO::PARAM_NULL);
                }
                else{
                    $query->bindValue(10,$registroCalificaciones->getCalif4());
                }

                if(empty($registroCalificaciones->getFechaEmision())){
                    $query->bindValue(11,'NULL',PDO::PARAM_NULL);
                }
                else{
                    $query->bindValue(11,$registroCalificaciones->getFechaEmision());
                }
                if(empty($registroCalificaciones->getEstadoAprobacion())){
                    $query->bindValue(12,'NULL',PDO::PARAM_NULL);
                }
                else{
                    $query->bindValue(12,$registroCalificaciones->getEstadoAprobacion());
                }
                if(empty($registroCalificaciones->getPromedio())){
                    $query->bindValue(13,'NULL',PDO::PARAM_NULL);
                }
                else{
                    $query->bindValue(13,$registroCalificaciones->getPromedio());
                }

                $query->execute();

            }
            
            catch(PDOException $e){
                throw $e;
                exit;
            }
            
        }

        public function actualizarCompleto($docenteId,$estudianteId,$cursoId,$salonClases){
            try{
                
                $conexion = Conexion::getConexion();

                $conexion->beginTransaction();

                $sql = "CALL sp_registro_calificaciones_actualizar(?,?,?,?,?,?,?,?,?,?,?,?,?)";
                $query = $conexion->prepare($sql);

                for($i=1;$i<5;$i++){
                    $query->bindValue(1,$docenteId);
                    $query->bindValue(2,$estudianteId);
                    $query->bindValue(3,$cursoId);
                    $query->bindValue(4,$salonClases);
                    $query->bindValue(5,strval($i));
                    $query->bindValue(6,strval($i));
                    $query->bindValue(7,'NULL',PDO::PARAM_NULL);
                    $query->bindValue(8,'NULL',PDO::PARAM_NULL);
                    $query->bindValue(9,'NULL',PDO::PARAM_NULL);
                    $query->bindValue(10,'NULL',PDO::PARAM_NULL);
                    $query->bindValue(11,date('d/m/y'));
                    $query->bindValue(12,'NULL',PDO::PARAM_NULL);
                    $query->bindValue(13,'NULL',PDO::PARAM_NULL);

                    $query->execute();
                }

                $conexion->commit();
            }
            
            catch(PDOException $e){
                $conexion->rollBack();
                throw $e;
                exit;
            }
            
        }

        public function actualizarCompleto2($registros){
            try{
                
                $conexion = Conexion::getConexion();

                $conexion->beginTransaction();

                $sql = "CALL sp_registro_calificaciones_actualizar(?,?,?,?,?,?,?,?,?,?,?,?,?)";
                $query = $conexion->prepare($sql);

                foreach($registros as $i){
                    $query->bindValue(1,$i->getDocenteId());
                    $query->bindValue(2,$i->getEstudianteId());
                    $query->bindValue(3,$i->getCursoId());
                    $query->bindValue(4,$i->getSalonClases());
                    $query->bindValue(5,$i->getBimestre());
                    $query->bindValue(6,$i->getBimestre());
                    $query->bindValue(7,$i->getCalif1());
                    $query->bindValue(8,$i->getCalif2());
                    $query->bindValue(9,$i->getCalif3());
                    $query->bindValue(10,$i->getCalif4());
                    $query->bindValue(11,$i->getFechaEmision());
                    $query->bindValue(12,$i->getEstadoAprobacion());
                    $query->bindValue(13,$i->getPromedio());

                    $query->execute();
                }

                $conexion->commit();
            }
            
            catch(PDOException $e){
                $conexion->rollBack();
                throw $e;
                exit;
            }
            
        }

        public function buscarPorIdEstudiante($estudianteId, $bimestre){
            try{
                
                $conexion = Conexion::getConexion();
                $sql = "CALL sp_registro_calificaciones_buscar_por_id_de_estudiante(?,?)";
                $query = $conexion->prepare($sql);

                $query->bindValue(1,$estudianteId);
                $query->bindValue(2,$bimestre);
                
                $query->setFetchMode(PDO::FETCH_ASSOC);
                $query->execute();

                $matrizRegistroCalificaciones = array();

                while($row = $query->fetch()){
                    $estudiante = new Estudiante();
                    $docente = new Docente();
                    $curso = new Curso();
                    $registroCalificaciones = new RegistroCalificaciones();

                    $estudiante->setNombreCompleto($row["estudiante"]);
                    $docente->setNombreCompleto($row["docente"]);
                    $curso->setNombre($row["curso"]);

                    $registroCalificaciones->construirObjeto($row["docente_id"],$row["estudiante_id"],$row["curso_id"],
                    $row["salon_clases"],$row["calif1"],$row["calif2"],$row["calif3"],$row["calif4"],$row["emision"],$row["bimestre"]);

                    $registroCalificaciones->setPromedio($row["promedio"]);
                    $registroCalificaciones->setEstadoAprobacion($row["estado"]);

                    $registroCalificacionesListados = array();

                    $registroCalificacionesListados[] = $estudiante;
                    $registroCalificacionesListados[] = $docente;
                    $registroCalificacionesListados[] = $curso;
                    $registroCalificacionesListados[] = $registroCalificaciones;

                    $matrizRegistroCalificaciones[] = $registroCalificacionesListados;
                }
                return $matrizRegistroCalificaciones;
            }
            
            catch(PDOException $e){
                throw $e;
                exit;
            }
        }

        public function buscarPorId($estudianteId,$docenteId,$cursoId){
            try{
                
                $conexion = Conexion::getConexion();
                $sql = "CALL sp_registro_calificaciones_buscar_por_id(?,?,?)";
                $query = $conexion->prepare($sql);

                $query->bindValue(1,$estudianteId);
                $query->bindValue(2,$docenteId);
                $query->bindValue(3,$cursoId);
                
                $query->setFetchMode(PDO::FETCH_ASSOC);
                $query->execute();

                $registroCalificaciones = new RegistroCalificacionesJSON();
                while($row = $query->fetch()){
                    
                    $registroCalificaciones->docenteId = $row["docente_id"];
                    $registroCalificaciones->estudianteId = $row["estudiante_id"];
                    $registroCalificaciones->cursoId = $row["curso_id"];
                    $registroCalificaciones->salonClases = $row["salon_clases"];

                    $registroCalificaciones->docente = $row["nombreDocente"];
                    $registroCalificaciones->estudiante = $row["nombreEstudiante"];
                    $registroCalificaciones->curso = $row["nombre"];
                
                }
                
                return $registroCalificaciones;
            }
            catch(PDOException $e){
                throw $e;
                exit;
            }
        }

        public function buscarPorNombreEstudiante($nombreEstudiante){
            try{
                
                $conexion = Conexion::getConexion();
                $sql = "CALL sp_registro_calificaciones_buscar_por_id_de_estudiante2(?)";
                $query = $conexion->prepare($sql);

                $query->bindValue(1,$nombreEstudiante);
                
                $query->setFetchMode(PDO::FETCH_ASSOC);
                $query->execute();

                $registros = array();

                while($row = $query->fetch()){
                    $registroCalificaciones = new RegistroCalificaciones();

                    $registroCalificaciones->setDocenteId($row["docente_id"]);
                    $registroCalificaciones->setEstudianteId($row["estudiante_id"]);
                    $registroCalificaciones->setCursoId($row["curso_id"]);
                    $registroCalificaciones->setSalonClases($row["salon_clases"]);

                    $registroCalificaciones->setDocente($row["nombreDocente"]);
                    $registroCalificaciones->setEstudiante($row["nombreEstudiante"]);
                    $registroCalificaciones->setCurso($row["nombre"]);
                
                    $registros[] = $registroCalificaciones;
                }
                
                return $registros;
            }
            catch(PDOException $e){
                throw $e;
                exit;
            }
        }

        public function buscarPorDNIEstudiante($dniEstudiante,$cursoId,$salonClases,$bimestre){
            try{
                
                $conexion = Conexion::getConexion();
                $sql = "CALL sp_registro_calificaciones_buscar_por_dni_de_estudiante(?,?,?,?)";
                $query = $conexion->prepare($sql);

                $query->bindValue(1,$dniEstudiante);
                $query->bindValue(2,$cursoId);
                $query->bindValue(3,$salonClases);
                $query->bindValue(4,$bimestre);
                
                $query->setFetchMode(PDO::FETCH_ASSOC);
                $query->execute();

                $matrizRegistroCalificaciones = array();

                while($row = $query->fetch()){
                    $estudiante = new Estudiante();
                    $docente = new Docente();
                    $curso = new Curso();
                    $registroCalificaciones = new RegistroCalificaciones();

                    $estudiante->setNombreCompleto($row["estudiante"]);
                    $docente->setNombreCompleto($row["docente"]);
                    $curso->setNombre($row["curso"]);

                    $registroCalificaciones->construirObjeto($row["docente_id"],$row["estudiante_id"],$row["curso_id"],
                    $row["salon_clases"],$row["calif1"],$row["calif2"],$row["calif3"],$row["calif4"],$row["emision"],$row["bimestre"]);

                    $registroCalificaciones->setPromedio($row["promedio"]);
                    $registroCalificaciones->setEstadoAprobacion($row["estado"]);

                    $registroCalificacionesListados = array();

                    $registroCalificacionesListados[] = $estudiante;
                    $registroCalificacionesListados[] = $docente;
                    $registroCalificacionesListados[] = $curso;
                    $registroCalificacionesListados[] = $registroCalificaciones;

                    $matrizRegistroCalificaciones[] = $registroCalificacionesListados;
                }

                return $matrizRegistroCalificaciones;
            }
            
            catch(PDOException $e){
                throw $e;
                exit;
            }
        }

        public function buscarPorDNIEstudiante2($dniEstudiante,$cursoId,$bimestre){
            try{
                
                $conexion = Conexion::getConexion();
                $sql = "CALL sp_registro_calificaciones_buscar_por_dni_de_estudiante2(?,?,?)";
                $query = $conexion->prepare($sql);

                $query->bindValue(1,$dniEstudiante);
                $query->bindValue(2,$cursoId);
                $query->bindValue(3,$bimestre);
                
                $query->setFetchMode(PDO::FETCH_ASSOC);
                $query->execute();

                $matrizRegistroCalificaciones = array();

                while($row = $query->fetch()){
                    $estudiante = new Estudiante();
                    $docente = new Docente();
                    $curso = new Curso();
                    $registroCalificaciones = new RegistroCalificaciones();

                    $estudiante->setNombreCompleto($row["estudiante"]);
                    $docente->setNombreCompleto($row["docente"]);
                    $curso->setNombre($row["curso"]);

                    $registroCalificaciones->construirObjeto($row["docente_id"],$row["estudiante_id"],$row["curso_id"],
                    $row["salon_clases"],$row["calif1"],$row["calif2"],$row["calif3"],$row["calif4"],$row["emision"],$row["bimestre"]);

                    $registroCalificaciones->setPromedio($row["promedio"]);
                    $registroCalificaciones->setEstadoAprobacion($row["estado"]);

                    $registroCalificacionesListados = array();

                    $registroCalificacionesListados[] = $estudiante;
                    $registroCalificacionesListados[] = $docente;
                    $registroCalificacionesListados[] = $curso;
                    $registroCalificacionesListados[] = $registroCalificaciones;

                    $matrizRegistroCalificaciones[] = $registroCalificacionesListados;
                }

                return $matrizRegistroCalificaciones;
            }
            
            catch(PDOException $e){
                throw $e;
                exit;
            }
        }

        public function buscarNEstadoAprobacion($dni,$cursoId,$bimestre){
            try{
                $conexion = Conexion::getConexion();
                $sql = "CALL sp_registro_calificaciones_buscar_numero_desaprob(?,?,?)";
                $query = $conexion->prepare($sql);

                $query->bindValue(1,$dni);
                $query->bindValue(2,$cursoId);
                $query->bindValue(3,$bimestre);
                
                $query->setFetchMode(PDO::FETCH_ASSOC);
                $query->execute();

                $valores = array();

                while($row = $query->fetch()){
                    $valores[] = $row["nDesaprob"];
                }

                $sql = "CALL sp_registro_calificaciones_buscar_numero_aprob(?,?,?)";
                $query = $conexion->prepare($sql);

                $query->bindValue(1,$dni);
                $query->bindValue(2,$cursoId);
                $query->bindValue(3,$bimestre);
                
                $query->setFetchMode(PDO::FETCH_ASSOC);
                $query->execute();

                while($row = $query->fetch()){
                    $valores[] = $row["nAprob"];
                }

                $sql = "CALL sp_registro_calificaciones_buscar_numero_aprobm(?,?,?)";
                $query = $conexion->prepare($sql);

                $query->bindValue(1,$dni);
                $query->bindValue(2,$cursoId);
                $query->bindValue(3,$bimestre);
                
                $query->setFetchMode(PDO::FETCH_ASSOC);
                $query->execute();

                while($row = $query->fetch()){
                    $valores[] = $row["nAprobm"];
                }
                
                return $valores;
            }
            
            catch(PDOException $e){
                throw $e;
                exit;
            }
        }

        public function buscarPorDNIEstudiante3($dniEstudiante,$cursoId){
            try{
                
                $conexion = Conexion::getConexion();
                $sql = "CALL sp_registro_calificaciones_buscar_por_dni_de_estudiante3(?,?)";
                $query = $conexion->prepare($sql);

                $query->bindValue(1,$dniEstudiante);
                $query->bindValue(2,$cursoId);
                
                $query->setFetchMode(PDO::FETCH_ASSOC);
                $query->execute();

                $matrizRegistroCalificaciones = array();

                while($row = $query->fetch()){
                    $estudiante = new Estudiante();
                    $docente = new Docente();
                    $curso = new Curso();
                    $registroCalificaciones = new RegistroCalificaciones();

                    $estudiante->setNombreCompleto($row["estudiante"]);
                    $docente->setNombreCompleto($row["docente"]);
                    $curso->setNombre($row["curso"]);

                    $registroCalificaciones->construirObjeto($row["docente_id"],$row["estudiante_id"],$row["curso_id"],
                    $row["salon_clases"],$row["calif1"],$row["calif2"],$row["calif3"],$row["calif4"],$row["emision"],$row["bimestre"]);

                    $registroCalificaciones->setPromedio($row["promedio"]);
                    $registroCalificaciones->setEstadoAprobacion($row["estado"]);

                    $registroCalificacionesListados = array();

                    $registroCalificacionesListados[] = $estudiante;
                    $registroCalificacionesListados[] = $docente;
                    $registroCalificacionesListados[] = $curso;
                    $registroCalificacionesListados[] = $registroCalificaciones;

                    $matrizRegistroCalificaciones[] = $registroCalificacionesListados;
                }

                return $matrizRegistroCalificaciones;
            }
            
            catch(PDOException $e){
                throw $e;
                exit;
            }
        }

        public function buscarParaDocente($dniDocente, $cursoId, $salonClases, $bimestre){
            try{
                
                $conexion = Conexion::getConexion();
                $sql = "CALL sp_registro_calificaciones_buscar_para_docente(?,?,?,?)";
                $query = $conexion->prepare($sql);

                $query->bindValue(1,$dniDocente);
                $query->bindValue(2,$cursoId);
                $query->bindValue(3,$salonClases);
                $query->bindValue(4,$bimestre);
                
                $query->setFetchMode(PDO::FETCH_ASSOC);
                $query->execute();

                $matrizRegistroCalificaciones = array();

                while($row = $query->fetch()){
                    $estudiante = new Estudiante();
                    $docente = new Docente();
                    $curso = new Curso();
                    $registroCalificaciones = new RegistroCalificaciones();

                    $estudiante->setNombreCompleto($row["estudiante"]);
                    $docente->setNombreCompleto($row["docente"]);
                    $curso->setNombre($row["curso"]);

                    $registroCalificaciones->construirObjeto($row["docente_id"],$row["estudiante_id"],$row["curso_id"],
                    $row["salon_clases"],$row["calif1"],$row["calif2"],$row["calif3"],$row["calif4"],$row["emision"],$row["bimestre"]);

                    $registroCalificaciones->setPromedio($row["promedio"]);
                    $registroCalificaciones->setEstadoAprobacion($row["estado"]);

                    $registroCalificacionesListados = array();

                    $registroCalificacionesListados[] = $estudiante;
                    $registroCalificacionesListados[] = $docente;
                    $registroCalificacionesListados[] = $curso;
                    $registroCalificacionesListados[] = $registroCalificaciones;

                    $matrizRegistroCalificaciones[] = $registroCalificacionesListados;
                }
                return $matrizRegistroCalificaciones;
            }
            
            catch(PDOException $e){
                throw $e;
                exit;
            }
        }

        public function buscarRegistroEspecifico($estudianteId, $docenteId, $cursoId, $bimestre){
            try{
                
                $conexion = Conexion::getConexion();
                $sql = "CALL sp_registro_calificaciones_buscar_registro_especifico(?,?,?,?)";
                $query = $conexion->prepare($sql);

                $query->bindValue(1,$estudianteId);
                $query->bindValue(2,$docenteId);
                $query->bindValue(3,$cursoId);
                $query->bindValue(4,$bimestre);
                
                $query->setFetchMode(PDO::FETCH_ASSOC);
                $query->execute();

                $registroCalificacionesListados = array();

                while($row = $query->fetch()){
                    $estudiante = new Estudiante();
                    $docente = new Docente();
                    $curso = new Curso();
                    $registroCalificaciones = new RegistroCalificaciones();

                    $estudiante->setNombreCompleto($row["estudiante"]);
                    $docente->setNombreCompleto($row["docente"]);
                    $curso->setNombre($row["curso"]);

                    $registroCalificaciones->construirObjeto($docenteId,$estudianteId,$cursoId,
                    $row["salon_clases"],$row["calif1"],$row["calif2"],$row["calif3"],$row["calif4"],$row["emision"],$row["bimestre"]);

                    $registroCalificaciones->setPromedio($row["promedio"]);
                    $registroCalificaciones->setEstadoAprobacion($row["estado"]);

                    $registroCalificacionesListados[] = $estudiante;
                    $registroCalificacionesListados[] = $docente;
                    $registroCalificacionesListados[] = $curso;
                    $registroCalificacionesListados[] = $registroCalificaciones;

                }
                return $registroCalificacionesListados;
            }
            
            catch(PDOException $e){
                throw $e;
                exit;
            }
        }
        

        public function eliminar(RegistroCalificaciones $registroCalificaciones){
            try{
                
                $conexion = Conexion::getConexion();
                $sql = "CALL sp_registro_calificaciones_eliminar(?,?,?,?)";
                $query = $conexion->prepare($sql);

                $query->bindValue(1,$registroCalificaciones->getDocenteId());
                $query->bindValue(2,$registroCalificaciones->getEstudianteId());
                $query->bindValue(3,$registroCalificaciones->getCursoId());
                $query->bindValue(4,$registroCalificaciones->getBimestre());

                $query->execute();
            }
            
            catch(PDOException $e){
                throw $e;
                exit;
            }
        }

        public function eliminarCompleto($docenteId,$estudianteId,$cursoId){
            try{
                
                $conexion = Conexion::getConexion();

                $conexion->beginTransaction();

                $sql = "CALL sp_registro_calificaciones_eliminar(?,?,?,?)";
                $query = $conexion->prepare($sql);

                for($i=1;$i<5;$i++){
                    $query->bindValue(1,$docenteId);
                    $query->bindValue(2,$estudianteId);
                    $query->bindValue(3,$cursoId);
                    $query->bindValue(4,strval($i));

                    $query->execute();
                }

                $conexion->commit();
            }
            
            catch(PDOException $e){
                $conexion->rollBack();

                throw $e;
                exit;
            }
        }
    }
?>