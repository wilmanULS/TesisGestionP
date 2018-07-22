<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
{{--
<li><a href="{{ backpack_url('dashboard') }}"><i class="fa fa-dashboard"></i> <span>{{ trans('backpack::base.dashboard') }}</span></a></li>
<li><a href="{{ backpack_url('log') }}"><i class="fa fa-terminal"></i> <span>Logs</span></a></li>
<li><a href='{{ url(config('backpack.base.route_prefix', 'admin') . '/setting') }}'><i class='fa fa-cog'></i> <span>Settings</span></a></li>
<li><a href="{{backpack_url('page') }}"><i class="fa fa-file-o"></i> <span>Pages</span></a></li>

  <li><a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/menu-item') }}"><i class="fa fa-list"></i> <span>Menu</span></a></li>
--}}

  <!-- ADMINISTRADOR MENÚ-->

  @can('Usuarios')

  <!-- Users, Roles Permissions -->
  <li class="treeview">
    <a href="#"><i class="fa fa-group"></i> <span>Users, Roles, Permissions</span> <i class="fa fa-angle-left pull-right"></i></a>
    <ul class="treeview-menu">
      <li><a href="{{ backpack_url('user') }}"><i class="fa fa-user"></i> <span>Users</span></a></li>
      <li><a href="{{ backpack_url('role') }}"><i class="fa fa-group"></i> <span>Roles</span></a></li>
      <li><a href="{{ backpack_url('permission') }}"><i class="fa fa-key"></i> <span>Permissions</span></a></li>
    </ul>
  </li>

  <li><a href="{{ backpack_url('Periodo') }}"><i class="fa fa-calendar-check-o"></i> <span>Peridos Académicos</span></a></li>
  <li><a href="{{ backpack_url('Formato') }}"><i class="fa fa-bookmark"></i> <span>Formatos Objeto Aprendizaje</span></a></li>
  <li><a href="{{ backpack_url('Recurso') }}"><i class="fa fa-tag"></i> <span>Tipo Recurso Educativo</span></a></li>
  <li><a href="{{ backpack_url('Idioma') }}"><i class="fa fa-wechat"></i> <span>Idiomas Objeto Aprendizaje</span></a></li>
  <li><a href="{{ backpack_url('Dificultad') }}"><i class="fa fa-adn"></i> <span>Dificultad Objeto Aprendizaje</span></a></li>
  <li><a href="{{ backpack_url('Nivel') }}"><i class="fa fa-address-book"></i> <span>Nivel Cognoscitivo</span></a></li>
  @endcan
@can('Asignaturas')

@endcan


  <!-- DOCENTE MENÚ-->
@can('Mis Asignaturas')
  <li><a href="{{ url('/Docente/contenidoCompetencias') }}"><i class="fa fa-desktop"></i> <span>Mis Asignaturas</span></a></li>
  @endcan
@can('Competencias')
  <li><a href="{{ url('/Docente/competencias') }}"><i class="fa fa-lightbulb-o"></i> <span>Competencias</span></a></li>
  @endcan
@can('Contenido y Temas')

  <li class="treeview">
    <a href="#"><i class="fa fa-bookmark"></i> <span>Contenido & Temas</span> <i class="fa fa-angle-left pull-right"></i></a>
    <ul class="treeview-menu">
      <li><a href="{{ url('/Docente/index/AgregarContenido') }}"><i class="fa fa-calendar"></i> <span>Semanas</span></a></li>
    </ul>
  </li>

@endcan
@can('Objetos de Aprendizaje')
  <li class="treeview">
    <a href="#"><i class="fa fa-archive"></i> <span>Objetos de Aprendizaje</span> <i class="fa fa-angle-left pull-right"></i></a>
    <ul class="treeview-menu">
      <li><a href="{{ url('/Docente/Indextemas/ingresarOA') }}"><i class="fa fa-plus-circle"></i> <span>Ingresar Obj Aprendizaje</span></a></li>
    </ul>
  </li>

@endcan

@can('Planificacion Curso')

  <li><a href="{{ url('/Docente/planificacionCurso/temas') }}"><i class="fa fa-archive"></i> <span>Planificación Curso</span></a></li>

@endcan

@can('Seguimiento Curricular')


@endcan




  <!-- ACADÉMICO MENÚ-->
@can('Designar Curso')
  <li><a href="{{ url('/Academico/designarAsignatura') }}"><i class="fa fa-user"></i> <span>Designar Curso</span></a></li>
@endcan