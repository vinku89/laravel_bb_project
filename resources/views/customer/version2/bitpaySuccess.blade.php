<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BestBOX Bitpay Integration - Success</title>
    <link rel="shortcut icon" href="favicon.png?q=<?php echo rand();?>" type="image/png" sizes="32x32" />
    <!-- All styles include -->
    @include('customer.inc.all-styles')
</head>
<body>
    <!-- Side bar include -->
    @include('inc.sidebar.sidebar')
    <div class="main-content customer_pannel customer-wr">
        <!-- Header Section Start Here -->
        @include('inc.header.header')
        <!-- Header Section End Here -->
        <section class="customer_main_body_section scroll_div p-0">
            <div class="container-fluid">
                <?php echo $successData;?>
            </div>
        </section>
    </div>
</body>
</html>