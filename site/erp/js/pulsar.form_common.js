$(document).ready(function(){
	
	$('input[type=checkbox],input[type=radio],input[type=file]').uniform();
	
	//$('select').chosen({allow_single_deselect: true});
	
    $('.calendar').datetimepicker({
        language: 'pt-BR',
        format: 'dd/MM/yyyy'
    });
});
