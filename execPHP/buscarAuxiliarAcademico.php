<?php
    if($_SERVER['REQUEST_METHOD']=='POST'){
        $htmlResult = "<table class='modeloTabla'>
            <thead>
                <tr>
                    <th>  Id  </th>
                    <th>  DNI  </th>
                    <th>  Nombre completo  </th>
                    <th>  Fecha de Nacimiento  </th>
                    <th>  Número telefónico  </th>
                    <th>  Género  </th>
                    <th>  Grado académico  </th>
                    <th>  N. de docentes a cargo  </th>
                    <th>  Correo electrónico  </th>
                    <th>  Acciones  </th>
                </tr>
            </thead>";
        require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/AuxiliarAcademicoDAO.php');
        require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DTO/AuxiliarAcademico.php');
        require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/UsuarioDAO.php');


        $auxiliarAcademicoDAO = new AuxiliarAcademicoDAO();
        $usuarioDAO = new UsuarioDAO();
        $auxiliarAcademicoListados = $auxiliarAcademicoDAO->buscarPorNombreCompleto($_POST["buscarNombreC"]);

        foreach($auxiliarAcademicoListados as $auxiliarAcademico){
            $htmlResult .= "<tr>
                <td>".$auxiliarAcademico->getMiembroId()."</td>
                <td>".$auxiliarAcademico->getDNI()."</td>
                <td>".$auxiliarAcademico->getNombreCompleto()."</td>
                <td>".$auxiliarAcademico->getFechaNacimiento()."</td>
                <td>".$auxiliarAcademico->getNumeroTelefonico()."</td>
                <td>".$auxiliarAcademico->getGenero()."</td>
                <td>".$auxiliarAcademico->getGradoAcademico()."</td>
                <td>".$auxiliarAcademico->getNDocentesACargo()."</td>
                <td>".$usuarioDAO->buscarCorreoPorDNI($auxiliarAcademico->getDNI())."</td>
                <td>".
                    "<a href='modificar_auxiliar_academico.php?id=".$auxiliarAcademico->getMiembroId()."'> Modificar </a> <br>".
                    "<a href='eliminar_auxiliar_academico.php?id=".$auxiliarAcademico->getMiembroId()."'> Eliminar </a> <br>".
                "</td>
            </tr>";
        }
        $htmlResult.="</table>";

        echo $htmlResult;
    }
?>