<!doctype html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Porikha</title>
      {{-- <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}"> --}}
      <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.2/dist/css/bootstrap.min.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
      <link rel="stylesheet" href="{{ asset('css/dash-style.css') }}">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
   </head>
   <body>
        <div class="wrapper">
            <div class="main-container">
                <nav class="navbar navbar-expand-md bg-white shadow bsb-navbar bsb-navbar-hover bsb-navbar-caret">
                    <div class="container">
                        <div>
                            <a id="logobox" href="/"><img src="{{ asset('images/logo.JPG') }}" alt=""></a>
                        </div>
                        <a class="navbar-brand" href="#">
                           <strong>Online Examination System</strong>
                        </a>
                        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                            <div class="offcanvas-body">
                                <ul class="navbar-nav justify-content-end flex-grow-1">
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" href="#!" id="accountDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">{{ Auth::user()->name }} <i class="fa-solid fa-user"></i></a>
                                        <ul class="dropdown-menu border-0 shadow bsb-zoomIn" aria-labelledby="accountDropdown">                          
                                            <li>
                                                <a class="dropdown-item" href="{{ route('account.logout') }}">Logout</a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </nav>

                <div class="main">
                
                
                

                    @yield('work-space')
    
    
    
                </div>

            </div>
            
        </div>
    

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
        
        
   </body>
</html>