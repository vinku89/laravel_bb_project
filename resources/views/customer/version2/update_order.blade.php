<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1 maximum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="<?php echo url('/public/images/');?>/favicon.png?q=<?php echo rand();?>" type="image/png" sizes="32x32" />
    <title>BestBOX - Update Order</title>
    <!-- Styles -->
    <link href="<?php echo url('/');?>/public/css/customer/app.css" rel="stylesheet">
    <link href="<?php echo url('/');?>/public/css/customer/bsnav.css" rel="stylesheet">

    <!-- All old styles include -->
    @include("customer.inc.v2.all-styles")
    <!-- for tracking -->
    <script src="https://www.datadoghq-browser-agent.com/datadog-rum-eu.js" type="text/javascript">
    </script>
    <script>
      window.DD_RUM && window.DD_RUM.init({
        clientToken: 'pub36cb304d6b4093ef35d15e60b03c3772',
        applicationId: '04797c6b-7265-4dc6-802a-1e896506548b',
        trackInteractions: true,
      });
    </script>
    <!-- for tracking -->
</head>

<body>
    @include('inc.v2.sidenav')

    <div class="main-wrap w-100">
        <div class="container-fluid">
            @include('inc.v2.headernav')

            <div class="row">
                <!-- border -->
                <hr class="grey-dark">
                <section class="customer_main_body_section scroll_div col-12">
                    <div class="order_wrapper updateOrder_form">
                        <h3 class="font22 font-bold py-3 text-white">Update Order</h3>
                        <a href="<?php echo url('/updatedOrdersList');?>" class="btn_primary orderBtn">Order History</a>
                        <p class="py-4 text-white f16">
                            Please update your payment order to process your activation.
                        </p>
                        <form class="mw-450" id="updateOrderDetailsForm" name="updateOrderDetailsForm" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="font-bold text-white">* Enter Payment ID / Reference</label>
                                <input type="text" class="form-control border-bottom-only body_bg mt-3" id="order_id" name="order_id" aria-describedby="Payment ID" placeholder="Payment ID / Reference" value="">
                                <div class="f12" style="color:red" id="paymentIdErr"></div>
                            </div>


                            <div class="font-bold text-white mt-5">Upload attachment</div>
                            <div class=" d-table w-100 my-3">
                                <label for="order-upload" class="d-table-cell w30">Choose file<input type="file" id="order-upload" name="invoice_attachment" accept="image/*,application/pdf" class="order-upload "></label>
                                <div class="d-table-cell w5"></div>
                                <span id="filename" class="d-table-cell w65">No file choosen</span>
                                <div class="f12" style="color:red" id="attachmentErr"></div>
                            </div>

                            <div class="text-center f12 text-white mt-3">Allowed file type : jpg, jpeg, png and PDF. maximum file size : 2MB</div>

                            <div class="my-5">
                                <div class="d-block d-md-inline-block mr-2">
                                    <a href="{{ url('/updatedOrdersList') }}" class="btn_cancel d-block text-center">
                                        CANCEL
                                    </a>
                                </div>

                                <div class="d-block d-md-inline-block">
                                    <button type="submit" class="btn_primary d-block w-100 mt-4 d-block text-center" id="updateOrderDetails">SUBMIT</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </section>
            </div>
        </div>
    </div>

     @include('inc.v2.footer')
     <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    <script>
        $("#cls_btn").click(function(){
            location.href="<?php echo url('/updatedOrdersList');?>";
        });
        function reload() {
            location.reload(true);
        }

        $("#order-upload").change(function () {
            var fileExtension = ['jpeg', 'jpg', 'png', 'gif', 'pdf'];
            if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
                $("#attachmentErr").html('Please Upload only JPEG,JPG,PNG or PDF formats only');
                return false;
            }else if(this.files[0].size>2097152) {
                $("#attachmentErr").html('File size must be less than 2MB!');
                return false;
            }
            var filepath = this.value;
            var m = filepath.match(/([^\/\\]+)$/);
            var filename = m[1];
            $('#filename').html(filename);

        });

        $("#updateOrderDetailsForm").on("submit", function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                var order_id = $("#order_id").val().trim();
                var error = false;
                if(order_id == ''){
                    $("#paymentIdErr").html('Payment ID Required');
                    error = true;
                }else{
                    $("#paymentIdErr").html('');
                }
                var fileName = $("#order-upload").val();
                if(fileName !=''){
                    var fileExtension = ['jpeg', 'jpg', 'png', 'gif', 'bmp'];
                    if ($.inArray(fileName.split('.').pop().toLowerCase(), fileExtension) == -1) {
                        $("#attachmentErr").html('Please Upload only JPEG,JPG,PNG or PDF formats only');
                        error = true;
                    }else{
                        $("#attachmentErr").html('');
                    }
                }

                if(!error){
                    $.ajax({
                        type: 'POST',
                        url: "<?php echo url('/');?>/updateCustomerOrderDetails",
                        data: new FormData(this),
                        processData: false,
                        contentType: false,
                        success: function(data) {
                            if (data.status == "Success") {
                                setTimeout(function() {
                                    swal({
                                        title: "Success",
                                        html: "<p>Thank you for your purchase. We shall endeavor to action this at the earliest. Please feel free to try our numerous chains of support media, Email, WhatsApp, in Site chat box.</p><br><p>However, please note that the activation / response can take between 30 mins and 8 hours.</p><br><p>Thank you for choosing BestBOX</p>",
                                        type: "success"
                                    }).then(function() {
                                        location.reload(true);
                                    });
                                }, 50);
                            } else {
                                swal({
                                  title: "Failure",
                                  html: data.message,
                                  type: "error",
                                });
                            }
                        }
                    });
                }
            });
    </script>
</body>

</html>
