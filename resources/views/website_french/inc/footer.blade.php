<!-- Footer -->
<?php 
    if($lang == 'english') $whatsapp_support_number = 971527925634;
    else if($lang == 'french') $whatsapp_support_number = 33643377592;
?>
<div class="fixed-social-icons">
   <a href="https://wa.me/971527925634" target="_blank"><img src="<?php echo url('/');?>/public/images/whatsapp_icon.png" class="img-fluid"></a>
</div>
<footer class="pt-5 footer position-relative">
    <div class="container">

      <div class="row">
        <div class="col-md-9">
          <div class="footer-logo pb-4">
            <img src="<?php echo url('/');?>/public/website/assets/images/logo.png" class="img-fluid">
          </div>
          <div class="footer-links">
            <ul class="row font-bold">
              <li class="col-md-3"><a href="#streaming" class="scroll">Unlimited Streaming</a></li>
              <!--<li class="col-md-3"><a href="#subscribenow" class="scroll">Subscribe Now</a></li>-->
              <li class="col-md-3"><a href="#refer" class="scroll">Refer Your Friends</a></li>
              <li class="col-md-3"><a href="#faq" class="scroll">FAQ</a></li>
              <li class="col-md-3"><a href="<?php echo url('/').'/terms_of_use';?>" target="_blank" class="">Terms Of Use</a></li>
              <li class="col-md-3"><a href="<?php echo url('/').'/purchasing_terms';?>" target="_blank" class="">Purchasing Terms</a></li>
              <li class="col-md-3"><a href="<?php echo url('/').'/privacy_policy';?>" target="_blank">Privacy Policy </a></li>
            </ul>
          </div>
        </div>

        <div class="col-md-3">
          <h4 class="text-white pb-4">Contact Us:</h4>
          <div class="text-white f16 pb-3"><span class="text-yellow">Sales</span>: sales@bestbox.net</div>
          <div class="text-white f16 pb-3"><span class="text-yellow">Logistice</span>: logistic@bestbox.net</div>
          <div class="text-white f16 pb-3"><span class="text-yellow">Reseller or Agent</span>: reseller@bestbox.net</div>
          <div class="text-white f16 pb-3"><span class="text-yellow">Support</span>: support@bestbox.net</div>
        </div>
      </div>

      <div class="row py-4">
        <div class="col-lg-12 text-white text-center">
          <p class="font-bold m-auto">Copyright &copy; Bestbox / Monte International Trade (Tianjin) Co Ltd. All trademarks and copyrights belong to their respective owners.</p>
        </div>
      </div>
    </div>
    <!-- /.container -->
  </footer>

  <!-- Bootstrap core JavaScript -->
  <script src="<?php echo url('/');?>/public/website/assets/vendor/jquery/jquery.min.js"></script>
  <script src="<?php echo url('/');?>/public/website/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<?php echo url('/');?>/public/website/assets/js/scripts.js"></script>
  <!-- End of LiveChat code -->
   <script>
   $('.carousel').carousel({
      interval: 3000,
      pause: false
   });
   //$(document).ready(function(){
      //alert();
      $(document.body).on('click','.select_lang',function(){
      //$(".select_lang").change(function(){
         //alert();
         var lang=$(this).attr('data-language');
         var csrf_Value = "<?php echo csrf_token(); ?>";
         $.ajax({
            url: "<?php echo url('/');?>/change_lang",
            method: 'POST',
            async:"false",
            dataType: "json",
            data:{'_token':csrf_Value, 'lang' : lang},
            success: function(data) {
               location.reload();
            }
         })
      });
   //});
   
   </script>
   <!-- <script type="text/javascript">
      window.__lc = window.__lc || {};
      window.__lc.license = 10948082;
      (function () {
         var lc = document.createElement('script');
         lc.type = 'text/javascript';
         lc.async = true;
         lc.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'cdn.livechatinc.com/tracking.js';
         var s = document.getElementsByTagName('script')[0];
         s.parentNode.insertBefore(lc, s);
      })();
   </script>
<noscript>
   <a href="https://www.livechatinc.com/chat-with/10948082/" rel="nofollow">Chat with us</a>,
   powered by <a href="https://www.livechatinc.com/?welcome" rel="noopener nofollow" target="_blank">LiveChat</a>
</noscript> -->
</body>
</html>