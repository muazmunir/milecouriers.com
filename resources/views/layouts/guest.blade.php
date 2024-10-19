<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="keywords" content="">
        <meta name="author" content="pixelstrap">
        <link rel="icon" href="/backend/assets/images/favicon.png" type="image/x-icon">
        <link rel="shortcut icon" href="/backend/assets/images/favicon.png" type="image/x-icon">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;300;400;500;600;700;800&amp;display=swap" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="/backend/assets/css/font-awesome.css">
        <link rel="stylesheet" type="text/css" href="/backend/assets/css/vendors/icofont.css">
        <link rel="stylesheet" type="text/css" href="/backend/assets/css/vendors/themify.css">
        <link rel="stylesheet" type="text/css" href="/backend/assets/css/vendors/flag-icon.css">
        <link rel="stylesheet" type="text/css" href="/backend/assets/css/vendors/feather-icon.css">
        <link rel="stylesheet" type="text/css" href="/backend/assets/css/vendors/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="/backend/assets/css/style.css">
        <link id="color" rel="stylesheet" href="/backend/assets/css/color-1.css" media="screen">
        <link rel="stylesheet" type="text/css" href="/backend/assets/css/responsive.css">
    </head>
    <body>
        <!-- login page start-->
        <div class="container-fluid p-0">
            <div class="row m-0">
                <div class="col-12 p-0">
                    @yield('content') 
                </div>
            </div>
            <script src="/backend/assets/js/jquery.min.js"></script>
            <script src="/backend/assets/js/bootstrap/bootstrap.bundle.min.js"></script>
            <script src="/backend/assets/js/icons/feather-icon/feather.min.js"></script>
            <script src="/backend/assets/js/icons/feather-icon/feather-icon.js"></script>
            <script src="/backend/assets/js/config.js"></script>
            <script src="/backend/assets/js/script.js"></script>
        </div>
    </body>
</html>