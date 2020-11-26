<!-- Google translate script start -->
<script type="text/javascript">
	$.cookie('googtrans', '/en/te');
</script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
	<script src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
	<script>
		$(document).ready(function(){
			var date = new Date();
			date.setTime(date.getTime() + (60 * 1000));
			//$.cookie('googtrans', '/en/te');  // expires after 1 minute
			//window.location.href= window.location.href+"";
			
		});
		
		
		//document.cookie = 'googtrans=;expires=Thu, 01 Jan 1970 00:00:01 GMT;';
//setcookie("googtrans", '/en/te', time() + 3600);
function googleTranslateElementInit() {
  new google.translate.TranslateElement({
    pageLanguage: 'en'
  }, 'google_translate_element');
    
}

</script>

<?php
//setcookie("googtrans", "sd", time()+3600,'/','bestbox.net');
?>
	
	<!-- Google translate script end -->