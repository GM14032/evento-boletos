<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="index" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ URL::asset('build/images/logo-sm.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('build/images/logo-dark.png') }}" alt="" height="17">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="index" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ URL::asset('build/images/logo-sm.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('build/images/logo-light.png') }}" alt="" height="17">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span> menu')
                    </span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="/"  role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                        <i class="mdi mdi-speedometer"></i> <span> Home
                        </span>
                    </a>

                </li> <!-- end Dashboard Menu -->
                @if(auth()->check() && auth()->user()->id_rol != 3)
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarApps">
                        <i class="mdi mdi-view-grid-plus-outline"></i> <span> Gestion de eventos
                        </span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarApps">
                        <ul class="nav nav-sm flex-column">
                         <!--   <li class="nav-item">
                                <a href="tables-datatables" class="nav-link">DataTable</a>
                            </li>-->
                            <li class="nav-item">
                                <a href="eventos.eventos" class="nav-link">Eventos</a>
                            </li>
                            <li class="nav-item">
                                <a href="eventos.lecturaBoletos" class="nav-link">Leer Boletos</a>
                            </li>

                        </ul>
                    </div>
                </li>
                @endif
                @if(auth()->check() && auth()->user()->id_rol == 1)
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarApps" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarApps">
                        <i class="mdi mdi-account-box-multiple"></i> <span> Gestion de usuarios
                        </span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarApps">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="usuarios" class="nav-link">Motrar usuarios</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('register') }}" class="nav-link">Agregar usuarios</a>
                            </li>

                        </ul>
                    </div>
                </li>
                @endif
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
    <div class="sidebar-background"></div>
</div>
<!-- Left Sidebar End -->
<!-- Vertical Overlay-->
<div class="vertical-overlay"></div>
