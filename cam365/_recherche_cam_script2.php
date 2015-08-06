<?php
    $files = scandir('middle/',0);
    $picCount = -1;
    $months = array('01','02','03','04','05','06','07','08','09','10','11','12');
	for($i=0;$i<count($files);$i++){
		if(!is_dir($files[$i])){
			$folderYear = $files[$i];
			$yearFiles = scandir('middle/' . $folderYear,0);
			
			for($y=0;$y<count($yearFiles);$y++){
				if (in_array($yearFiles[$y], $months)) {
					$monthFolder = $yearFiles[$y];
					$monthFiles = scandir('middle/' . $folderYear . '/' .  $yearFiles[$y], 0);
					for($m=0;$m<count($monthFiles);$m++){
						if(strpos($monthFiles[$m],'.jpg')){
                   					$picCount++;
                 	       				$pics[$picCount] = 'middle/' . $folderYear . '/' .  $monthFolder . '/' . $monthFiles[$m];
                				}
					}
				}
			}
		}
    }
    
    if(isset($_POST['nextBtn'])){
        $currentPic = $_POST['currentPic']+1;
    }elseif(isset($_POST['prevBtn'])){
        $currentPic = $_POST['currentPic']-1;
    }elseif(isset($_POST['search'])){
        $year = $_POST['year'];
        $month = $_POST['month'];
        $day = $_POST['day'];
        $hour = $_POST['hour'];
        $minute = $_POST['minute'];
        
        if(strlen($year) >2){
            $year = substr($year, -2);
        }
        if(strlen($month) ==  1){
            $month = "0" . $month;
        }
        if(strlen($month) ==  0){
            $month = "01";
        }
        if(strlen($day) ==  1){
            $day = "0" . $day;
        }
        if(strlen($day) ==  0){
            $day = "01";
        }
        if(strlen($hour) ==  1){
            $hour = "0" . $hour;
        }
         if(strlen($hour) ==  0){
            $hour = "01";
        }
        if(strlen($minute) ==  1){
            $minute = "0" . $minute;
        }
        
        if(strlen($minute) ==  0){
            $minute = "00";
        }
        $currentPic = -1;
        for($i=0;!empty($pics[$i]);$i++){
            if($year . $month . $day . $hour . $minute . ".jpg" == substr($pics[$i], -14)){
                $currentPic = $i;
                break;
            }
            //Timestamp doesnt exist
            if($i == count($pics)){
                
            }
        }
    }else{
        $currentPic = $picCount;
    }
   
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Obermoeliholz - STUTZ + BOLT + PARTNER</title>
	<base url="support-vor-ort.ch/obermoeliholz/" />
	
	<!-- CSS Styles -->
	<link href="../css/bootstrap.min.css" rel="stylesheet">
	<link href="../css/bootstrap-responsive.min.css" rel="stylesheet">
	<link href="../css/lightbox.css" rel="stylesheet" />
	<link href="../css/customized.css" rel="stylesheet">
	
