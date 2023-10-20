<?php
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DTO/Curso.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/Conexion/Conexion.php');

    class CursoDAO{

        //------------------Insertar curso-----------------------
        public function insertar(Curso $curso){
            try{

                $conexion = Conexion::getConexion();
                $sql = "CALL sp_curso_insertar(?,?,?)";
                $query = $conexion->prepare($sql);

                $query->bindValue(1,$curso->getNombre());
                $query->bindValue(2,$curso->getNHoras());
                $query->bindValue(3,$curso->getEnfoqueCurso());

                $query->execute();

            }

            catch(PDOException $e){

                if(str_contains($e->getMessage(),'idx_curso_nombre')){
                    throw new Exception("El nombre del curso ingresado ya existe en el sistema");
                }

                throw $e;
                exit;

            }
        }
        //-----------------------------------------------------

        //------------------Insertar curso para docente-----------------------
        public function insertarParaDocente($docenteId, $cursoId){
            try{

                $conexion = Conexion::getConexion();
                $sql = "CALL sp_docente_curso_insertar(?,?)";
                $query = $conexion->prepare($sql);

                $query->bindValue(1, $docenteId);
                $query->bindValue(2, $cursoId);

                $query->execute();

            }

            catch(PDOException $e){

                throw $e;
                exit;

            }
        }
        //-----------------------------------------------------

        //------------------Buscar curso por Id-----------------------
        public function buscarPorId($cursoId){
            try{

                $conexion = Conexion::getConexion();
                $sql = "CALL sp_curso_buscar_por_id(?)";
                $query = $conexion->prepare($sql);

                $query->bindValue(1,$cursoId);

                $query->setFetchMode(PDO::FETCH_ASSOC);
                $query->execute();

                $curso = new Curso();

                while($row = $query->fetch()){
                    $curso -> construirObjeto($row["curso_id"],$row["nombre"],$row["n_horas_por_semana"],$row["enfoque"]);
                }

                return $curso;

            }

            catch(PDOException $e){

                throw $e;
                exit;

            }
        }
        //-----------------------------------------------------

        //------------------Listar cursos-----------------------
        public function listar(){
            try{

                $conexion = Conexion::getConexion();
                $sql = "CALL sp_curso_listar()";
                $query = $conexion->prepare($sql);

                $query->setFetchMode(PDO::FETCH_ASSOC);
                $query->execute();

                $cursosListados = array();

                while($row = $query->fetch()){
                    $curso = new Curso();
                    $curso -> construirObjeto($row["curso_id"],$row["nombre"],$row["n_horas_por_semana"],$row["enfoque"]);
                
                    $cursosListados[] = $curso;
                }

                return $cursosListados;
            }

            catch(PDOException $e){

                throw $e;
                exit;

            }
        }
        //-----------------------------------------------------

        //------------------Listar cursos para Docente-----------------------
        public function listarCursosParaDocente($dniDocente){
            try{

                $conexion = Conexion::getConexion();
                $sql = "CALL sp_docente_curso_listar_para_docente(?)";
                $query = $conexion->prepare($sql);

                $query->bindValue(1,$dniDocente);

                $query->setFetchMode(PDO::FETCH_ASSOC);
                $query->execute();

                $cursosId = array();

                while($row = $query->fetch()){
                    
                    $cursosId[] = $row["curso_id"];
                
                }

                $cursosListados = array();

                for($i = 0; $i < count($cursosId); $i++){
                    $sql = "CALL sp_curso_buscar_por_id(?)";
                    $query = $conexion->prepare($sql);

                    $query->bindValue(1,$cursosId[$i]);

                    $query->setFetchMode(PDO::FETCH_ASSOC);
                    $query->execute();

                    $curso = new Curso();

                    while($row = $query->fetch()){
                        $curso -> construirObjeto($row["curso_id"],$row["nombre"],$row["n_horas_por_semana"],$row["enfoque"]);
                    }

                    $cursosListados[] = $curso;
                }

                return $cursosListados;
            }

            catch(PDOException $e){

                throw $e;
                exit;

            }
        }
        //-----------------------------------------------------
        
        //------------------Listar nombres de cursos por DNI de estudiante (Registro de Asistencias)-----------------------
        public function listarNombresPorDNIEstudiante($dniEstudiante){
            try{

                $conexion = Conexion::getConexion();
                $sql = "CALL sp_curso_listar_nombres_por_dni_estudiante(?)";
                $query = $conexion->prepare($sql);

                $query->bindValue(1,$dniEstudiante);

                $query->setFetchMode(PDO::FETCH_ASSOC);
                $query->execute();

                $cursosListados = array();

                while($row = $query->fetch()){
                    $curso = new Curso();
                    $curso -> construirObjeto($row["curso_id"],$row["nombre"],NULL,NULL);
                
                    $cursosListados[] = $curso;
                }

                return $cursosListados;

            }

            catch(PDOException $e){

                throw $e;
                exit;

            }
        }
        //-----------------------------------------------------

        public function buscarPorNombre($nombre){
            try{

                $conexion = Conexion::getConexion();
                $sql = "CALL sp_curso_buscar_por_nombre(?)";
                $query = $conexion->prepare($sql);

                $query->bindValue(1,$nombre);

                $query->setFetchMode(PDO::FETCH_ASSOC);
                $query->execute();

                $cursosListados = array();

                while($row = $query->fetch()){
                    $curso = new Curso();
                    $curso -> construirObjeto($row["curso_id"],$row["nombre"],$row["n_horas_por_semana"],$row["enfoque"]);
                
                    $cursosListados[] = $curso;
                }

                return $cursosListados;
            }

            catch(PDOException $e){

                throw $e;
                exit;

            }
        }

        //------------------Listar nombres de cursos por DNI de estudiante (Registro de Calificaciones)-----------------------
        public function listarNombresPorDNIEstudiante2($dniEstudiante){
            try{

                $conexion = Conexion::getConexion();
                $sql = "CALL sp_curso_listar_nombres_por_dni_estudiante2(?)";
                $query = $conexion->prepare($sql);

                $query->bindValue(1,$dniEstudiante);

                $query->setFetchMode(PDO::FETCH_ASSOC);
                $query->execute();

                $cursosListados = array();

                while($row = $query->fetch()){
                    $curso = new Curso();
                    $curso -> construirObjeto($row["curso_id"],$row["nombre"],NULL,NULL);
                
                    $cursosListados[] = $curso;
                }

                return $cursosListados;

            }

            catch(PDOException $e){

                throw $e;
                exit;

            }
        }
        //-----------------------------------------------------

        //------------------Listar nombres de cursos por DNI de docente (Registro de Asistencias)-----------------------
        public function listarNombresPorDNIDocente($dniDocente){
            try{

                $conexion = Conexion::getConexion();
                $sql = "CALL sp_curso_listar_nombres_por_dni_docente(?)";
                $query = $conexion->prepare($sql);

                $query->bindValue(1,$dniDocente);

                $query->setFetchMode(PDO::FETCH_ASSOC);
                $query->execute();

                $cursosListados = array();

                while($row = $query->fetch()){
                    $curso = new Curso();
                    $curso -> construirObjeto($row["curso_id"],$row["nombre"],NULL,NULL);
                
                    $cursosListados[] = $curso;
                }

                return $cursosListados;

            }

            catch(PDOException $e){

                throw $e;
                exit;

            }
        }
        //-----------------------------------------------------

        //------------------Listar nombres de cursos por DNI de docente (Registro de Calificaciones)-----------------------
        public function listarNombresPorDNIDocente2($dniDocente){
            try{

                $conexion = Conexion::getConexion();
                $sql = "CALL sp_curso_listar_nombres_por_dni_docente2(?)";
                $query = $conexion->prepare($sql);

                $query->bindValue(1,$dniDocente);

                $query->setFetchMode(PDO::FETCH_ASSOC);
                $query->execute();

                $cursosListados = array();

                while($row = $query->fetch()){
                    $curso = new Curso();
                    $curso -> construirObjeto($row["curso_id"],$row["nombre"],NULL,NULL);
                
                    $cursosListados[] = $curso;
                }

                return $cursosListados;

            }

            catch(PDOException $e){

                throw $e;
                exit;

            }
        }
        //-----------------------------------------------------

        //------------------Eliminar curso-----------------------
        public function eliminar($cursoId){
            try{

                $conexion = Conexion::getConexion();
                $sql = "CALL sp_curso_eliminar(?)";
                $query = $conexion->prepare($sql);

                $query->bindValue(1,$cursoId);

                $query->execute();

            }

            catch(PDOException $e){

                throw $e;
                exit;

            }
        }
        //-----------------------------------------------------

        //------------------Eliminar curso-----------------------
        public function eliminarParaDocente($idDocente,$idCurso){
            try{

                $conexion = Conexion::getConexion();
                $sql = "CALL sp_curso_eliminar_docente_asignado(?,?)";
                $query = $conexion->prepare($sql);

                $query->bindValue(1,$idDocente);
                $query->bindValue(2,$idCurso);

                $query->execute();

            }

            catch(PDOException $e){

                throw $e;
                exit;

            }
        }
        //-----------------------------------------------------

        //------------------Actualizar curso-----------------------
        public function actualizar(Curso $curso){
            try{

                $conexion = Conexion::getConexion();
                $sql = "CALL sp_curso_actualizar(?,?,?,?)";
                $query = $conexion->prepare($sql);

                $query->bindValue(1,$curso->getCursoId());
                $query->bindValue(2,$curso->getNombre());
                $query->bindValue(3,$curso->getNHoras());
                $query->bindValue(4,$curso->getEnfoqueCurso());

                $query->execute();

            }

            catch(PDOException $e){
                if(str_contains($e->getMessage(),'idx_curso_nombre')){
                    throw new Exception("El nombre del curso ingresado ya existe en el sistema");
                }

                throw $e;
                exit;

            }
        }
        //-----------------------------------------------------  

    public function actualizarParaDocente($idDocente,$idCurso,$idCurso2){
        try{

            $conexion = Conexion::getConexion();
            $sql = "CALL sp_curso_actualizar_docente_asignado(?,?,?)";
            $query = $conexion->prepare($sql);

            $query->bindValue(1,$idDocente);
            $query->bindValue(2,$idCurso);
            $query->bindValue(3,$idCurso2);

            $query->execute();

        }

        catch(PDOException $e){
            throw $e;
            exit;

        }
    }
    //-----------------------------------------------------
} 
?>