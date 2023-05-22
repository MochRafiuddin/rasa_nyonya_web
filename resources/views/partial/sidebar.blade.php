<?php 
    use App\Traits\Helper;  
?>
<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item">            
            <a class="nav-link" href="{{url('dashboard')}}">
                <i class="mdi mdi-view-dashboard-outline menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>            
        </li>        
        <li><hr></li>                
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-advanced" aria-expanded="false" aria-controls="ui-advanced">
                <i class="mdi mdi-folder-outline menu-icon"></i>
                <span class="menu-title">Master</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-advanced">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{route('area-index')}}">Area</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{route('wilayah-index')}}">Wilayah</a></li>                    
                    <li class="nav-item"> <a class="nav-link" href="{{route('customer-index')}}">Customer</a></li>                    
                </ul>
            </div>
        </li>    
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-advanced4" aria-expanded="false" aria-controls="ui-advanced">
                <i class="mdi mdi-account menu-icon"></i>
                <span class="menu-title">User</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-advanced4">
                <ul class="nav flex-column sub-menu">                    
                    <li class="nav-item"> <a class="nav-link" href="{{route('courier-index')}}">Kurir</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{route('admin-index')}}">Admin</a></li>                    
                    <li class="nav-item"> <a class="nav-link" href="{{route('user-index')}}">Akun</a></li>
                </ul>
            </div>
        </li>        
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-advanced1" aria-expanded="false" aria-controls="ui-advanced1">
                <i class="mdi mdi-cube-send menu-icon"></i>
                <span class="menu-title">Delivery</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-advanced1">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{route('order-index')}}">Delivery</a></li>                    
                </ul>
            </div>
        </li>        
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-advanced2" aria-expanded="false" aria-controls="ui-advanced1">
                <i class="mdi mdi-folder-multiple menu-icon"></i>
                <span class="menu-title">Report</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-advanced2">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{route('courier-performance-index')}}">Courier Performance</a></li>                    
                    <li class="nav-item"> <a class="nav-link" href="{{route('courier-fee-index')}}">Courier Fee</a></li>                    
                </ul>
            </div>
        </li>        
    </ul>
</nav>