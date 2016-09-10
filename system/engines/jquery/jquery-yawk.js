/*
* jQuery YaWK addons
* 
* YaWK - internal: build our own JS functions
...on document ready... letsego! */

$(document).ready(function() {

 		$("a").click(function(){
			$("#Alert").fadeIn('slow')
			.delay(5200).fadeOut('slow')
			});	
	
/* SAVE BUTTON JS GFX */
		$("#savebutton").click(function(){
			$('#savebutton').removeClass("btn").addClass("btn btn-success");
			});		
		$("#savebutton2").click(function(){
			$('#savebutton2').removeClass("btn").addClass("btn btn-success");
			});	
		$("#savebutton3").click(function(){
			$('#savebutton3').removeClass("btn").addClass("btn btn-success");
			});	
		$("#savebutton4").click(function(){
			$('#savebutton4').removeClass("btn").addClass("btn btn-success");
			});	
		$("#savebutton5").click(function(){
			$('#savebutton5').removeClass("btn").addClass("btn btn-success");
			});

	/* modal dialog data-confirm */
	$('a[data-confirm]').click(function(ev) {
		var href = $(this).attr('href');
		if (!$('#dataConfirmModal').length) {
			$('body').append('<div id="dataConfirmModal" class="modal fade" role="dialog" aria-labelledby="dataConfirmLabel" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button><h3 id="dataConfirmLabel"><i style="color:#f0ad4e;" class="fa fa-warning"></i> Achtung! <small>Bist Du sicher?</small></h3></div><div class="modal-body"></div><div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Abbrechen</button><a type="button" class="btn btn-danger" id="dataConfirmOK"> <i class="fa fa-trash-o"></i> L&ouml;schen</a></div></div></div></div>');
		} 
		$('#dataConfirmModal').find('.modal-body').text($(this).attr('data-confirm'));
		$('#dataConfirmOK').attr('href', href);
		$('#dataConfirmModal').modal({show:true});
		return false;
	});
		

});
	
