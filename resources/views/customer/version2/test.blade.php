<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1 maximum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="<?php echo url('/public/images/');?>/favicon.png?q=<?php echo rand();?>" type="image/png" sizes="32x32" />
    <title>BestBox Live tv Player</title>
    <!-- Styles -->
    <link href="<?php echo url('/');?>/public/css/customer/app.css" rel="stylesheet">
    <link href="<?php echo url('/');?>/public/css/customer/bsnav.css" rel="stylesheet">
    <!-- All old styles include -->
    <link rel="stylesheet" href="<?php echo url('/');?>/public/customer/css/customer-style.css?q=<?php echo rand();?>">
    <link rel="stylesheet" href="<?php echo url('/');?>/public/customer/css/global.css?q=<?php echo rand();?>">
    <link rel="stylesheet" href="<?php echo url('/');?>/public/css/share.css?q=<?php echo rand();?>">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" href="<?php echo url('/public/images/');?>/favicon.png?q=<?php echo rand();?>" type="image/png" sizes="32x32" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.min.css">
    <!-- Mobile Responsive styles -->
    <link rel="stylesheet" href="<?php echo url('/');?>/public/customer/css/customer_resoponsive.css?q=<?php echo rand();?>">

</head>

<body>
    @include('inc.v2.sidenav')

    <div class="main-wrap w-100">
        <div class="container-fluid">
            @include('inc.v2.headernav')

            <!-- border -->
            <hr class="grey-dark">

            <div class="row">

            </div>
        </div>
    </div>

     @include('inc.v2.footer')


</body>

</html>
