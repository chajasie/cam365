function initEventHandler() {
	$("#next").on("click", function() {
		Galleria.get(0).next();
	});
	$("#prev").on("click", function() {
		Galleria.get(0).prev();
	});
	$("#speed_slow").on("click", function() {
		setSpeed(1000);
		$("#speed").html("Langsam <span class='caret'></span>");
	});
	$("#speed_medium").on("click", function() {
		setSpeed(500);
		$("#speed").html("Mittel <span class='caret'></span>");
	});
	$("#speed_fast").on("click", function() {
		setSpeed(30);
		$("#speed").html("Schnell <span class='caret'></span>");
	});
	$('#searchTimeSpan').on("click", function() {
		//$('#galleria').hide();
        if (running) {
			pause();
        }
		var fromDate = $("#from").val().replace(/\s+/g, '');
		var toDate = $("#to").val().replace(/\s+/g, '');
		getPictures(fromDate, toDate);
	});
	$('#slideshow').on("click", function() {
		if (!running) {
			play();
		} else {
			pause();
		}
	});
	$('#fullscreen').on("click", function() {
		Galleria.get(0).toggleFullscreen();
	});
	$(".milestone").on("click", function() {
		if (running) {
			pause();
        }
		var milestoneSpan = $(this).attr("alt");
		var name = $(this).text();
		var matches = milestoneSpan.match(/.*(\d{2}.\d{2}.\d{4}).*(\d{2}.\d{2}.\d{4}).*/);
		$("#milestones").html(name + "<span class='caret'></span>");
		getPictures(matches[1], matches[2]);
	});
	$(document).on("keyup", function(event) {
		if (!window.screenTop && !window.screenY) {
			//Browser is in Fullscreen
		} else {
			switch (event.keyCode) {
			case 37:
				//left arrow
				Galleria.get(0).prev();
				break;
			case 39:
				//right arrow
				Galleria.get(0).next();
				break;
			}
		}
	});
}

function initGalleriaEventHandler() {
	var gallery = Galleria.get(0);
	var btn = gallery.$('exit').hide().text('Schliessen').click(function(e) {
		gallery.exitFullscreen();
	});
	gallery.bind('fullscreen_enter', function() {
		btn.show();
	});
	gallery.bind('fullscreen_exit', function() {
		btn.hide();
	});
    gallery.bind('thumbnail',function(){
        loadImageHandler();
    });
	gallery.bind('image', function() {
		var current = gallery.getData();
		var sourceText;
		if (current.original === undefined) {
			sourceText = current.image;
		} else {
			sourceText = $(current.original).attr('src');
		}
		var match = sourceText.match(/.{7}(\d{2})(\d{2})(\d{2})(\d{2})(\d{2}).+/),
			year = match[1],
			month = match[2],
			day = match[3],
			hour = match[4],
			minute = match[5];
		$('#timestamp').text(day + "." + month + "." + year + " - " + hour + ":" + minute);
	});
}