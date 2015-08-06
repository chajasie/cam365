$(document).ready(function() {
	var allImages = 0;
	var minimumDate = new Date(2013,5,5); //Fix Value change as you like  (Year, Month 0-11, Day 1-31)
	var maximumDate = new Date(); //Todays Date (Set Max Date of Jquery Datepicker)
	var running = false; //Used to determine wether or not the Slideshow is running or not
	var speed = 100; //Speed Dropdown (Slideshow Settings)
	var rest  = 0;
	var imageSplits;
	
	var isMobile = {
    Android: function() {
        return navigator.userAgent.match(/Android/i);
    },
    BlackBerry: function() {
        return navigator.userAgent.match(/BlackBerry/i);
    },
    iOS: function() {
        return navigator.userAgent.match(/iPhone|iPad|iPod/i);
    },
    Opera: function() {
        return navigator.userAgent.match(/Opera Mini/i);
    },
    Windows: function() {
        return navigator.userAgent.match(/IEMobile/i);
    },
    any: function() {
        return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
    }
};
	
	
	hideNoPicturesAndGalleria();
	configureAndStartGalleria(); //Galleria run + Galleria ready functions
	if(isMobile.any()){
		alert("Mobile Client");
			alert("testing...");
		//$('#to').attr('type', 'date');
		//var value = $('#to').attr('type');
		//alert(value);
		//if(value=="date"){
			//alert("test successful");
			//$('#from').attr('type', 'date');
			
	} else {
		console.log("Desktop Client");
		
		//reset type=date inputs to text
	  	 $('#to').attr('type', 'text');
	  	 $('#from').attr('type', 'text');
    	
		configureDatepicker(); // From and To options
	}
	getTodaysPictures(); 
	prevAndNextButtonFunctionality();
	slideshowFunctionality();
	timespanFunctionality();	
	milestoneFunctionality();
	
	
	////////////////////////////
	//        Funktionen      //	
	////////////////////////////
	
	function configureAndStartGalleria(){
		Galleria.run('#galleria', {
			extend : function(options) {
				var gallery = this;
				this.bind(Galleria.IMAGE, function(e) {
					var current = gallery.getData();
					var sourceText;
					if ( typeof current.original === 'undefined') {
						sourceText = current.image;
					} else {
						var currImg = current.original;
						sourceText = $(currImg).attr('src');
					}
					var match  = sourceText.match(/.{7}(\d{2})(\d{2})(\d{2})(\d{2})(\d{2}).+/);
					var year   = match[1];
					var month  = match[2];
					var day    = match[3];
					var hour   = match[4];
					var minute = match[5];
	
					$('#timestamp').text(day + "." + month + "." + year + " - " + hour + ":" + minute);
				});
			}
		});
	
		Galleria.ready(function() {
			var gallery = Galleria.get(0);
			// galleria is ready and the gallery is assigned
			
			this.addElement('exit').appendChild('container', 'exit');
	
			var btn = this.$('exit').hide().text('close').click(function(e) {
				gallery.exitFullscreen();
			});
	
			this.bind('fullscreen_enter', function() {
				btn.show();
			});
	
			this.bind('fullscreen_exit', function() {
				btn.hide();
			});
	
			$('#fullscreen').click(function() {
				gallery.toggleFullscreen();
				// toggles the fullscreen
			});
			
			/*  Optimierungsversuch ** von Ronald Aus der Au
			  $('.galleria-thumb-nav-right').click(function() {
				//Die nächsten 20 Bilder laden
				imageSplits = allImages.slice(0,40);
				Galleria.get(0).load(imageSplits);
				Galleria.configure({
					show:19
				});
			});*/
			
			//gallery.lazyLoadChunks( 10 );
		});
		
		Galleria.loadTheme('galleria/themes/classic/galleria.classic.min.js');
		Galleria.configure({
			//thumbnails: "lazy",
			transition : 'none'
			//preload : 30
		});	
	}
	
	function configureDatepicker(){
		$("#from").datepicker({
			dateFormat : "dd/mm/yy",
			defaultDate : "-1m",
			changeMonth : true,
			numberOfMonths : 3,
			maxDate : maximumDate,
			minDate : minimumDate,
			onClose : function(selectedDate) {
				$("#to").datepicker("option", "minDate", selectedDate);
				console.log($('#to').datepicker('getDate'));	
			},
			onSelect: function(){
				var date_picked = $(this).datepicker('getDate');
				if($('#to').datepicker('getDate') == null){
					console.log(date_picked);	
					$("#to").datepicker("setDate", new Date(date_picked));
					//$("#date2").datepicker("setDate", "+15d");				
				}
			}
		});

		$("#to").datepicker({
			dateFormat : "dd/mm/yy",
			defaultDate : "-1m",
			changeMonth : true,
			numberOfMonths : 3,
			maxDate : maximumDate,
			minDate : minimumDate,
			onClose : function(selectedDate) {
				$("#from").datepicker("option", "maxDate", selectedDate);
			}
		});
	}

	function milestoneFunctionality(){
		$(".milestone").click(function() {
			var milestoneSpan = $(this).attr("alt"); 	
			var name = $(this).text();
			var matches = milestoneSpan.match(/.*(\d{2}.\d{2}.\d{4}).*(\d{2}.\d{2}.\d{4}).*/);
			$("#milestones").html(name+ "<span class='caret'></span>");
			var response = $.ajax({
				url : "getPictures.php",
				dataType : "json",
				data : {
					from : matches[1],
					to : matches[2]
				},success : function(data) {
					showGalleria();				
					Galleria.get(0).load(data);
				}
			});
			checkIfEmpty(response);
		});
	}
	
	function timespanFunctionality(){
		$('#searchTimeSpan').click(function() {
			var fromDate = $("#from").val().replace(/\s+/g, '');
			var toDate = $("#to").val().replace(/\s+/g, '');
			var response = $.ajax({
				url : "getPictures.php",
				dataType : "json",
				data : {
					from : fromDate,
					to : toDate
				},success : function(data) {
					showGalleria();				
					Galleria.get(0).load(data);
					/* Optimierungsversuch ** von Ronald Aus der Au
					allImages = data;
					Math.floor(allImages.length/20);
					imageSplits = allImages.slice(0,20);
					rest = allImages.length%20;
					Galleria.get(0).load(imageSplits);*/
				}
			});
			checkIfEmpty(response);		
		});
	}

	function slideshowFunctionality(){
		$("#speed_slow").click(function() {
			speed = 1000;
			Galleria.get(0).setPlaytime(1000);
			$("#speed").html("Slow <span class='caret'></span>");
		});
		
		$("#speed_medium").click(function() {
			speed = 500;
			Galleria.get(0).setPlaytime(500);
			$("#speed").html("Medium <span class='caret'></span>");
		});
		
		$("#speed_fast").click(function() {
			speed = 100;
			Galleria.get(0).setPlaytime(100);
			$("#speed").html("Fast <span class='caret'></span>");
		});
		
		$('#slideshow').click(function() {
			if (!running) {
				Galleria.get(0).play(speed);
				$('#slideshow').text("Pause");
				running = true;
			} else {
				Galleria.get(0).pause();
				$('#slideshow').text("Play");
				running = false;
			}
		});
	}
	
	function getTodaysPictures(){
		var date = new Date();
		var month = date.getUTCMonth()+1;
		month = month < 10 ? "0"+month : month;
		var day = date.getUTCDate();
		day = day < 10 ? "0"+day : day;
		var year = date.getUTCFullYear();
		var response = $.ajax({
			url : "getPictures.php",
			dataType : "json",
			data : {
				from : day+"/"+month+"/"+year,
				to : day+"/"+month+"/"+year
			}, success : function(data) {
				//if(data.length > 0){
				showGalleria();
				Galleria.get(0).load(data);	
				//}else{
					//console.log("dsgsdg");
					//$('#no-pictures').show();
					//$('#galleria').hide();
				//}
			}
		});
		checkIfEmpty(response);
	}
	
	function prevAndNextButtonFunctionality(){
		//Next Button
		$("#next").click(function() {
			Galleria.get(0).next();
		});
	
		//Prev Button
		$("#prev").click(function() {
			Galleria.get(0).prev();
		});
		
		document.onkeyup = KeyCheck;
		function KeyCheck(e) {
			if (!window.screenTop && !window.screenY) {
				//Browser is in Fullscreen
			} else {
				var KeyID = (window.event) ? event.keyCode : e.keyCode;
				switch(KeyID) {
					case 37:
						//press left arrow
						Galleria.get(0).prev();
						break;
					case 39:
						//press right arrow
						Galleria.get(0).next();
						break;
				}
			}
		}
	}
	
	function checkIfEmpty(response){
		if(response.responseText==undefined){
			noPicturesFound();	
		};
	}
	
	function hideNoPicturesAndGalleria(){	
		$('#no-pictures').hide();
		$('#galleria').hide(); 
	}
	
	function noPicturesFound(){
		$('#galleria').hide();	
		$('#no-pictures').show();
	}
	
	function showGalleria(){
		$('#galleria').show();	
		$('#no-pictures').hide();
	}
	
}); 