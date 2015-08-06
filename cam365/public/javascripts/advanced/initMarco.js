var running = false;
var speed= 500;
var imageBuffer = new Array();
var progress = 0;
var loadSize = 0;
var enteredPage = true;

$(document).ready(function() {
    init();
    initEventHandler();
}); 	


function init(){
    
	var minimumDate = new Date(2013,9,30); //Fix Value change as you like  (Year, Month 0-11, Day 1-31)
	var maximumDate = new Date(); //Todays Date (Set Max Date of Jquery Datepicker)
    
    hideNoPicturesAndGalleriaAndProgressbar();
	configureAndStartGalleria(); //Galleria run + Galleria ready functions
	
    if(!isMobileClient().any()) {	
		//Desktop Client
		//DO NOT SPLIT IT IN LINES .html() function won't allow that!!!
		$("#date-picker").html("<form id='desktop-date-picker'><input name'myFromDate' type='text' id='from' placeholder='Von' /><input type='text' id='to' placeholder='Bis' /><input name='myToDate' type='button' id='searchTimeSpan' class='btn' value='Zeitraum anzeigen' /></form>");
		configureDatepicker(minimumDate,maximumDate); // From and To options
	}
	else{
		//MobileCient has to be done here because this is some styling that is done by datebox javascript file and must be removed for styling purpose
		$("#from").parent().removeClass("ui-input-datebox ui-shadow-inset ui-corner-all ui-body-c");
		$("#to").parent().removeClass("ui-input-datebox ui-shadow-inset ui-corner-all ui-body-c");
		
		//Not working since our #from input is type="text" for this to work it must be type="date" but then devices will chose their standard input method for dates which does not always look good and provide the necessary functionality
		//var maxDateString = maximumDate.getFullYear()+"-"+(maximumDate.getMonth()+1)+"-"+maximumDate.getDate();
		//alert(maxDateString);
		//$("#from").attr("max",maxDateString);
	}
    
   
    
    $("#dialog").dialog({
        position:{ my:"center",at:"center",of:window},
        draggable: false,
        modal : true,
        resizable: false
    });
    $("#dialog").dialog("close");
    
    $("#dialog-no-pics-found").dialog({
        position:{ my:"center",at:"center",of:window},
        draggable: false,
        modal : true,
        resizable: false
    });
    $("#dialog-no-pics-found").dialog("close");
    
    setSpeed(speed);
	//getTodaysPictures(); 	
}
   
    

