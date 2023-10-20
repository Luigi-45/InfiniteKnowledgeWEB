<?php
    if($_SERVER['REQUEST_METHOD']=='POST'){
        $htmlResult = "<table class='modeloTabla'>
                    <thead>
                        <tr>
                            <th> Id </th>
                            <th> Nombre </th>
                            <th> Número de horas </th>
                            <th> Enfoque de curso </th>
                            <th> Acciones </th>
                        </tr>
                    </thead>";
        require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DAO/CursoDAO.php');
        require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/modelo/DTO/Curso.php');

        $cursoDAO = new CursoDAO();
        $cursosListados = $cursoDAO->buscarPorNombre($_POST["buscarNombre"]);

        foreach($cursosListados as $curso){
            $htmlResult .= "<tr>
                        <td>".$curso->getCursoId()."</td>
                        <td>".$curso->getNombre()."</td>
                        <td>".$curso->getNHoras()."</td>
                        <td>".$curso->getEnfoqueCurso()."</td>
                        <td>"."<a href='modificar_curso.php?id=".$curso->getCursoId()."'> Modificar </a> <br>".
                        "<a href='eliminar_curso.php?id=".$curso->getCursoId()."'> Eliminar </a> </td>".
                    "</tr>";
        }
        $htmlResult .= "</table>";
        echo $htmlResult;
    }
?>  