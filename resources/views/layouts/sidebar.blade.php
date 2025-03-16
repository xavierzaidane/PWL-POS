<div class="sidebar">
<!-- SidebarSearch Form -->
<div class="form-inline mt-2">
    <div class="input-group" data-widget="sidebar-search">
        <input class="form-control form-control-sidebar" type="search"
placeholder="Search" aria-label="Search">
    <div class="input-group-append">
        <button class="btn btn-sidebar">
            <i class="fas fa-search fa-fw"></i>
        </button>
            </div>
        </div>
    </div>
<!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview"
    role="menu" data-accordion="false">
        <li class="nav-item">
            <a href="{{ url('/') }}" class="nav-link {{ ($activeMenu == 'dashboard')?
'active' : '' }} ">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>Dashboard</p>
        </a>
    </li>
    <li class="nav-header">User Data</li>
    <li class="nav-item">
        <a href="{{ url('/user') }}" class="nav-link {{ ($activeMenu == 'user')?
'active' : '' }}">
    <i class="nav-icon far fa-user"></i>
    <p>Data User</p>
    </a>
    </li>
    <li class="nav-header">Categorization</li>
    <li class="nav-item">
        <a href="{{ url('/level') }}" class="nav-link {{ ($activeMenu ==
        'level')? 
'active' : '' }} ">
    <i class="nav-icon far fa-bookmark"></i>
    <p>Data Level</p>
    </a>
    </li>
    <li class="nav-item">
    <a href="{{ url('/kategori') }}" class="nav-link {{ ($activeMenu == 'kategori')?
'active' : '' }} ">
    <i class="nav-icon far fa-list-alt"></i>
    <p>Data Kategori</p>
    </a>
    </li>
    <li class="nav-header">Transaction Data</li>
    <li class="nav-item">
    <a href="{{ url('/supplier') }}" class="nav-link {{ ($activeMenu == 'supplier')?
'active' : '' }} ">
    <i class="nav-icon fas fa-cubes"></i>
    <p>Data Supplier</p>
    </a>
    </li>
    <li class="nav-item">
    <a href="{{ url('/barang') }}" class="nav-link {{ ($activeMenu == 'barang')?
'active' : '' }} ">
    <i class="nav-icon fas fa-cash-register"></i>
    <p>Data Barang</p>
                </a>
            </li>
        </ul>
    </nav>
</div>