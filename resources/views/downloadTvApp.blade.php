
<!--<!DOCTYPE html>
<html lang="en">
<head>
  <title>BestBox</title>
  <meta charset="utf-8">-->
<!--  <meta name="viewport" content="width=device-width, initial-scale=1 maximum-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
-->
<!--</head>
<body>



<div class="container">
  <div class="row">
    <div class="col-sm-12">-->
     <?php
	set_time_limit(0);
        //header("location:".url('/')."/public/Tvapp/tv-release.apk");
        header("location:".url('/')."/public/Tvapp/BestBOX.apk");
                exit(0);
		/*$fileName = "tv-release.apk"; //basename('codexworld.txt');
		$filePath = url('/').'/public/Tvapp/'.$fileName;
		if(!empty($fileName)){

			// Define headers
			header("Cache-Control: public");
			header("Content-Description: File Transfer");
			header("Content-Disposition: attachment; filename=$fileName");
			header("Content-Type: application/zip");
			header("Content-Transfer-Encoding: binary");

			// Read the file
			//readfile($filePath);
			exit;
		}else{
			echo 'The file does not exist.';
		}	*/

		$apk = "tv-release.apk";
		//$file = url('/').'/public/Tvapp/'.$fileName; //not public folder
//		$file = 'https://staging.bestbox.net/public/Tvapp/'.$fileName; //not public folder
//		echo $file;
//		exit;
		 $file = './public/Tvapp/'.$apk;
		if(!empty($file) //&& $fp=fopen($file,"rb")
) {

		//	header('Content-Description: File Transfer');
		//	header('Content-Type: application/vnd.android.package-archive');
		//	header('Content-Disposition: attachment; filename='.$fileName);
			//header('Content-Transfer-Encoding: binary');
			//header('Content-Type: application/force-download');
			//header('Expires: 0');
			//header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		//	header('Pragma: public');
			header('Content-Disposition: attachment; filename='.$apk);
header('Content-Type: application/vnd.android.package-archive');
header('Content-Length: '.filesize($file));
echo file_get_contents($file);
			//header('Content-Length: ' . filesize($file));

			//ob_clean();
			//flush();
		//	readfile($file);
			//passthru($file);
			//echo filesize($file);
                       // echo fread($fp,filesize($file));    //read write to the browser
                       // fclose($fp);
			//exit;
		}else{
			echo "testes";
		}

	?>
  <!--  </div>

  </div>
</div>

</body>
</html>-->