</head>
<body>
	<div class="header">
		<div class="navbar navbar-default container">
			<div class="navbar-inner row-fluid">
				<div class="container-fluid headerContent">
					<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</a>
					<a class="navbar-brand visible-phone" href="#">support vor ort gmbh</a>
					<div class="nav-collapse">
						<div class="span12">
							<ul class="span2 nav navbar-nav">
								<li class="first">
									<a href="../index.php" >Live Bild</a>
								</li>
								<li class="last active">
									<a href="index.php" >Archiv</a>
								</li>
				
							</ul>
							<form action="" method="POST" id="form">
								<div class="span4 pull-left">
									<?php
										if(!isset($_POST['search']) && $pics[$currentPic]!=""){
											$timeStampToday = str_replace ( ".jpg" , "" , substr($pics[$currentPic], -14));
											$year   = substr($timeStampToday, 0, 2);
											$month  = substr($timeStampToday, 2, 2);
											$day    = substr($timeStampToday, 4, 2);
											$hour   = substr($timeStampToday, 6, 2);
											$minute = substr($timeStampToday, 8, 2);
										}
										if(strlen($year)>2){
											$year   = substr($year, 2, 2);
										}
									?>
									<input name="currentPic" type="hidden" value="<?php echo $currentPic ?>" />
									<div class="top">
										<input type="text" name="day"   class="input-large search-query" id="day" placeholder="Tag" value="<?php echo $day ?>">
										<input type="text" name="month" class="input-large search-query" id="month" placeholder="Monat" value="<?php echo $month ?>">
										<input type="text" name="year"  class="input-large search-query" id="year" placeholder="Jahr" value="<?php echo "20" .  $year ?>">
									</div>
									<div class="bottom">
										<input type="text" name="hour"  class="input-large search-query" id="hour" placeholder="Stunde" value="<?php echo $hour ?>">
										<div class="btn-group dropdown">
											<button id="minute" class="btn-large dropdown-toggle" data-toggle="dropdown">
												<?php
												  if(isset($minute) && $minute != ""){
													echo $minute;
												  }else{
													echo "Minute";
												  }
												?>
											  <span class="caret"></span>
											</button>
											<ul class="dropdown-menu"> 
												<li><a id="00" href="#"> 00 </a></li>
												<li><a id="15" href="#"> 15 </a></li>
												<li><a id="30" href="#"> 30 </a></li>
												<li><a id="45" href="#"> 45 </a></li>
											</ul>
											<input type="hidden" value="<?php echo $minute;?>" name="minute" id="minuteVal" />
										</div>
										<button class="btn btn-large" type="submit" id="search" name="search">Anzeigen</button>
										
									</div>
								</div>
								<div class="span3 buttons largeMargin">
									<?php
											if(isset($_POST['search']) && $currentPic < 0){
											}else{
										?>
											<button class="btn btn-large" type="submit" id="prevBtn" name="prevBtn">Zur&uuml;ck</button>
											<button class="btn btn-large" type="submit" id="nextBtn" name="nextBtn">Vor</button>
										<?php
											}      
									?> 
								</div>
							</form>
							<a href="http://s-v-o.ch/" class="hidden-phone">
								<img id="logoPic" src="../images/svo_logo.png" alt="support vor ort gmbh" />
							</a>
						</div>
					</div>
				</div> 
			</div>
		</div>
	</div>
	<div class="container contentContainer camRecording">       
		<div class="featurette">
			<div class="row-fluid">
				<div class="span12">
					<?php
						if(!empty($pics[$currentPic])){
					?>
							<a href="<?php echo $pics[$currentPic]; ?>" data-lightbox="image-1"><img name="bild" src="<?php echo $pics[$currentPic]; ?>" class="img-rounded" id="bild"></a>
					<?php
						}else{
							echo '<span class="label label-important">Kein Bildmaterial vorhanden!</span>';   
						}
					?>
				</div>
			</div>
			<div class="row-fluid">
				<?php
					$thePic = substr($pics[0], -14);
					$ersteAufnahme = substr($thePic, 0, -4);
					$datum = substr($ersteAufnahme, 4, 2) . ".";
					$datum .= substr($ersteAufnahme, 2, 2) . ".";
					$datum .= substr($ersteAufnahme, 0, 2);
					$datum .= " " . substr($ersteAufnahme, 6, 2) . ":";
					$datum .= substr($ersteAufnahme, 8, 2);
				?>
				<span>Erste Aufnahme: <?php echo $datum; ?></span>
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

    <!-- Modal -->
    <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Unvollständige Zeitangabe</h3>
      </div>
      <div class="modal-body">
        <p>Bitte kontrollieren Sie das eingegebene Datum</p>
      </div>
    </div>
    <script src="http://code.jquery.com/jquery.js"></script>
    <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
    <script src="../js/bootstrap.min.js"></script>
	<script src="../js/lightbox-2.6.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $("#00").on("click", function(){
                $("#minuteVal").val("00");
                $("#minute").html("00 <span class='caret'></span>");
            });
                        
            $("#15").on("click", function(){
                $("#minuteVal").val("15");
                $("#minute").html("15 <span class='caret'></span>");
            });
                        
            $("#30").on("click", function(){
                $("#minuteVal").val("30");
                $("#minute").html("30 <span class='caret'></span>");
            });
                        
            $("#45").on("click", function(){
                $("#minuteVal").val("45");
                $("#minute").html("45 <span class='caret'></span>");
            });
            
            $("#search").click(function(){
                if($("#month").val() == "" || $("#month").val() > 12 || $("#day").val() == "" || $("#day").val() > 31 || $("#hour").val() == "" || $("#hour").val() > 23){
                    $('#myModal').modal();
                    return false;
                }
            });
        });
    </script>
</body>
</html>