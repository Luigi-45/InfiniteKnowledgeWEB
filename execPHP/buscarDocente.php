<?php
    if($_SERVER['REQUEST_METHOD']=='POST'){
        $htmlResult = "<table class='modeloTabla'>
        <thead>
            <tr>
                <th>  Id </th>
                <th>  DNI </th>
                <th>  Nombre completo </th>
                <th>  Fecha de Nacimiento </th>
                <th>  Número telefónico </th>
                <th>  Género </th>
                <th>  Grado académico </th>
                <th>  Especialidad académica </th>
                <th>  Correo electrónico </th>
                <th>  Acciones </th>
            </tr>
        </thead>";

        require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/DocenteDAO.php');
        require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DTO/Docente.php');
        require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/UsuarioDAO.php');

        $docenteDAO = new DocenteDAO();
        $docentesListados = $docenteDAO->buscarPorNombreCompleto($_POST["buscarNombreC"]);
        $usuarioDAO = new UsuarioDAO(); 

        foreach($docentesListados as $docente){
            $htmlResult .= "<tr>
                <td>".$docente->getMiembroId()."</td>
                <td>".$docente->getDNI()."</td>
                <td>".$docente->getNombreCompleto()."</td>
                <td>".$docente->getFechaNacimiento()."</td>
                <td>".$docente->getNumeroTelefonico()."</td>
                <td>".$docente->getGenero()."</td>
                <td>".$docente->getGradoAcademico()."</td>
                <td>".$docente->getEspecialidadAcademica()."</td>
                <td>".$usuarioDAO->buscarCorreoPorDNI($docente->getDNI())."</td>
                <td>". 
                    "<a href='modificar_docente.php?idDocente=".$docente->getMiembroId()."'> Modificar </a> <br>".
                    "<a href='eliminar_docente.php?idDocente=".$docente->getMiembroId()."'> Eliminar </a> <br>".
                "</td>
            </tr>";
        }
        $htmlResult .= "</table>";
        echo $htmlResult;
    }
?>