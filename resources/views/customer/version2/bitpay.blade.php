<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BestBOX Bitpay Integration</title>
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
            <form action="https://bitpay.com/checkout" method="post">
                <input type="hidden" name="action" value="checkout" />
                <input type="hidden" name="posData" value="<?php echo $postData;?>" />
                <input type="hidden" name="data" value="66k52dy+wpnAqon6R1hHUPYwZRFwDJqhhthCClAPpwYsQWYFThllSCpDBnrgQCWlUsQo4aNA2Z2ltzVUPNCgAH65b7kRKFmjTBccv78+sMiGxTfcHABkqBvnTB8SOyylJDiPg3eaMbsuOUkUsA5RWQ==" />
                <input type="image" src="https://bitpay.com/cdn/en_US/bp-btn-pay-currencies.svg" name="submit" style="width: 210px" alt="BitPay, the easy way to pay with bitcoins.">
            </form>
            </div>
        </section>
    </div>
</body>
</html>