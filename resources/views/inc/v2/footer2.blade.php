<?php
$pageUrl = \Request::segment(1);
?>
<footer class="py-2 <?php echo ($pageUrl == 'CatchupView') ? 'd-none' : '';?>" style="background-color: #303030;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 text-center">
                <p class="mt-3 text-white">
                    This site is fully compatible with 
                    <span class="mx-1"><img src="<?php echo url('/');?>/public/website/assets/images/google-chrome.png" class="img-fluid" style="width: 22px; height: auto;"></span> Google Chrome and 
                    <span class="mx-1"><img src="<?php echo url('/');?>/public/website/assets/images/firefox.png" class="img-fluid"></span> Mozilla Firefox browsers
                </p>
            </div>
        </div>
    </div>
</footer>

<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
    integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
</script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
    integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
</script>-->
<!--old scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>

<!-- new js -->
<script src="https://rawgit.com/fitodac/bsnav/master/dist/bsnav.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js"></script>

<script type="text/javascript" src="<?php echo url('/');?>/public/js/customer/prettify.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js" type="text/javascript"></script>


<!-- new js ends-->
<script src="<?php echo url('/');?>/public/js/dropkick.js" type=""></script>
<script src="https://cdn.ckeditor.com/4.12.1/basic/ckeditor.js"></script>
<!-- select box js -->
<script src="<?php echo url('/');?>/public/js/select.js" type=""></script>
<!-- Croppie js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/1.5.12/clipboard.min.js"></script>
<script type='text/javascript' src='//platform-api.sharethis.com/js/sharethis.js#property=5cee20f276407d0012e034fa&product=inline-share-buttons' async='async'></script>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/series-label.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script type="text/javascript" src="<?php echo url('/');?>/public/js/jquery.ddslick.min.js"></script>

<!--<script src="<?php echo url('/');?>/public/customer/js/common.js?rand=(99,9999)" type=""></script>-->

<!-- SweetAlert2 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js" defer></script>
<!-- <script type="text/javascript" src="<?php echo url('/');?>/public/js/customer/dropdown.js"></script> -->
<?php 
    //for popup  announcement
    $date = date('Y-m-d');
    $anouncement_messages = '';
    $loggedUserData = Session::get('userData');
    $announcement_list = \App\Announcements::where('expiry_date','>=',$date)->orwhereNull('expiry_date')->where('announcement_type',2)->orderby('id','desc')->get();
    $k = 0;$flag = 0;
    foreach($announcement_list as $list) {
        $users_list = unserialize($list['users']);
        if(!empty($users_list)){
            foreach($users_list as $user){
                if($loggedUserData['rec_id'] == $user['rec_id'] && $user['flag'] == 1){
                    if($k!=0 && $flag == 1) {
                        $anouncement_messages .= "<hr style='border-top: 1px solid #979797; height: 1px; margin: 0 40px; padding-top: 15px;'>";
                    }
                    $anouncement_messages .= "<div class='noti-body-title text-center text-md-left'>SUBJECT :</div>";
                    $anouncement_messages .= "<div style='' class='noti-body-text-big pl-3 pb-2 text-center text-md-left'>".$list['title']."</div>";

                    $anouncement_messages .= "<div  class='noti-body-title text-center text-md-left'>MESSAGE :</div>";
                    $anouncement_messages .= "<div style='' class='noti-body-text pl-3 pb-2 text-center text-md-left'>".$list['description']."</div>";
                    $flag =1; $k++;  
                }
            }
        }
    }
            
            if($anouncement_messages != ''){?>
                <!-- Free trail expired modal -->
                    
                    <!-- Modal -->
                    <div class="modal fade" id="announcementPopup" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable">
                            <div class="modal-content" style="border-radius: 10px !important;">
                                <div class="modal-header px-4 py-3" style="border: 0;">
                                    <div class="row w-100 m-auto">
                                        <div class="col-md-6 text-md-left text-center d-none d-md-block">
                                            <span><img src="<?php echo url('/');?>/public/images/notif_new.png" style="width: 30px; height: auto"></span>
                                            <span style="font-family: 'Multicolore'; font-size: 17px; color: #000; margin-left: 10px;">NOTIFICATION</span>
                                        </div>
                                        <div class="col-md-6 text-md-right text-center">
                                            <img src="<?php echo url('/');?>/public/images/notification_bestbox.png" style="width: 120px; height: auto;">
                                        </div>
                                    </div>
                                    
                                </div>
                                <hr class="pt-2" style="border-top: 1px solid #979797; height: 1px; margin: 0 40px;">

                                <div class="col-md-6 text-md-left text-center d-block d-md-none py-3">
                                    <span><img src="<?php echo url('/');?>/public/images/notification_ico.png" style="width: 30px; height: auto;"></span>
                                    <span style="font-family: 'Multicolore'; font-size: 17px; color: #000; margin-left: 10px;">NOTIFICATION</span>
                                </div>
                                <div class='modal-body noti-body px-md-5 px-3 pb-2 pb-md-2 pt-0 pt-md-2'>
                                    <?php echo $anouncement_messages;?>
                                </div>
                            <div class="modal-footer p-0">
                                <button type="button" class="btn btn-secondary btn-yellow p-3" id="announcementPopup_flag_update" data-dismiss="modal" >OK</button>
                            </div>
                            </div>
                        </div>
                    </div>
                    <script type="text/javascript">
                    $(document).ready(function () {
                        var pageUrl = "<?php echo \Request::segment(1);?>";
                        //if(pageUrl != 'webseries' || pageUrl != 'webseriesDetailsList' || pageUrl != 'webseriesEpisodeView' || pageUrl != 'webseriesList'){
                            //$.noConflict();
                        //}
                        
                        $("#announcementPopup").modal("show");
                        
                    });
                    </script>
            <?php }?>

    <script>
    $(document).on('click', 'announcementPopup_flag_update', function(e){
        e.preventDefault();
        var token = "<?php echo csrf_token() ?>";
        
        $.ajax({
            url: "<?php echo url('/');?>/announcementPopup_flag_update",
            method: 'POST',
            dataType: "json",
            data: {
                'flag': 0,
                "_token": token
            },
            success: function (data) {
                if (data.status == 'Success') {
                    $("#announcementPopup").modal("hide");
                } 
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError);
            }
        });
    });
    </script>


