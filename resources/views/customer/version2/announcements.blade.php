<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1 maximum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BestBOX - Notifications</title>
    <link rel="shortcut icon" href="<?php echo url('/public/images/');?>/favicon.png?q=<?php echo rand();?>" type="image/png" sizes="32x32" />
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
                <section class="main_body_section scroll_div col-12">
                    <!-- border -->
                    <hr class="grey-dark">
                    <div class=" clearfix">
                        <a href="<?php echo url('/').'/notifications';?>" class="btn btn-secondary">Transaction Notifications</a>
                        <a href="<?php echo url('/').'/announcements';?>" class="btn btn-primary mx-3">General Notifications</a>
                    </div>
                    <h5 class="font16 text-white font-bold text-uppercase pt-4 pb-3">General Notifications</h5>

                    <!-- Filter section -->
                    <div class="filter_wrp col-12">
                        <div class="row">
                            <div class="col-lg-6 col-md-8 xsmall-pad">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group row">
                                            <label for="" class="col-sm-3 col-form-label font16 text-white small_resolution"
                                                style="line-height: 36px;">From</label>
                                            <div class="col-sm-9">
                                                <div id="fromDate" class="input-group date  m-0"
                                                    data-date-format="mm-dd-yyyy">
                                                    <input class="form-control datepicker_input" type="text" readonly id="from_date" value="<?php echo $from_date;?>"/>
                                                    <span class="input-group-addon calender_icon"><i
                                                            class="far fa-calendar-alt"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group row">
                                            <label for="" class="col-sm-3 col-form-label font16 text-white small_resolution"
                                                style="line-height: 36px;text-align:center">To</label>
                                            <div class="col-sm-9 pl-0">
                                                <div id="toDate" class="input-group date  m-0"
                                                    data-date-format="mm-dd-yyyy">
                                                    <input class="form-control datepicker_input" type="text" readonly id="to_date" value="<?php echo $to_date;?>" />
                                                    <span class="input-group-addon calender_icon"><i
                                                            class="far fa-calendar-alt"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-4 xsmall-pad">
                                <div class="row">
                                    <div class="col-lg-3 col-sm-6 mb-3">
                                        <a href="javascript::void(0);" class="print_btn" id="filter_data">
                                            Filter
                                        </a>
                                    </div>
                                    <div class="col-lg-3 col-sm-6">
                                        <a href="javascript::void(0);" class="print_btn" id="clear_filter_data">
                                            Clear
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Filter section End-->
                    <div class="grid_wrp">
                        <div class="grid_header clearfix pt-3 pb-3 res_mobileView">
                            <div class="w30 float-left font16 font-bold text-white">Date</div>
                            <div class="w60 float-left font16 font-bold text-white pl-2 d-none d-lg-block">Subject</div>
                            <div class="w10 float-left font16 font-bold text-white text-right pr-3">&nbsp;</div>
                        </div>
                    </div>

                    <div class="middle_box clearfix">
                        <div class="grid_wrp">
                            <div id="accordion">
                                <div class="grid_body clearfix">
                                    <!-- Row 1 -->
                                    <?php
                                    if($announcements_data->count()){
                                    foreach($announcements_data as $key=>$item){
                                        $announce_user_list = unserialize($item['users']);
                                        if(!empty($announce_user_list)){
                                        foreach($announce_user_list as $an_data){
                                        if($an_data['rec_id'] == $userInfo['rec_id']){?>
                                     <div class="card res_mobileView">
                                        <div class="mb-0">
                                            <a class="collapsed grid_row clearfix"  data-toggle="collapse" href="#collapse-{{ $key }}" aria-expanded="false" aria-controls="collapse-{{ $key }}">
                                                <div class="w30 float-left font16 text-white position-relative">
                                                    @php
                                                        echo \App\Http\Controllers\home\ReportController::convertTimezone($item['created_at']);
                                                    @endphp
                                                </div>
                                                <div class="w60 float-left font16 text-white pl-2 d-none d-lg-block"><?php echo $item['title'];?></div>
                                                <div class="w10 float-left font16 blue_txt text-right ">
                                                    <i class="fas fa-chevron-down text-white"></i>
                                                    <i class="fas fa-chevron-up text-white"></i>
                                                </div>
                                            </a>
                                        </div>

                                        <div id="collapse-{{ $key }}" class="collapse content_div" data-parent="#accordion" aria-labelledby="heading-2">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-12 col-lg-6 border-right responsive_brdr">
                                                        <ul>
                                                            <li class="li_width float-left">Subject</li>
                                                            <li class="dark-grey_txt">{{ $item['title'] }}</li>
                                                            <li class="li_width float-left">Message</li>
                                                            <li class="dark-grey_txt ml-200"><?php echo $item['description'];?></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php 
                                    }
                                }
                            }

                                    }
                                    }else{?>
                                    <div class="w100 norecord_txt">No Records Found</div>
                                   <?php }?>
                                    @if($announcements_data->total()>0)
                                    <?php echo $announcements_data->appends(['from_date' => '', 'to_date' => ''])->links(); ?>
                                    @endIf

                                </div>
                            </div>
                        </div>
                    </div>

                </section>
            </div>
        </div>
    </div>

     @include('inc.v2.footer')

    <script type="text/javascript">
     var url = "<?php echo url('/announcements'); ?>";

     /* filter data */
     $("#filter_data").click(function(e){
        e.preventDefault();
        var from_date = $("#from_date").val().trim();
        var to_date = $("#to_date").val().trim();
        if(from_date == '' || to_date == '') {
            alert('Please select both from and to date');
            return false;
        }else if(to_date < from_date ) {
            alert('To date should be grater than From Date');
            return false;
        }else{
            var searchUrl = url+'?from_date='+from_date+'&to_date='+to_date+'&page=0';
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

    $(document).ready(function(){
        $("#fromDate").datepicker({
          autoclose: true,
          todayHighlight: true,
          endDate: "today"
        });

        $("#toDate").datepicker({
            autoclose: true,
            todayHighlight: true,
            endDate: "today"
        });
    });
    </script>
</body>

</html>
