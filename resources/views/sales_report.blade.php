<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BestBOX - Sales Report</title>
    <link rel="shortcut icon" href="<?php echo url('/public/images/');?>/favicon.png?q=<?php echo rand();?>" type="image/png" sizes="32x32" />
    <!-- All styles include -->
     @include("inc.styles.all-styles")
     <style type="text/css">
         #subs_type .dd-select{
            border: 1px solid transparent !important;
            background-color: #F7FBFF !important;
            top: -15px !important;
            position: relative;
        }
        #subs_type .dd-select.active{
            background: #fff !important;
            border: 1px solid #0096DA !important;
            border-radius: 5px !important;
        }
        #package_name .dd-select{
            border: 1px solid transparent !important;
            background-color: #F7FBFF !important;
            top: -15px !important;
            position: relative;
        }
        #package_name .dd-select.active{
            background: #fff !important;
            border: 1px solid #0096DA !important;
            border-radius: 5px !important;
        }
        .dd-options{
            border: solid 1px #0096DA !important;
            border-top: none !important;
            list-style: none;
            box-shadow: none !important;
            display: none;
            position: absolute;
            z-index: 2000;
            margin: 0;
            padding: 0;
            background: #fff;
            overflow: auto;
            /* top: 40px !important; */
            border-radius: 0px 0px 5px 5px !important;
         }



         .grid_header .dd-options{
            top: 37px !important;
         }

         .dd-option-selected{
             background-color: #0096DA;
         }
     </style>
