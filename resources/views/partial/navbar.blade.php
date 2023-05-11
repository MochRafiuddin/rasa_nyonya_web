<?php 
use App\Traits\Helper;
?>
<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo w-100"><img src="{{asset('/')}}assets/images/my-company-removebg-preview.png" alt="logo" /></a>
        <!-- <a class="navbar-brand brand-logo-mini" href="index.html"><img src="{{asset('/')}}assets/images/logo-mini.svg" alt="logo" /></a> -->
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="mdi mdi-menu"></span>
        </button>
        <ul class="navbar-nav navbar-nav-right">            
            <li class="nav-item nav-profile dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
                    <img src="{{asset('/')}}assets/images/user.png" alt="profile" />
                    @php
                        $nama=explode(" ",Auth::user()->username);
                    @endphp
                    <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{$nama[0]}}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                    <h6 class="dropdown-header text-center">{{Auth::user()->username}}</h6>
                    <div class="dropdown-divider"></div>                    
                    <a class="dropdown-item" href="{{url('logout')}}">
                        <i class="mdi mdi-logout text-primary"></i>
                        Logout
                    </a> 
                </div>
            </li>
            <!-- <li class="nav-item nav-settings d-none d-lg-block">
                <a class="nav-link" href="#">
                    <i class="mdi mdi-apps"></i>
                </a>
            </li> -->
        </ul>

    </div>
</nav>
@push('js')
<script>    
    
    $('body').on('click', '.notifbaru', function () {
        var user = $(this).data('user');
        $.ajax({          
          url: "{{ url('update-user-new-notif') }}/"+user,
          type: "GET",
          dataType: 'json',
          success: function (data) {
            $("#baru").remove();         
          },
          error: function (data) {
              console.log('Error:', data);
          }
      });
    });

    function clickUrl(selectObject,i,u) {        
        var url='{{url("")}}/'+u;
        jQuery.ajax({
            type: 'GET',
            url: '{{ url("update-notif") }}/'+i,
            success: function(result) {
                selectObject.removeAttribute("style");
                window.open(url,"_self");
            }
        });
    }
    
    function CkUrl(u) {        
        var url='{{url("")}}/'+u;        
        window.open(url,"_self");            
    }

</script>
@endpush