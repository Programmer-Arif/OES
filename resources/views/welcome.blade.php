<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.2/dist/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <title>Document</title>
</head>
<body>
    <nav>
        <div>
            <a id="logobox" href="/"><img src="{{ asset('images/logo.JPG') }}" alt=""></a>
        </div>
        <div>
            <button id="registerbutton" type="button" class="btn btn-primary">Register</button>
            <button id="loginbutton" type="button" class="btn btn-primary">Login</button>
        </div>
    </nav>
    <div id="banner">
        <div id="bannertext">
            <h1>Online Examination System</h1>
            <h5>Get online test series along with free mock test</h5>
            <h5>For class I-X</h5>
            <button type="button" id="getstartedbutton" class="btn btn-primary">Get Started <i class="fa-solid fa-arrow-right"></i></button>
        </div>
        <div id="bannerimg">
            <img src="{{ asset('images/banner.png') }}" alt="">
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

    <script src="{{ asset('js/script.js') }}"></script>
    <script>
        document.getElementById('registerbutton').addEventListener('click',()=>{
            location.href='/account/register';
        });
        document.getElementById('loginbutton').addEventListener('click',()=>{
            location.href='/account/login';
        });
        document.getElementById('getstartedbutton').addEventListener('click',()=>{
            location.href='/account/register';
        });
    </script>
</body>
</html>