<?php 
    $session_data = session('userData');
    if(isset($session_data) && isset($session_data['user_logged_device_rec_id']) && !empty($session_data['user_logged_device_rec_id'])) {
    $user_logout = \App\UsersDevicesList::where(['rec_id' => $session_data['user_logged_device_rec_id'], 'is_login' => 0, 'device_type' => 'web'])->first();
    }
    if(!empty($user_logout)) {?>
        <!-- Alert Modal -->
        <div class="modal" id="logoutalertModal" tabindex="-1" role="dialog" aria-labelledby="myModal" aria-hidden="true" data-backdrop="static" data-keyboard="false" data-toggle="modal">
        <div class="modal-dialog">
            <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title font-bold red_txt">Alert</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body text-center red_txt">
            You have been logged out as your account has reached the maximum login limit of 2 devices per account.
            </div>
            <!-- Modal footer -->
            <!-- Modal footer -->
            <div class="inline-buttons p-3 text-center">
                <button type="button" class="btn inline-buttons-center btn-primary mx-1 btn-sm px-4"
                    data-dismiss="modal">OK</button>
            </div>
            </div>
        </div>
        </div>
        <script type="text/javascript">
        $(document).ready(function () {
            var pageUrl = "<?php echo \Request::segment(1);?>";
            //if(pageUrl != 'webseries' || pageUrl != 'webseriesDetailsList' || pageUrl != 'webseriesEpisodeView' || pageUrl != 'webseriesList'){
                //$.noConflict();
            //}
            $("#logoutalertModal").modal("show");
                
            setTimeout(() => {
                location.href = "<?php echo url('/').'/logout';?>";
            }, 2000);
        });
        </script>
    <?php }
    ?>
