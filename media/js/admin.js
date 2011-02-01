jQuery(document).ready(function($) {
	$( "#dialog:ui-dialog" ).dialog( "destroy" );

	$( "button, input:submit", "#contentform" ).button();
	
	$('a[rel*=facebox]').facebox({
		loadingImage : '../../media/js/facebox/loading.gif',
	    closeImage   : '../../media/js/facebox/closelabel.png'
	});
	
	$('#datepicker').datepicker();
	
	$('#lookuplocal').click(function() {
		$.ajax({
			type: "GET",
			url: 'lookuplocaldatabase',
			data: { registration: escape($('#registration').val())},
			success: function(data) {
				var obj = jQuery.parseJSON(data);
				if (obj.found == false) {
					$( "#lokal-dialog-message" ).dialog({
						modal: true,
						buttons: {
							Ok: function() {
								$( this ).dialog( "close" );
							}
						}
					});
				} else {
				
					if (obj.airline != null) {
						$('#select_airline').val(obj.airline);	
					}
					if (obj.manufacturer != null) {
						$('#select_manufacturer').val(obj.manufacturer);
					}
					if (obj.aircraft != null) {
						$('#select_aircraft').val(obj.aircraft);
					}
				}
			}
		});

	});

	$('#lookupairliners').click(function() {
		var registration = escape($('#registration').val());
		window.open(("http://www.airliners.net/search/photo.search?regsearch="+registration), "Airliners.net", "width=1024,height=800,scrollbars");
	});
	
	/*
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
	*/
	

	$( "#select_airline" ).autocomplete({
		source: "autocompleteairline",
		minLength: 2
	});

	$( "#select_manufacturer" ).autocomplete({
		source: "autocompletemanufacturer",
		minLength: 2
	});
	
	$( "#select_aircraft" ).autocomplete({
		//source: "autocompleteaircraft",
		source: function( request, response ) {
			$.ajax({
				url: "autocompleteaircraft",
				dataType: "json",
				data: {
					manufacturer: $('#select_manufacturer').val(),
					term: request.term
				},
				success: function( data ) {
					response( $.map( data, function( item ) {
						return {
							label: item,
							value: item
						}
					}));
				}
			});
		},
		minLength: 2,

		
		
		minLength: 2
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