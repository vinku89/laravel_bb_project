<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Exception</title>
    <meta name="viewport" content="width=device-width, initial-scale=1 maximum-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Exo+2:400,500,600,700" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="">
    <style type="text/css" nonce="jfsdjlfu907fds3">
        * {
            line-height: 1.2;
            margin: 0;
        }
        html {
            /*color: #fff;*/
            display: table;
            font-family: 'Exo 2', sans-serif;
            height: 100%;
            text-align: center;
            width: 100%;
        }
        body {
            display: table-cell;
            background-color: #fff;
        }
        h1 {
            /*color: #555;*/
            font-size: 2em;
            font-weight: 400;
            color: #333 !important;
        }
        p {
            margin: 0 auto;
            width: 280px;
            color: #333 !important;
        }
        .font-xxl{

            font-size: 120px;

        }

        .content{

            vertical-align: middle;
            margin: 80px auto;


        }

        .btn-green {
            background-color: #2CB8B1;
            color: #fff; }
        .btn-green:hover {
          background-color: #3da7a2;
          color: #fff; }
        .btn-green[disabled]:hover {
          background-color: #2CB8B1; }

        .btn {
            font-weight: 600;
            padding: 8px 15px;
            border-radius: 2px;
            transition: .15s ease all;
            border: 0;
            margin-right: 5px;
            margin-bottom: 5px;
            box-shadow: inset 0 -2px 0 rgba(0, 0, 0, 0.2);
            cursor: pointer;
            text-decoration: none;}

        .btn-lg, .btn-group-lg > .btn {
            padding: 10px 22px;
            font-size: 16px; }

            .space-1 {
                margin-bottom: 12px; }

                .space-2 {
                margin-bottom: 24px; }

                .space-3 {
                margin-bottom: 36px; }

                .space-4 {
                margin-bottom: 48px; }

                .space-5 {
                margin-bottom: 60px; }

                .space-6 {
                margin-bottom: 72px; }

                @media (min-width: 992px){

                .width-50{
                    width: 50%;
                    margin: 0 auto;
                }

            }


        @media only screen and (max-width: 280px) {
            body, p {
                width: 95%;
            }
            h1 {
                font-size: 1.5em;
                margin: 0 0 0.3em;
                color: #333 !important;
            }
        }
		.sorppad{
			padding: 10px;
		}
		.test404{
			width: calc(354px/2); height: auto; margin-top: 50px;
		}
    </style>
</head>
<body>
    <div class="container">
    <?php
    $url=url('/');
        if (strpos(url('/'), 'index.php') !== false) {
            $url=str_replace("index.php","",url('/'));
        }
    ?>
        <div class="space-3"><img src="<?php echo $url;?>/public/images/white-logo.png" class="test404"  /></div>

        <div class="content">
            <img src="<?php echo $url;?>/public/images/403_error.png"/>
                <div class="width-50 sorppad" >

                    <h1 class="space-3">File size is too large</h1>
                </div>

            <div class="">
                <a href="<?php echo $url;?>" class="btn btn-green btn-lg">Back to Home page</a>
            </div>
        </div>

    </div>
</body>
</html>