<script type="text/javascript">
    $(document).ready(function(){


        var elements = $(document).find('select.form-control');
        for (var i = 0, l = elements.length; i < l; i++) {
            var $select = $(elements[i]),
                $label = $select.parents('.form-group').find('label');
               
            $select.select2({
                allowClear: false,
                placeholder: $select.data('placeholder'),
                minimumResultsForSearch: 0,
                theme: 'bootstrap',
                width: '100%' 
                // https://github.com/select2/select2/issues/3278
            });

            // Trigger focus
            $label.on('click', function (e) {
                $(this).parents('.form-group').find('select').trigger('focus').select2('focus');
            });

            // Trigger search
            $select.on('keydown', function (e) {
                var $select = $(this),
                    $select2 = $select.data('select2'),
                    $container = $select2.$container;

                // Unprintable keys
                if (typeof e.which === 'undefined' || $.inArray(e.which, [0, 8, 9, 12, 16, 17, 18, 19, 20, 27,
                        33, 34, 35, 36, 37, 38, 39, 44, 45, 46, 91, 92, 93, 112, 113, 114, 115, 116, 117,
                        118, 119, 120, 121, 123, 124, 144, 145, 224, 225, 57392, 63289
                    ]) >= 0) {
                    return true;
                }

                // Opened dropdown
                if ($container.hasClass('select2-container--open')) {
                    return true;
                }

                $select.select2('open');

                // Default search value
                var $search = $select2.dropdown.$search || $select2.selection.$search,
                    query = $.inArray(e.which, [13, 40, 108]) < 0 ? String.fromCharCode(e.which) : '';
                if (query !== '') {
                    $search.val(query).trigger('keyup');
                }
            });

            // Format, placeholder
            $select.on('select2:open', function (e) {
                var $select = $(this),
                    $select2 = $select.data('select2'),
                    $dropdown = $select2.dropdown.$dropdown || $select2.selection.$dropdown,
                    $search = $select2.dropdown.$search || $select2.selection.$search,
                    data = $select.select2('data');

                // Above dropdown
                if ($dropdown.hasClass('select2-dropdown--above')) {
                    $dropdown.append($search.parents('.select2-search--dropdown').detach());
                }

                // Placeholder
                $search.attr('placeholder', (data[0].text !== '' ? data[0].text : $select.data('placeholder')));
            });
        }


        var btn = document.getElementsByClassName('copyBtn');
        var clipboard = new Clipboard(btn);

        clipboard.on('success', function(e) {
            swal(
                'Success',
                'Referal link copied to clipboard',
                'success'
            )
        });

        clipboard.on('error', function(e) {
                console.log(e);
        });

        //notification read/unread
        $("#notify_btn").on('click', function() {
            //console.log('hi');
            var token = "<?php echo csrf_token(); ?>";
            setTimeout(function(){
                $.ajax({
                    url:'<?php echo url('/notificationStatusUpdate');?>',
                    method: 'POST',
                    dataType: "json",
                    data:{'_token':token},
                    success:function(data){
                        
                    }
                });
            },1000);
        });
    });
    // Sidebar scrollbar

    

    $( ".navbar,  section, .section_div" ).on( "click", function() {
        $(".profile").removeClass("active");
        $(".notifications").removeClass("active");
    });

    $(document).ready(function(){
        //assign active class to all type of navigation based on document URL path
        var fullURL = window.location.href.split(/[?#]/)[0];
        $('.navbar-primary-menu li ul li a[href="'+ fullURL +'"]').addClass('active').closest('.child-menu-ul').show().prev('.child-menu-ul');    
        $('.navbar-primary-menu li a[href="'+ fullURL +'"]').addClass('active');

    });

    
</script>

<script>
    $(document).ready(function(){
        var today = new Date(); 
        var day = today.getDate();
        var month = today.getMonth() + 1;
        var year = today.getFullYear();
        var hours = today.getHours();
        var minutes = today.getMinutes();
        var seconds = today.getSeconds();

        if (day < 10) {
          day = '0' + day;
        }
        if (month < 10) {
          month = '0' + month;
        }
        if (hours < 10) {
          hours = '0' + hours;
        }
        if (minutes < 10) {
          minutes = '0' + minutes;
        }
        if (seconds < 10) {
          seconds = '0' + seconds;
        }

        var time = year+'-'+month+'-'+day+' '+hours+':'+minutes+':'+seconds; 

        document.cookie='datecookie='+time;//-->missing cookie name and concatenation
    });
</script>

 <script>

        // $(document).click(function () {
        //     $(".notifications, .profile").removeClass("active");
        // });

        $(".profile .icon_wrap").click(function () {
            //setTimeout(function(){ 
                $(this).parent().toggleClass("active");
                $(".notifications").removeClass("active");
           // }, 500);
        });

        $(".notifications .icon_wrap").click(function () {
            //setTimeout(function(){ 
                $(this).parent().toggleClass("active");
                $(".profile").removeClass("active");
            //},500);
        });

        $(".show_all .link").click(function () {
            //setTimeout(function(){
                $(".notifications").removeClass("active");
                $(".popup").show();
            //},500);
        });

        $(".close, .shadow").click(function () {
            //setTimeout(function(){
                $(".popup").hide();
            //},500);
        });

        // $(".main-wrap").mCustomScrollbar();

    </script>
    <?php if($pageUrl == 'vod' || $pageUrl == 'vodCategory' || $pageUrl == 'vodDetailView' || $pageUrl == 'livetv' || $pageUrl == 'livetvDetails' || $pageUrl == 'livetvChannelView' || $pageUrl == 'webseriesDetailsList'){?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <?php }?>
<script src="https://malihu.github.io/custom-scrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.js"></script>

<script>
// $(window).load(function(){
//     $(".epg-list").mCustomScrollbar({
//     });
// });

</script>

<!-- loader -->
<script type="text/javascript">
    $(document).ready(function(){
        setTimeout(function(){
            jQuery(".sk-circle").hide();
        },3000);
    });
</script>

