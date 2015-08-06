var images = [];

//Custom Transition
 
/*function clip(params, complete){	

	function showNext(){ 
	$(params.next).animate({ height: '100%', top: '0%' }, params.speed, complete); 
	} 
	if (params.prev) { 
	$(params.next).css({ height: 0, top: '50%' }); 
	$(params.prev).css('opacity', 1).show(); 
	$(params.prev).animate({ top: '50%', height: 0 }, params.speed, showNext); 
	} 

} */


function configureAndStartGalleria() {
	Galleria.run('#galleria');
	Galleria.ready(function() {
		this.addElement('exit').appendChild('container', 'exit');
		initGalleriaEventHandler();
	});
	//Custom Transition
	//Galleria.addTransition("clip", clip);
	
	Galleria.loadTheme('galleria/themes/classic/galleria.classic.min.js');
	Galleria.configure({
		preload: 'all',
		wait: true,
		transition: 'disabled'
	});
}

function configureDatepicker(minDate, maxDate) {
	$("#from").datepicker({
		dateFormat: "dd/mm/yy",
		defaultDate: "-1m",
		changeMonth: true,
		numberOfMonths: 3,
		maxDate: maxDate,
		minDate: minDate,
		onClose: function(selectedDate) {
			$("#to").datepicker("option", "minDate", selectedDate);
			console.log($('#to').datepicker('getDate'));
		},
		onSelect: function() {
			var date_picked = $(this).datepicker('getDate');
			if ($('#to').datepicker('getDate') == null) {
				console.log(date_picked);
				$("#to").datepicker("setDate", new Date(date_picked));
				//$("#date2").datepicker("setDate", "+15d");				
			}
		}
	});
	$("#to").datepicker({
		dateFormat: "dd/mm/yy",
		defaultDate: "-1m",
		changeMonth: true,
		numberOfMonths: 3,
		maxDate: maxDate,
		minDate: minDate,
		//onClose: function(selectedDate) {
			//$("#from").datepicker("option", "maxDate", selectedDate);
		//}
	});
}

function getTodaysPictures() {
	var date = new Date();
	var month = date.getUTCMonth() + 1;
	month = month < 10 ? "0" + month : month;
	var day = date.getUTCDate();
	day = day < 10 ? "0" + day : day;
	var year = date.getUTCFullYear();
	var todayString = day + "/" + month + "/" + year;
	getPictures(todayString, todayString);
}

function getPictures(from, to) {
	$.ajax({
		url: "getPictures.php",
		dataType: "json",
		data: {
			from: from,
			to: to
		},
		success: function(data) {
			$('#no-pictures').hide();
            $('#galleriaControls').show();
			progress = 0;
            loadSize = data.length;
            preLoad();
                
            Galleria.get(0).load(data);
            showGalleria();                
            
		},
		error: function(data) {
			console.log(data);
			if(enteredPage==true){
				noPicturesFoundToday();
				enteredPage=false;
			}
			else{
				$('#timestamp').text("");
				$('#galleria').hide();
				$('#no-pictures').hide();
				$("#dialog-no-pics-found").dialog("open");
			setTimeout(function(){$("#dialog-no-pics-found").dialog("close");}, 1800);			
			}
		}
	});
}
function preLoad(){
    $("#dialog").dialog("open");
    $('#progressbar').progressbar({
        value: progress
	});
    $("#countProgress").text(progress + " von " + loadSize + " Bildern geladen");
    
}
function loadImageHandler() {
	progress += 1;
    var totalProgress = Math.abs(progress / loadSize * 100);    
	$('#progressbar').progressbar({
		value: totalProgress
	});
    $("#countProgress").text(progress + " von " + loadSize + " Bildern geladen");
    if(totalProgress == 100){
        loadAll();
    }
}

function loadAll() {
    $("#dialog").dialog("close");
	showGalleria();
}

function setSpeed(newSpeed) {
	speed = newSpeed;
	Galleria.get(0).setPlaytime(newSpeed);
}

function hideNoPicturesAndGalleriaAndProgressbar() {
	$('#no-pictures').hide();
	$('#galleria').hide();
    $('#galleriaControls').hide();
}

function noPicturesFoundToday() {
	$('#galleria').hide();
    $('#galleriaControls').hide();
	$('#no-pictures').show();
}

function showGalleria() {
	$('#galleria').show();
	$('#no-pictures').hide();
}
function play(){
    Galleria.get(0).play(speed);
    $('#slideshow').html('Diashow Pausieren <img src="images/pause_outline.png"/>');
	running = true;
}
function pause(){
    Galleria.get(0).pause();
	$('#slideshow').html('Diashow Abspielen <img src="images/play_outline.png"/>');
	running = false;
}