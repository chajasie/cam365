function isMobileClient() {
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

if(isMobileClient().any()){
	//Mobile Client
	//DO NOT SPLIT IT IN LINES .html() function won't allow that!!!
	$("#date-picker").html("<form id='mobile-date-picker'><input id=\'from\' type=\'text\' data-role=\'datebox\' data-options=\'{\"mode\": \"calbox\",\"useTodayButton\": true,\"overrideDateFormat\":\"%d\/%m\/%Y\", \"calUsePickers\": true, \"calNoHeader\": true}\' \/><input id=\'to\' type=\'text\' data-role=\'datebox\' data-options=\'{\"mode\": \"calbox\",\"useTodayButton\": true,\"overrideDateFormat\":\"%d\/%m\/%Y\", \"calUsePickers\": true, \"calNoHeader\": true}\'><input type=\'button\' id=\'searchTimeSpan\' class=\'btn\' value=\'Zeit spanne\' \/></form>");	
 } 
