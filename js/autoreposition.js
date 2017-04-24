//Makes Scroll Checkpoint Dialogs reposition automatically when the window size changes
//Hopefully has a positive influence on mobile devices

jQuery(document).ready(function($){
	$.ui.dialog.prototype.options.autoReposition = false;
	$( window ).resize(function() {
		$( ".ui-dialog-content:visible" ).each(function() {
			if ($(this).dialog('option', 'autoReposition')) {
                $(this).dialog('option', 'position', $(this).dialog('option', 'position'));
            }
		});
	});	
});