   	var tempIndex = 1;
   	var index = 1;
   	var timerId = 0;

	function isMobileClient(){
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
		return isMobile;
	}
	
	function configureAndStartGalleria(){
		Galleria.run('#galleria');
        
        
		Galleria.ready(function() {
            this.addElement('exit').appendChild('container', 'exit');
            
			initGalleriaEventHandler();
		});
		
		Galleria.loadTheme('galleria/themes/classic/galleria.classic.min.js');
		Galleria.configure({
			transition : 'none',
            thumbnails: 'lazy'
		});	
	}
	
	function configureDatepicker(minDate, maxDate){
		$("#from").datepicker({
			dateFormat : "dd/mm/yy",
			defaultDate : "-1m",
			changeMonth : true,
			numberOfMonths : 3,
			maxDate :  maxDate,
			minDate : minDate,
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
			maxDate : maxDate,
			minDate : minDate,
			onClose : function(selectedDate) {
				$("#from").datepicker("option", "maxDate", selectedDate);
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
        
        var todayString = day+"/"+month+"/"+year;
        getPictures(todayString, todayString);
		
	}
	
    function getPictures(from, to){
        $.ajax({
			url : "getPictures.php",
			dataType : "json",
			data : {
				from : from,
				to : to
			}, success : function(data) {
                if(data == undefined || data.length < 1){
                    noPicturesFound();
                }
                else{
                    showGalleria();
                   	Galleria.get(0).load(data[0]);
                    timerId = setInterval(function(){
                   		LoadImagesToGalleria(150,data);
                   	}, 1000);
					
                    setTimeout(LazyLoadImages,1000);
                    
                }
			}
		});
    }

	function LoadImagesToGalleria(number, data){
		tempIndex = index;
		for(index;index<tempIndex+number;index++){
			if(index>=data.length){
				clearInterval(timerId);
			}
			else{
		    	Galleria.get(0).push(data[index]);
			}
        }
	}
    
    function LazyLoadImages(){
        Galleria.get(0).lazyLoadChunks( 50, 10000 );
    }
    
    function setSpeed(newSpeed){
        speed = newSpeed;
        Galleria.get(0).setPlaytime(newSpeed);
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
	
