$(function(){
	if($("#flash-message>#authMessage").length){
		$().toastmessage( { position : 'top-center' } );
		$("#flash-message").toastmessage( 'showWarningToast', $("#flash-message"));
	}
});