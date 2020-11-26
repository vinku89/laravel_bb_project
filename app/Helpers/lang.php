<?php
  require_once __DIR__ . '/../../vendor/autoload.php';
  use \Statickidz\GoogleTranslate;
if (!function_exists('lang')) {

    function lang($text)
    {
    	
        $source = 'es';
// $target = 'ta'; //thamil
$target = 'te'; 
// $text = 'buenos días';
// $text = 'What r u doing';
$trans = new GoogleTranslate();
$result = $trans->translate($source, $target, $text);
echo $result;
 
    }
}
 
