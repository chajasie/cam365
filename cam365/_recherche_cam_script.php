<?php
	error_reporting(0);
    $interval = 240;
	$fileName = 'livepic/current.jpg';
	//$url = 'http://10-0-37-25--rhb82vu0a906y1taeekg.vpncam.ch/record/current.jpg';
	$url = "10-0-37-25--rhb82vu0a906y1taeekg.vpncam.ch";
	$fp = fsockopen($url , 80, $errno, $errstr, 5);
	if ($fp){
		$exists = true;
	}else{
		$exists = false;
		$files = scandir('archiv/middle/',0);
		$picCount = -1;
		$months = array('01','02','03','04','05','06','07','08','09','10','11','12');
		for($i=0;$i<count($files);$i++){
			if(!is_dir($files[$i])){
				$folderYear = $files[$i];
				$yearFiles = scandir('archiv/middle/' . $folderYear,0);

				for($y=0;$y<count($yearFiles);$y++){
					if (in_array($yearFiles[$y], $months)) {
						$monthFolder = $yearFiles[$y];
						$monthFiles = scandir('archiv/middle/' . $folderYear . '/' .  $yearFiles[$y], 0);
						for($m=0;$m<count($monthFiles);$m++){
							if(strpos($monthFiles[$m],'.jpg')){
										$picCount++;
										$pics[$picCount] = 'archiv/middle/' . $folderYear . '/' .  $monthFolder . '/' . $monthFiles[$m];
							}
						}
					}
				}
			}
		}
		$currentPic = $picCount;
	}

   if($exists){
	 	$file = filectime('livepic/current.jpg');
		if(time() - $file > $interval){
			copy('http://10-0-37-25--rhb82vu0a906y1taeekg.vpncam.ch/record/current.jpg', 'livepic/current.jpg');
		}
	}else{
		$fileName = $pics[$currentPic];
	}
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Obermoeliholz - STUTZ + BOLT + PARTNER</title>
	<base url="support-vor-ort.ch/obermoeliholz/" />

	<!-- CSS Styles -->
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/bootstrap-responsive.min.css" rel="stylesheet">
	<link href="css/lightbox.css" rel="stylesheet" />
	<link href="css/customized.css" rel="stylesheet">

</head>

<body onload="JavaScript:refresh(<?php echo $interval*1000; ?>);">
	<div class="header">
		<div class="navbar navbar-default container">
			<div class="navbar-inner row-fluid">
				<div class="container">
					<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</a>
					<a class="navbar-brand visible-phone" href="#">support vor ort gmbh</a>
					<div class="nav-collapse">
						<ul class="nav navbar-nav pull-left">
							<li class="first active">
								<a href="index.php" >Live Bild</a>
							</li>
							<li class="last">
								<a href="archiv/index.php" >Archiv</a>
							</li>
						</ul>
						<div class="projectName pull-right">
							<h1>Ober Möliholz</h1>
						</div>
						<a href="http://s-v-o.ch/" class="hidden-phone">
							<img id="logoPic" src="images/svo_logo.png" alt="support vor ort gmbh" />
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
    <div class="container contentContainer camRecording">
		<div class="featurette">
			<div class="row-fluid">
				<div class="span8">
					<a href='livepic/current.jpg?<?php echo rand(11111111, 1972355); ?>' data-lightbox="image-1">
						<img src='livepic/current.jpg?<?php echo rand(11111111, 1972355); ?>' name='camimage'>
					</a>
				</div>
				<div class="span4">
					<img src="images/karte.png" alt="Karte">
				</div>
			</div>
		</div>
	</div>
	<footer>
		<div class="container">
			<div class="footer">
				<div class="row-fluid">
					<div class="span2">
						<p><small>
						support vor ort gmbh<br/>
						Spinnereiweg 6<br/>
						CH-8307 Effretikon
						</small></p>
					</div>
					<div class="span5">
						<p><small>
						Tel.: 052 5 111 800<br/>
						Fax: 052 5 111 899<br/>
						Email: <a href="mailto:info@s-v-o.ch">info(at)s-v-o.ch</a>
						</small></p>
					</div>
					<div class="span1 footerLogo"></div>
					<div class="span3">
						<p>&copy;2014 support vor ort gmbh</p>
					</div>
				</div>
			</div>
		</div>
	</footer>

</body>
<script src="http://code.jquery.com/jquery.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script src="js/lightbox-2.6.min.js"></script>
<script type="text/javascript">
	function refresh (timeoutPeriod){
		refresh = setTimeout(function(){window.location.reload(true);},timeoutPeriod);
	}
</script>
</html>
