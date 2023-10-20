<header class="header">
      <nav class="nav">
        
        <a href="index.php"> <img src="https://upload.wikimedia.org/wikipedia/commons/0/00/Colegio_mayor_coar_logo.png" alt="logo" class="logo"> </a>
     
        <button class="nav-toggle" aria-label="Abrir menú">
          <i class="fas fa-bars"></i>
        </button>
        <ul class="nav-menu">
          <?php if(empty($_SESSION['dni']) && empty($_SESSION['rol'])){?>
          <li class="nav-menu-item">
            <a href="index.php" class="nav-menu-link nav-link nav-menu-link_active">Iniciar sesión</a>
          </li>
          <?php } else if (!empty($_SESSION['dni']) && !empty($_SESSION['rol']) && ($_SESSION['rol']==4)){ ?>
          <li class="nav-menu-item">
            <a href="miembro_principal.php" class="nav-menu-link nav-link nav-menu-link_active">Inicio</a>
          </li>
          <li class="nav-menu-item">
            <a href="material_de_clase.php" class="nav-menu-link nav-link">Material de clase</a>
          </li>
          <li class="nav-menu-item">
            <a href="seleccion_curso_calificaciones.php" class="nav-menu-link nav-link">Calificaciones</a>
          </li>
          <li class="nav-menu-item">
            <a href="ver_informacion_personal.php" class="nav-menu-link nav-link">Información personal</a>
          </li>
          <li class="nav-menu-item">
            <a href="cerrar_sesion.php" class="nav-menu-link nav-link">Cerrar sesión</a>
          </li>
          <?php } else if(!empty($_SESSION['dni']) && !empty($_SESSION['rol']) && ($_SESSION['rol']==3)){?>
          <li class="nav-menu-item">
            <a href="miembro_principal.php" class="nav-menu-link nav-link nav-menu-link_active">Inicio</a>
          </li>
          <li class="nav-menu-item">
            <a href="material_de_clase.php" class="nav-menu-link nav-link">Subir material de clase</a>
          </li>
          <li class="nav-menu-item">
            <a href="seleccion_curso_calificaciones.php" class="nav-menu-link nav-link">Calificaciones</a>
          </li>
          <li class="nav-menu-item">
            <a href="ver_informacion_personal.php" class="nav-menu-link nav-link">Información personal</a>
          </li>
          <li class="nav-menu-item">
            <a href="cerrar_sesion.php" class="nav-menu-link nav-link">Cerrar sesión</a>
          </li>
          <?php } else if(!empty($_SESSION['dni']) && !empty($_SESSION['rol']) && ($_SESSION['rol']==2)){?>
          <li class="nav-menu-item">
            <a href="miembro_principal.php" class="nav-menu-link nav-link nav-menu-link_active">Inicio</a>
          </li>
          <li class="nav-menu-item">
            <a href="seleccionar_miembro_director_academico.php" class="nav-menu-link nav-link">Docentes y estudiantes</a>
          </li>
          <li class="nav-menu-item">
            <a href="insertar_curso_docente.php" class="nav-menu-link nav-link">Asignar cursos</a>
          </li>
          <li class="nav-menu-item">
            <a href="gestionar_asignacion_estudiante.php" class="nav-menu-link nav-link">Asignar a estudiantes</a>
          </li>
          <li class="nav-menu-item">
            <a href="correo.php" class="nav-menu-link nav-link">Correo</a>
          </li>
          <li class="nav-menu-item">
            <a href="subir_reporte_calificaciones.php" class="nav-menu-link nav-link">Reportes</a>
          </li>
          <li class="nav-menu-item">
            <a href="ver_informacion_personal.php" class="nav-menu-link nav-link">Información personal</a>
          </li>
          <li class="nav-menu-item">
            <a href="cerrar_sesion.php" class="nav-menu-link nav-link">Cerrar sesión</a>
          </li>
          <?php } else if(!empty($_SESSION['dni']) && !empty($_SESSION['rol']) && ($_SESSION['rol']==1)){ ?>
          <li class="nav-menu-item">
            <a href="miembro_principal.php" class="nav-menu-link nav-link nav-menu-link_active">Inicio</a>
          </li>
          <li class="nav-menu-item">
            <a href="seleccionar_miembro_director_academico.php" class="nav-menu-link nav-link">Personal</a>
          </li>
          <li class="nav-menu-item">
            <a href="gestionar_cursos.php" class="nav-menu-link nav-link">Cursos</a>
          </li>
          <li class="nav-menu-item">
            <a href="correo.php" class="nav-menu-link nav-link">Correo</a>
          </li>
          <li class="nav-menu-item">
            <a href="ver_informacion_personal.php" class="nav-menu-link nav-link">Información personal</a>
          </li>
          <li class="nav-menu-item">
            <a href="cerrar_sesion.php" class="nav-menu-link nav-link">Cerrar sesión</a>
          </li>
          <?php } ?>
        </ul>
      </nav>
    </header>