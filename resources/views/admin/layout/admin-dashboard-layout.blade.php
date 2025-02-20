<!doctype html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Porikha:Admin</title>
      {{-- <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}"> --}}
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
      <link rel="stylesheet" href="{{ asset('css/dash-style.css') }}">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
   </head>
   <body>
        <div class="wrapper">
            <aside id="sidebar">
                <div class="d-flex">
                    <button class="toggle-btn" type="button">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                    <div class="sidebar-logo">
                        
                    </div>
                </div>
                <ul class="sidebar-nav">
                    <li class="sidebar-item {{ request()->routeIs('admin.dashboard')?'active':'' }}">
                        <a href="{{ route('admin.dashboard') }}" class="sidebar-link">
                            <i class="fa-brands fa-slack"></i>
                            <span>Subjects</span>
                        </a>
                    </li>
                    <li class="sidebar-item {{ request()->routeIs('admin.viewExams')?'active':'' }}">
                        <a href="{{ route('admin.viewExams') }}" class="sidebar-link">
                            <i class="fa-solid fa-book"></i>
                            <span>Exams</span>
                        </a>
                    </li>
                    <li class="sidebar-item {{ request()->routeIs('admin.viewQNA')?'active':'' }}">
                        <a href="{{ route('admin.viewQNA') }}" class="sidebar-link">
                            <i class="fa-solid fa-clipboard-question"></i>
                            <span>Q&A</span>
                        </a>
                    </li>
                    <li class="sidebar-item {{ request()->routeIs('admin.viewStudents')?'active':'' }}">
                        <a href="{{ route('admin.viewStudents') }}" class="sidebar-link">
                            <i class="fa-solid fa-user"></i>
                            <span>Students</span>
                        </a>
                    </li>
                    <li class="sidebar-item {{ request()->routeIs('admin.viewMarks')?'active':'' }}">
                        <a href="{{ route('admin.viewMarks') }}" class="sidebar-link">
                            <i class="fa-solid fa-list-check"></i>
                            <span>Marks</span>
                        </a>
                    </li>
                    <li class="sidebar-item {{ request()->routeIs('admin.viewReview')?'active':'' }}">
                        <a href="{{ route('admin.viewReview') }}" class="sidebar-link">
                            <i class="fa-solid fa-file-text"></i>
                            <span>Review</span>
                        </a>
                    </li>
                    
                    
                    {{-- <li class="sidebar-item">
                        <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                            data-bs-target="#auth" aria-expanded="false" aria-controls="auth">
                            <i class="fa-solid fa-thumbtack"></i>
                            <span>Auth</span>
                        </a>
                        <ul id="auth" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                            <li class="sidebar-item">
                                <a href="#" class="sidebar-link">Login</a>
                            </li>
                            <li class="sidebar-item">
                                <a href="#" class="sidebar-link">Register</a>
                            </li>
                        </ul>
                    </li>
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                            data-bs-target="#multi" aria-expanded="false" aria-controls="multi">
                            <i class="fa-solid fa-thumbtack"></i>
                            <span>Multi Level</span>
                        </a>
                        <ul id="multi" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                            <li class="sidebar-item">
                                <a href="#" class="sidebar-link collapsed" data-bs-toggle="collapse"
                                    data-bs-target="#multi-two" aria-expanded="false" aria-controls="multi-two">
                                    Two Links
                                </a>
                                <ul id="multi-two" class="sidebar-dropdown list-unstyled collapse">
                                    <li class="sidebar-item">
                                        <a href="#" class="sidebar-link">Link 1</a>
                                    </li>
                                    <li class="sidebar-item">
                                        <a href="#" class="sidebar-link">Link 2</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li> --}}
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link">
                            <i class="fa-solid fa-thumbtack"></i>
                            <span>Notification</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link">
                            <i class="fa-solid fa-gear"></i>
                            <span>Setting</span>
                        </a>
                    </li>
                </ul>
                <div class="sidebar-footer">
                    <a href="{{ route('admin.logout') }}" class="sidebar-link">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        <span>Logout</span>
                    </a>
                </div>
            </aside>
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
                                        <a class="nav-link dropdown-toggle" href="#!" id="accountDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">{{ Auth::guard('admin')->user()->name }} <i class="fa-solid fa-user"></i></a>
                                        <ul class="dropdown-menu border-0 shadow bsb-zoomIn" aria-labelledby="accountDropdown">                          
                                            <li>
                                                <a class="dropdown-item" href="{{ route('admin.logout') }}">Logout</a>
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
        
        {{-- <script src="{{ asset('js/popper.js') }}"></script> --}}

        <script>
            const hamBurger = document.querySelector(".toggle-btn");

            hamBurger.addEventListener("click", function () {
            document.querySelector("#sidebar").classList.toggle("expand");
            });
        </script>

        <script src="{{ asset('js/script.js') }}"></script>
   </body>
</html>