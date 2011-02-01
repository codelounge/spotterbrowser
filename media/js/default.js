jQuery.noConflict();
     
jQuery(document).ready(function($){
	
	$( "button, input:submit, a", "#searchpanel" ).button();
	$( ".button", "#buttonnavigation" ).button();
	
	$('#datepicker').datepicker( {
		beforeShow: function(input, inst) { 
			if ($('#datepicker').datepicker( "getDate" ) == null) {
				var currentdate = new Date(); //.toString();
				var Jahr = currentdate.getYear();
			} else {
				var currentdate = $('#datepicker').datepicker( "getDate" );//.toString();
				var Jahr = currentdate.getYear();
			}
			if (Jahr != null) {
				if (Jahr < 999)
				  Jahr += 1900;
			}
			$.ajax({
				url: 'getCurrentMonth',
				dataType: 'json',
				async: false,
				data: { year: Jahr, month: currentdate.getMonth() + 1 },
				success: function(data) {
					datelist = data;
				}
			});
	 	},
	 	onChangeMonthYear: function(year, month, inst) {
	 		$.ajax({
				url: 'getCurrentMonth',
				dataType: 'json',
				async: false,
				data: { year: year, month: month},
				success: function(data) {
					datelist = data;
				}
			});
	 	},
	 	beforeShowDay:  function(date) {
	 		if (datelist === undefined) {
				return false;
			}
			var month = date.getMonth() + 1;
			var day = date.getDate();
			
			if (month == datelist.month) {
				if(jQuery.inArray(day,datelist.days) > -1) {
				return [true, ''];
				}
			}
			return false;
	 	}
	});

	$('#select_aircraft').change(function(){ 
		$.ajax({
			type: "GET",
            url: "changeaircraft",
            data: { type: escape($(this).val())},
            success: function(html){
            	$("#search_manufacturer").html(html);
            }
		});
	});
});   

     

/* German initialisation for the jQuery UI date picker plugin. */
/* Written by Milian Wolff (mail@milianw.de). */
jQuery(function($){
	$.datepicker.regional['de'] = {
		closeText: 'schließen',
		prevText: '&#x3c;zurück',
		nextText: 'Vor&#x3e;',
		currentText: 'heute',
		monthNames: ['Januar','Februar','März','April','Mai','Juni',
		'Juli','August','September','Oktober','November','Dezember'],
		monthNamesShort: ['Jan','Feb','Mär','Apr','Mai','Jun',
		'Jul','Aug','Sep','Okt','Nov','Dez'],
		dayNames: ['Sonntag','Montag','Dienstag','Mittwoch','Donnerstag','Freitag','Samstag'],
		dayNamesShort: ['So','Mo','Di','Mi','Do','Fr','Sa'],
		dayNamesMin: ['So','Mo','Di','Mi','Do','Fr','Sa'],
		weekHeader: 'Wo',
		dateFormat: 'yy-mm-dd', 
		firstDay: 1,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''};
	$.datepicker.setDefaults($.datepicker.regional['de']);
});

