function buscarAuxiliarAcademico(){
    var formulario = document.getElementById('formulario');
    formData = new FormData(formulario);
    var xmlHttpRequest = new XMLHttpRequest();

    xmlHttpRequest.onreadystatechange = function(){
        if(this.status==200 && this.readyState==4){
            document.getElementById('subresultado').innerHTML = this.responseText;
        }
    }

    xmlHttpRequest.open('POST','execPHP/buscarAuxiliarAcademico.php',true);
    xmlHttpRequest.send(formData);
}

function buscarCurso(){
    var formulario = document.getElementById('formulario');
    formData = new FormData(formulario);
    var xmlHttpRequest = new XMLHttpRequest();

    xmlHttpRequest.onreadystatechange = function(){
        if(this.status==200 && this.readyState==4){
            document.getElementById('subresultado').innerHTML = this.responseText;
        }
    }

    xmlHttpRequest.open('POST','execPHP/buscarCurso.php',true);
    xmlHttpRequest.send(formData);
}

function buscarDocente(){
    var formulario = document.getElementById('formulario');
    formData = new FormData(formulario);
    var xmlHttpRequest = new XMLHttpRequest();

    xmlHttpRequest.onreadystatechange = function(){
        if(this.status==200 && this.readyState==4){
            document.getElementById('subresultado').innerHTML = this.responseText;
        }
    }

    xmlHttpRequest.open('POST','execPHP/buscarDocente.php',true);
    xmlHttpRequest.send(formData);
}