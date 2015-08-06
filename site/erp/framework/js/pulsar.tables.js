$(document).ready(function(){
	
	$('.data-table').dataTable({
		"bPaginate": false,
		"bFilter": false,
		"bJQueryUI": true,
		"sPaginationType": "full_numbers",
		"sDom": '<""l>t<"F"fp>'
			
	});
	
	$('input[type=checkbox],input[type=radio],input[type=file]').uniform();
	
	$('select').not('.notChosen').chosen({no_results_text: "Nada encontrado!"});
	$('.chzn-drop').css({"width": "auto", "white-space": "nowrap"});
//	$('#selectCliente_chzn').css({"max-width":"400px"});
//	$('.chzn-container-single').css({"max-width":"40%"});
	$('.chzn-container-single').css({"max-width":"300px"});
	$('.chzn-container-single').css({"min-width":"300px"});
//	$('.chzn-container-single').css({"max-width":"40%"});

	$("span.icon input:checkbox, th input:checkbox").click(function() {
		
		
		
		
		
		
		
		var checkedStatus = this.checked;
		var checkbox = $(this).parents('table').find('tr td:first-child input:checkbox');		
		checkbox.each(function() {
			this.checked = checkedStatus;
			if (checkedStatus == this.checked) {
				$(this).closest('.checker > span').removeClass('checked');
			}
			if (this.checked) {
				$(this).closest('.checker > span').addClass('checked');
			}
		});
	});	
	
	
	
	
	
});
