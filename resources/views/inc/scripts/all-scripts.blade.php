 <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.slim.min.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
<script src="<?php echo url('/');?>/public/js/dropkick.js" type=""></script>
<?php 
	/*$urlName = request()->segment(1);
	//echo $urlName;
	$pages = array("addNewAnnouncment", "editAnnouncment");
	if (!in_array($urlName, $pages)){*/
?>
<script src="https://cdn.ckeditor.com/4.12.1/basic/ckeditor.js"></script>
<?php /*}*/ ?>
 
<!-- select box js -->
<script src="<?php echo url('/');?>/public/js/select.js" type=""></script>
<!-- jquery crop image -->

<!-- Croppie js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/1.5.12/clipboard.min.js"></script>
<script type='text/javascript' src='//platform-api.sharethis.com/js/sharethis.js#property=5cee20f276407d0012e034fa&product=inline-share-buttons' async='async'></script>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/series-label.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script type="text/javascript" src="<?php echo url('/');?>/public/js/jquery.ddslick.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script src="<?php echo url('/');?>/public/js/common.js" type=""></script>

<!-- SweetAlert2 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>

	<script type="text/javascript">
    $(document).ready(function(){

        var btn = document.getElementsByClassName('copy_btn');
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
    });
    // Sidebar scrollbar

    //notification read/unread
    $("#notification_btn").click(function(){
        $(".notify-drop-wrp").toggleClass('d-none');
        $("#wrapper2").removeClass('active');
        $("#pulse_btn").addClass('d-none');
        var token = "<?php echo csrf_token(); ?>";
        setTimeout(function(){
            $.ajax({
                url:'<?php echo url('/notificationStatusUpdate');?>',
                method: 'POST',
                dataType: "json",
                data:{'_token':token},
                success:function(data){
                    //console.log(data);
                }
            });
        },1000);
    });

    $(".user_profile_dropdown.user_profile_dropdown .wrapper2").click(function(){
        $(".notify-drop-wrp").removeClass('d-none').addClass('d-none');
    });

    $( ".navbar-primary, section" ).on( "click", function() {
        $(".notify-drop-wrp").removeClass('d-none').addClass('d-none');
        $("#wrapper2").removeClass('active');
    });

    $(document).ready(function(){
        //assign active class to all type of navigation based on document URL path
        var fullURL = window.location.href.split(/[?#]/)[0];
        $('.navbar-primary-menu li ul li a[href="'+ fullURL +'"]').addClass('active').closest('.child-menu-ul').show().prev('.child-menu-ul');    
        $('.navbar-primary-menu li a[href="'+ fullURL +'"]').addClass('active');

    });

    
</script>