</head>
<body>
    <!-- Side bar include -->
    @include("inc.sidebar.sidebar")
    <div class="main-content sales_transaction">
        <!-- Header Section Start Here -->
         @include("inc.header.header")
        <!-- Header Section End Here -->
        <section class="main_body_section scroll_div">

            <!-- Page Title Section 1 Mobile fixed -->
            <h5 class="f22 font-bold text-uppercase black_txt py-4 text-center text-sm-left">Sales Report</h5>
            <!-- Page Title Section 1 Mobile End -->

            <!-- Section 2 Mobile fixed -->
            <div class="row filter_wrp">

                <div class="col-12 col-sm-6 col-md-3 col-xl-2">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control bbcustinput" placeholder="User ID" id="searchKey" value="{{ $searchKey }}" aria-label="Recipient's username" aria-describedby="button-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-outline-primary px-2" type="button" id="button-addon2">
                                <img src="/public/images/search.png" class=" mt-0">
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Calender from -->
                <div class="col-12 col-md-6 col-lg-6 col-xl-5">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group row">
                                <label for="" class="col-sm-4 col-xl-3 col-form-label font16 dark-grey_txt small_resolution" style="line-height: 36px;">From</label>
                                <div class="col-12 col-sm-8 col-xl-9 pl-lg-0">
                                    <div id="fromDate" class="input-group date  m-0" data-date-format="mm-dd-yyyy">
                                        <input class="form-control datepicker_input" type="text" readonly id="from_date" value="<?php echo $from_date;?>"/>
                                        <span class="input-group-addon calender_icon"><i class="far fa-calendar-alt"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group row">
                                <label for="" class="col-sm-4 col-xl-3 col-form-label font16 dark-grey_txt small_resolution"
                                    style="line-height: 36px;">To</label>
                                <div class="col-12 col-sm-8 col-xl-9 pl-lg-0">
                                    <div id="toDate" class="input-group date  m-0"
                                        data-date-format="mm-dd-yyyy">
                                        <input class="form-control datepicker_input" type="text" readonly id="to_date" value="<?php echo $to_date;?>"/>
                                        <span class="input-group-addon calender_icon"><i
                                                class="far fa-calendar-alt"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Calender to end-->

                <!-- Filter btn -->
                <div class="col-6 col-sm-2 col-lg-1 px-md-1 mb-3 mb-sm-0">
                    <a href="javascript::void(0);" class="print_btn" id="filter_data">
                        Filter
                    </a>
                </div>

                <!-- Clear btn -->
                <div class="col-6 col-sm-2 col-lg-1 px-md-1 mb-3 mb-sm-0">
                    <a href="javascript::void(0);" class="print_btn" id="clear_filter_data">
                        Clear
                    </a>
                </div>

                <div class="col-6 col-sm-4 col-md-4 col-lg-2 col-xl-2 conquest-selection">
                    <div id="conquest-selection"></div>
                </div>

                 <div class="col-6 col-sm-2 col-lg-1 col-xl-1 px-md-1 mb-3 mb-sm-0">
                    <a href="javascript::void(0);" class="print_btn" id="print_data">
                    <i class="fas fa-print mx-3"></i>Print
                    </a>
                </div>

            </div>
            <!-- Filter section End-->
            <div class="grid_wrp d-none d-lg-block">
                <div class="grid_header clearfix pt-3 pb-3">
                    <div class="w9 float-left font16 font-bold blue_txt">Date</div>
                    <div class="w8 float-left font16 font-bold blue_txt pl-3">User ID</div>
                    <div class="w16 mx-2 float-left font16 font-bold blue_txt text-center no-border conquest-selection package_dropdn">
                        <div id="package_name"></div>
                    </div>
                    <div class="w17 mx-2 float-left font16 font-bold blue_txt text-center no-border conquest-selection package_dropdn">
                        <div id="subs_type"></div>
                    </div>
                    <div class="w9 float-left font16 font-bold blue_txt text-right pr-3">AliExpress <br> Amount (USD)</div>
                    <div class="w9 float-left font16 font-bold blue_txt text-right pr-3">BestBOX Wallet <br> Amount (USD)</div>
                    <div class="w9 float-left font16 font-bold blue_txt text-right pr-3">EverusPay <br>Amount (USD)</div>
                    <div class="w9 float-left font16 font-bold blue_txt text-right pr-3">Crypto Currency <br>Amount (USD)</div>
                    <div class="w9 float-left font16 font-bold blue_txt text-right pr-3">Bank Payment <br>Amount (USD)</div>
                </div>
            </div>

            <div class="middle_box clearfix d-none d-lg-block">
                <div class="grid_wrp">

                    <?php $total_sales_amount = 0;
                        $total_commision_amount = 0;
                        $aliexpress_sum = 0;
                        $wallet_sum = 0;
                        $everuspay_sum = 0;
                        $bitpay_sum = 0;
                        $bankpay_sum = 0;
                        ?>
                    <div class="grid_body clearfix">
                        @if($sales_report_data->count())
                        @foreach($sales_report_data as $item)
                            <!-- Row 1 -->
                            <?php
                            $total_sales_amount += $item['sales_amount'];
                            $total_commision_amount += $item['commission'];
                            if($item['purchased_from'] == 'Ali Express') {
                                $aliexpress_sum += $item['effective_amount'];
                            }else if($item['purchased_from'] == 'Wallet'){
                                $wallet_sum += $item['effective_amount'];
                            }else if($item['purchased_from'] == 'EVERUSPAY'){
                                $everuspay_sum += $item['effective_amount'];
                            }else if($item['purchased_from'] == 'Crypto Currency'){
                                $bitpay_sum += $item['effective_amount'];
                            }else if($item['purchased_from'] == 'BANK PAYMENT'){
                                $bankpay_sum += $item['effective_amount'];
                            }
                            ?>
                            <div class="grid_row clearfix">
                                <div class="w9 float-left font16 dark-grey_txt position-relative">
                                    @php
                                        echo \App\Http\Controllers\home\ReportController::convertTimezone($item['purchased_date']);
                                    @endphp
                                </div>
                                <div class="w8 float-left font16 dark-grey_txt pl-3">
                                    {{ $item['user_id'] }}
                                </div>
                                <div class="w16 float-left text-center font16 sales-blue pl-3">
                                    {{ $item['package_name'] }}
                                </div>
                                <div class="w17 float-left text-center pl-3">
                                    <div class="sales-btn {{ $item['type'] == 1 ? 'sales-btn-new' : 'sales-btn-renewal' }}">
                                        {{ $item['type'] == 1 ? 'New' : 'Renewal' }}
                                    </div>
                                </div>
                                <div class="w9 float-left font16 sales-green text-right pr-3">
                                    {{ $item['purchased_from'] == 'Ali Express' ? number_format($item['effective_amount'],2) : '0.00' }}
                                </div>

                                <div class="w9 float-left font16 sales-green text-right pr-3">
                                    {{ $item['purchased_from'] == 'Wallet' ? number_format($item['effective_amount'],2) : '0.00' }}
                                </div>

                                <div class="w9 float-left font16 sales-green text-right pr-3">
                                   {{ $item['purchased_from'] == 'EVERUSPAY' ? number_format($item['effective_amount'],2) : '0.00' }}
                                </div>
                                <div class="w9 float-left font16 sales-green text-right pr-3">
                                   {{ $item['purchased_from'] == 'Crypto Currency' ? number_format($item['effective_amount'],2) : '0.00' }}
                                </div>
                                <div class="w9 float-left font16 sales-green text-right pr-3">
                                   {{ $item['purchased_from'] == 'BANK PAYMENT' ? number_format($item['effective_amount'],2) : '0.00' }}
                                </div>
                            </div>

                            @endforeach
                              <div class="grid_row clearfix">
                                  <div class="w9 float-left ">&nbsp;</div>
                                  <div class="w8 float-left ">&nbsp;</div>
                                  <div class="w16 float-left ">&nbsp;</div>
                                  <div class="w17 float-left  font-weight-bold black-txt text-center f18">Total(USD)</div>
                                  <div class="w9 float-left text-right font-weight-bold black-txt pr-3 f18">{{ number_format($aliexpress_sum,2) }}</div>
                                  <div class="w9 float-left text-right font-weight-bold black-txt pr-3 f18">{{ number_format($wallet_sum,2) }}</div>
                                  <div class="w9 float-left text-right font-weight-bold black-txt pr-3 f18">{{ number_format($everuspay_sum,2) }}</div>
                                  <div class="w9 float-left text-right font-weight-bold black-txt pr-3 f18">{{ number_format($bitpay_sum,2) }}</div>
                                  <div class="w9 float-left text-right font-weight-bold black-txt pr-3 f18">{{ number_format($bankpay_sum,2) }}</div>
                              </div>
                        @else
                            <div class="w100 norecord_txt">No Records Found</div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Table details Mobile view End -->

            @if($sales_report_data->count()>0)
            <div class="total_calc_wrp clearfix d-none d-lg-block">
                <div class="w20 float-left">&nbsp;</div>
                <div class="w30 float-left">&nbsp;</div>
                <div class="w16 green_txt font-bold text-right font16 float-left"></div>
                <div class="w16 float-left">&nbsp;</div>
                <div class="w18 grey_txt font-bold text-right font16 float-left pr-3"></div>
            </div>

            <div class="total_calc_wrp clearfix d-block d-lg-none">
                <div class="w50 black_txt font-bold text-left font12 float-left"></div>
                <div class="w50 grey_txt font-bold text-right font12 float-left pr-5"></div>
            </div>
            @endIf
            @if($sales_report_data->total()>0)
                <?php echo $sales_report_data->appends(['searchKey'=>$searchKey,'from_date' => $from_date, 'to_date' => $to_date, 'type' => $purchased_from, 'subs_type' => $subs_type, 'package_name' => $package_name])->links();?>
            @endIf
        </section>
    </div>
    <!-- All scripts include -->
    @include("inc.scripts.all-scripts")
    <script type="text/javascript">
     var url = "<?php echo url('/salesReport'); ?>";

        $("#button-addon2").on('click',function(){

            var searchKey = $("#searchKey").val().trim();
            location.href = url+'?searchKey='+searchKey+'&from_date=&to_date=&status=&page=0';
        });

        /* filter data */
        $("#filter_data").click(function(e){
            e.preventDefault();
            var from_date = $("#from_date").val().trim();
            from_date2 = new Date(from_date);
            var to_date = $("#to_date").val().trim();
            to_date2 = new Date(to_date);
            var searchKey = $("#searchKey").val().trim();
            if(from_date == '' || to_date == '') {
                alert('Please select both from and to date');
                return false;
            }else if(to_date2 < from_date2 ) {
                alert('To date should be grater than From Date');
                return false;
            }else{
                var searchUrl = url+'?searchKey='+searchKey+'&from_date='+from_date+'&to_date='+to_date+'&page=0';
                location.href=searchUrl;
            }

        });

        /* clear filter data */
        $("#clear_filter_data").click(function(e){
            e.preventDefault();
            $("#from_date").val('');
            $("#to_date").val('');
            var searchUrl = url+'?from_date=&to_date=&page=0';
            location.href=searchUrl;
        });

        /* filter data */
        var page = '<?php echo $page;?>';
        $("#print_data").click(function(e){
            e.preventDefault();
            if(page == '' || page == 0){
                page = 0;
            }
            var from_date = $("#from_date").val().trim();
            var from_date2 = new Date(from_date);
            var to_date = $("#to_date").val().trim();
            var to_date2 = new Date(to_date);
            var searchKey = $("#searchKey").val().trim();
            var type=$('#conquest-selection .dd-selected-value').val();
            var subs_type=$('#subs_type .dd-selected-value').val();
            var package_id=$('#package_name .dd-selected-value').val();
            if((from_date != '' && to_date != '') && to_date2 < from_date2 ) {
                alert('To date should be grater than From Date');
                return false;
            }else{
                var searchUrl = url+'?searchKey='+searchKey+'&from_date='+from_date+'&to_date='+to_date+'&page='+page+'&type='+type+'&subs_type='+subs_type+'&package_name='+package_id+'&print=yes';
                location.href=searchUrl;
            }

        });

        $(document).ready(function(){
            $("#fromDate").datepicker({
                minDate : 0,
                autoclose: true,
                todayHighlight: true,
                endDate: "today",
                onSelect: function(selected) {
                 $("#toDate").datepicker("option","minDate", selected)
               }
            });

            $("#toDate").datepicker({
                minDate : 0,
                autoclose: true,
                todayHighlight: true,
                endDate: "today",
                onSelect: function(selected) {
                   $("#fromDate").datepicker("option","maxDate", selected)
                }
            });
        });

    </script>
    <script>
        $(document).ready(function() {
            $(".set > a").on("click", function() {
                if ($(this).hasClass("active")) {
                $(this).removeClass("active");
                $(this)
                    .siblings(".content")
                    .slideUp(200);
                $(".set > a i")
                    .removeClass("fa-angle-up")
                    .addClass("fa-angle-down");
                } else {
                $(".set > a i")
                    .removeClass("fa-angle-up")
                    .addClass("fa-angle-down");
                $(this)
                    .find("i")
                    .removeClass("fa-angle-down")
                    .addClass("fa-angle-up");
                $(".set > a").removeClass("active");
                $(this).addClass("active");
                $(".content").slideUp(200);
                $(this)
                    .siblings(".content")
                    .slideDown(200);
                }
            });
        });
    </script>

    <script>
        $(document).ready(function(){
            $(".dropdown-menu li").click(function(){
                $(this).addClass("selected");
            });

            var ptSort = [
                { text: "All Payment Types", value: '',selected:'<?php if($purchased_from==''){ echo true;} ?>', },
                { text: "Ali Express", value: 'Ali Express',selected:'<?php if($purchased_from=='Ali Express'){ echo true;} ?>', },
                { text: "Wallet", value: 'Wallet',selected:'<?php if($purchased_from=='Wallet'){ echo true;} ?>', },
                { text: "EVERUSPAY", value: 'EVERUSPAY',selected:'<?php if($purchased_from=='EVERUSPAY'){ echo true;} ?>', },
                { text: "Crypto Currency Payment", value: 'Crypto Currency',selected:'<?php if($purchased_from=='Crypto Currency'){ echo true;} ?>', },
                { text: "BANK PAYMENT", value: 'BANK PAYMENT',selected:'<?php if($purchased_from=='BANK PAYMENT'){ echo true;} ?>', }
            ];

            var f=0;
            $('#conquest-selection').ddslick({
                data: ptSort,
                selectText: "Select Type",
                truncateDescription: true,
                onSelected: function (data) {
                     var type = data.selectedData.value;
                     var package_id=$('#package_name .dd-selected-value').val();
                     var subs_type=$('#subs_type .dd-selected-value').val();
                     if(f!=0){
                        location.href = url+'?searchKey=&from_date=&to_date=&status=&page=0&type='+type+'&subs_type='+subs_type+'&package_name='+package_id;
                     }
                    f++;
                }
            });

            var ddSort = [
                { text: "Subscription Type", value: '',selected:'<?php if($subs_type==''){ echo true;} ?>', },
                { text: "New", value: '1',selected:'<?php if($subs_type=='1'){ echo true;} ?>', },
                { text: "Renewal", value: '2',selected:'<?php if($subs_type=='2'){ echo true;} ?>', }
            ];
            var f1=0;
            $('#subs_type').ddslick({
                data: ddSort,
                selectText: "Subscription Type",
                truncateDescription: true,
                onSelected: function (data) {
                     var subs_type = data.selectedData.value;
                     var package_id=$('#package_name .dd-selected-value').val();
                     var type=$('#conquest-selection .dd-selected-value').val();
                     if(f1!=0){
                        location.href = url+'?searchKey=&from_date=&to_date=&status=&page=0&type='+type+'&subs_type='+subs_type+'&package_name='+package_id;
                     }
                    f1++;
                }
            });

            var pkgdata = <?php echo $packages_list;?>;
            var f2=0;
             $('#package_name').ddslick({
                data: pkgdata,
                truncateDescription: true,
                onSelected: function (data) {
                     var package_id = data.selectedData.value;
                     var subs_type=$('#subs_type .dd-selected-value').val();
                     var type=$('#conquest-selection .dd-selected-value').val();
                      if(f2!=0){
                        location.href = url+'?searchKey=&from_date=&to_date=&status=&page=0&type='+type+'&subs_type='+subs_type+'&package_name='+package_id;
                        }
                    f2++;
                }
            });

            $('.dd-select').on('click',function(){
               if($(".dd-select").not( this ).hasClass('active')){
                    $(".dd-select").removeClass('active');
                }
           });

            $("#subs_type .dd-select").click(function(){

                if($("#subs_type .dd-select").hasClass('active')){
                    $("#subs_type .dd-select").removeClass('active');
                }else{
                    $("#subs_type .dd-select").addClass('active');
                }
           });
            $('#package_name .dd-select').click(function(){

                if($("#package_name .dd-select").hasClass('active')){
                    $("#package_name .dd-select").removeClass('active');
                }else{
                    $("#package_name .dd-select").addClass('active');
                }
           });
           $('body').click(function() {
                if($("#subs_type .dd-select").hasClass('active')){
                    $("#subs_type .dd-select").removeClass('active');
                }

                if($("#package_name .dd-select").hasClass('active')){
                    $("#package_name .dd-select").removeClass('active');
                }
           });

        });

    </script>
</body>
</html>
