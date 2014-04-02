<?php 
if(!isset($show_price))
	$show_price = false;
if(!isset($sufix))
	$sufix = "";

?>
<script language="JavaScript" type="text/JavaScript">
function update_utilizacao<?php echo $sufix?>(id_tipo, id_utilizacao) {
	var dataString = 'action=utilizacao&contrato=<?php echo isset($contrato)?$contrato:"F"?>&idioma=<?php echo $lingua?>&id_tipo='+ id_tipo +'&id_utilizacao='+ id_utilizacao;

	$.ajax({
		type: "POST",
		url: "../tool_ajax.php",
		data: dataString,
		cache: false,
		success: function(html) {
			$("#utilizacao<?php echo $sufix?>").html(html);
			
			var select_name = "utilizacao<?php echo $sufix?>";
			if(!check_select(select_name)) {
				$("#"+select_name+" option").filter(function() {
				    return $(this).val() == 0; 
				}).attr('selected', true);
				$("."+select_name).hide();
				if(typeof id_utilizacao == 'undefined') 
					update_formato<?php echo $sufix?>(id_tipo, 0);
			}
			else {
				$("."+select_name).show();
			}
		} 
	});
}

function update_formato<?php echo $sufix?>(id_tipo, id_utilizacao, id_formato) {
	var dataString = 'action=formato&contrato=<?php echo isset($contrato)?$contrato:"F"?>&idioma=<?php echo $lingua?>&id_tipo='+ id_tipo +'&id_utilizacao='+ id_utilizacao+'&id_formato='+id_formato;

	$.ajax({
		type: "POST",
		url: "../tool_ajax.php",
		data: dataString,
		cache: false,
		success: function(html) {
			$("#formato<?php echo $sufix?>").html(html);

			var select_name = "formato<?php echo $sufix?>";
			if(!check_select(select_name)) {
				$("#"+select_name+" option").filter(function() {
				    return $(this).val() == 0; 
				}).attr('selected', true);
				$("."+select_name).hide();
				if(typeof id_formato == 'undefined') 
					update_distribuicao<?php echo $sufix?>(id_tipo, id_utilizacao, 0);
			}
			else {
				$("."+select_name).show();
			}
		} 
	});
}
function update_distribuicao<?php echo $sufix?>(id_tipo, id_utilizacao, id_formato, id_distribuicao) {
	var dataString = 'action=distribuicao&contrato=<?php echo isset($contrato)?$contrato:"F"?>&idioma=<?php echo $lingua?>&id_tipo='+ id_tipo +'&id_utilizacao='+ id_utilizacao+'&id_formato='+id_formato+'&id_distribuicao='+id_distribuicao;

	$.ajax({
		type: "POST",
		url: "../tool_ajax.php",
		data: dataString,
		cache: false,
		success: function(html) {			
			$("#distribuicao<?php echo $sufix?>").html(html);

			var select_name = "distribuicao<?php echo $sufix?>";
			if(!check_select(select_name)) {
				$("#"+select_name+" option").filter(function() {
				    return $(this).val() == 0; 
				}).attr('selected', true);
				$("."+select_name).hide();
				if(typeof id_distribuicao == 'undefined') 
					update_periodicidade<?php echo $sufix?>(id_tipo, id_utilizacao, id_formato, 0);
			}
			else {
				$("."+select_name).show();
			}			
		} 
	});
}
function update_periodicidade<?php echo $sufix?>(id_tipo, id_utilizacao, id_formato, id_distribuicao, id_periodicidade) {
	var dataString = 'action=periodicidade&contrato=<?php echo isset($contrato)?$contrato:"F"?>&idioma=<?php echo $lingua?>&id_tipo='+ id_tipo +'&id_utilizacao='+ id_utilizacao+'&id_formato='+id_formato+'&id_distribuicao='+id_distribuicao+'&id_periodicidade='+id_periodicidade;

	$.ajax({
		type: "POST",
		url: "../tool_ajax.php",
		data: dataString,
		cache: false,
		success: function(html) {
			$("#periodicidade<?php echo $sufix?>").html(html);
			
			var select_name = "periodicidade<?php echo $sufix?>";
			if(!check_select(select_name)) {
				$("#"+select_name+" option").filter(function() {
				    return $(this).val() == 0; 
				}).attr('selected', true);
				$("."+select_name).hide();
				if(typeof id_periodicidade == 'undefined') 
					update_tamanho<?php echo $sufix?>(id_tipo, id_utilizacao, id_formato, id_distribuicao, 0);
			}
			else {
				$("."+select_name).show();
			}
		} 
	});
}
function update_tamanho<?php echo $sufix?>(id_tipo, id_utilizacao, id_formato, id_distribuicao, id_periodicidade, id_tamanho) {
	var dataString = 'action=tamanho&contrato=<?php echo isset($contrato)?$contrato:"F"?>&idioma=<?php echo $lingua?>&id_tipo='+ id_tipo +'&id_utilizacao='+ id_utilizacao+'&id_formato='+id_formato+'&id_distribuicao='+id_distribuicao+'&id_periodicidade='+id_periodicidade+'&id_tamanho='+id_tamanho;

	$.ajax({
		type: "POST",
		url: "../tool_ajax.php",
		data: dataString,
		cache: false,
		success: function(html) {
			$("#tamanho<?php echo $sufix?>").html(html);

			var select_name = "tamanho<?php echo $sufix?>";
			if(!check_select(select_name)) {
				$("#"+select_name+" option").filter(function() {
				    return $(this).val() == 0; 
				}).attr('selected', true);
				$("."+select_name).hide();
				if(typeof id_tamanho == 'undefined') 
					update_uso<?php echo $sufix?>(id_tipo, id_utilizacao, id_formato, id_distribuicao, id_periodicidade, 0);
			}
			else {
				$("."+select_name).show();
			}
		} 
	});
}
function update_uso<?php echo $sufix?>(id_tipo, id_utilizacao, id_formato, id_distribuicao, id_periodicidade, id_tamanho) {
	var dataString = 'action=uso&contrato=<?php echo isset($contrato)?$contrato:"F"?>&idioma=<?php echo $lingua?>&id_tipo='+ id_tipo +'&id_utilizacao='+ id_utilizacao+'&id_formato='+id_formato+'&id_distribuicao='+id_distribuicao+'&id_periodicidade='+id_periodicidade+'&id_tamanho='+id_tamanho;
	$.ajax({
		type: "POST",
		url: "../tool_ajax.php",
		data: dataString,
		cache: false,
		success: function(html) {
			var resposta = jQuery.parseJSON(html);
			if(resposta["descricao"] != "" && resposta["descricao"] != null) {
				$(".descricao<?php echo $sufix?>").show();			
				$("#descricao<?php echo $sufix?>").html(resposta["descricao"]);
			}
<?php if($show_price) { ?>
			$(".valor<?php echo $sufix?>").show();			
			$("#valor<?php echo $sufix?>").html('<?php echo ($lingua!="br")?"GBP":"R$"?> '+resposta["valor"]);				
<?php } ?>
			$("#uso<?php echo $sufix?>").val(resposta["id_uso"]);
		} 
	});
}
function update_descricao<?php echo $sufix?>(id_uso) {
	var dataString = 'action=uso&contrato=<?php echo isset($contrato)?$contrato:"F"?>&idioma=<?php echo $lingua?>&id_uso='+ id_uso;
	$.ajax({
		type: "POST",
		url: "../tool_ajax.php",
		data: dataString,
		cache: false,
		success: function(html) {
			var resposta = jQuery.parseJSON(html);
			if(resposta["descricao"] != "" && resposta["descricao"] != null) {
				$(".descricao<?php echo $sufix?>").show();			
				$("#descricao<?php echo $sufix?>").html(resposta["descricao"]);
			}
			$("#uso<?php echo $sufix?>").val(resposta["id_uso"]);
		} 
	});
}
function check_select(select_id) {
	var options = $("#"+select_id+" option");
	var retorno = true;
	if(options.length == 2) {
		var cnt = 0;
		options.each(function() {
			if(cnt == 1) {
				if($(this).val() == 0) {
					retorno = false;
				}
			}
			cnt++;
		});
	}
	return retorno;
}
function copiar() {
	document.getElementById('usuario').value = document.getElementById('usuario_ant').value;
	document.getElementById('titulo').value = document.getElementById('titulo_ant').value;
//	$.when(update_utilizacao(document.getElementById('tipo_ant').value, document.getElementById('utilizacao_ant').value)).done(function() {
//		$.when(update_formato(document.getElementById('utilizacao_ant').value, document.getElementById('formato_ant').value)).done(function() {
//			$.when(update_distribuicao(document.getElementById('formato_ant').value, document.getElementById('distribuicao_ant').value)).done(function() {
//				$.when(update_periodicidade(document.getElementById('distribuicao_ant').value, document.getElementById('periodicidade_ant').value)).done(function() {
//					$.when(update_tamanho(document.getElementById('periodicidade_ant').value, document.getElementById('tamanho_ant').value	)).done(function() {
//						update_uso(document.getElementById('tamanho_ant').value);				
//					});
//				});
//			});
//		});
//	});

	var idTipo = document.getElementById('tipo_ant').value;
	var idUtilizacao = document.getElementById('utilizacao_ant').value;
	var idFormato = document.getElementById('formato_ant').value;
	var idDistribuicao = document.getElementById('distribuicao_ant').value;
	var idPeriodicidade = document.getElementById('periodicidade_ant').value;
	var idTamanho = document.getElementById('tamanho_ant').value;
	var idUso = document.getElementById('uso_ant').value;
	
	update_utilizacao(idTipo, idUtilizacao);
	update_formato(idTipo, idUtilizacao, idFormato);
	update_distribuicao(idTipo, idUtilizacao, idFormato, idDistribuicao);
	update_periodicidade(idTipo, idUtilizacao, idFormato, idDistribuicao, idPeriodicidade);
	update_tamanho(idTipo, idUtilizacao, idFormato, idDistribuicao, idPeriodicidade, idTamanho);
	update_descricao(idUso);				
	
	document.getElementById('tipo').value = document.getElementById('tipo_ant').value;
	document.getElementById('utilizacao').value = document.getElementById('utilizacao_ant').value;
	document.getElementById('formato').value = document.getElementById('formato_ant').value;
	document.getElementById('distribuicao').value = document.getElementById('distribuicao_ant').value;
	document.getElementById('periodicidade').value = document.getElementById('periodicidade_ant').value;
	document.getElementById('tamanho').value = document.getElementById('tamanho_ant').value;
	
	document.getElementById('obs').value = document.getElementById('obs_ant').value;
};


$(document).ready(function() {
	$(".utilizacao<?php echo $sufix?>").hide();
	$(".formato<?php echo $sufix?>").hide();
	$(".distribuicao<?php echo $sufix?>").hide();
	$(".periodicidade<?php echo $sufix?>").hide();
	$(".tamanho<?php echo $sufix?>").hide();
	$(".descricao<?php echo $sufix?>").hide();
	$(".valor<?php echo $sufix?>").hide();
	
	$("#tipo<?php echo $sufix?>").change(function()	{
		$(".formato<?php echo $sufix?>").hide();
		$(".distribuicao<?php echo $sufix?>").hide();
		$(".periodicidade<?php echo $sufix?>").hide();
		$(".tamanho<?php echo $sufix?>").hide();
		$(".descricao<?php echo $sufix?>").hide();
		$(".valor<?php echo $sufix?>").hide();
		$("#uso<?php echo $sufix?>").val(0);
		$("#formato<?php echo $sufix?>").html('<option value="">--- Escolha uma utilização primeiro ---</option>');
		
		var id_tipo=$(this).val();
		update_utilizacao<?php echo $sufix?>(id_tipo);
	});
	$("#utilizacao<?php echo $sufix?>").change(function()	{
		$(".distribuicao<?php echo $sufix?>").hide();
		$(".periodicidade<?php echo $sufix?>").hide();
		$(".tamanho<?php echo $sufix?>").hide();
		$(".descricao<?php echo $sufix?>").hide();
		$(".valor<?php echo $sufix?>").hide();
		$("#uso<?php echo $sufix?>").val(0);
		$("#distribuicao<?php echo $sufix?>").html('<option value="">--- Escolha um formato primeiro ---</option>');
		
		var id_tipo=$("#tipo<?php echo $sufix?> option:selected").val();
		var id_utilizacao=$(this).val();
		update_formato<?php echo $sufix?>(id_tipo, id_utilizacao);
	});
	$("#formato<?php echo $sufix?>").change(function()	{
		$(".periodicidade<?php echo $sufix?>").hide();
		$(".tamanho<?php echo $sufix?>").hide();
		$(".descricao<?php echo $sufix?>").hide();
		$(".valor<?php echo $sufix?>").hide();
		$("#uso<?php echo $sufix?>").val(0);
		$("#periodicidade<?php echo $sufix?>").html('<option value="">--- Escolha uma distribuição primeiro ---</option>');
		
		var id_tipo=$("#tipo<?php echo $sufix?> option:selected").val();
		var id_utilizacao=$("#utilizacao<?php echo $sufix?> option:selected").val();
		var id_formato=$(this).val();
		
		update_distribuicao<?php echo $sufix?>(id_tipo, id_utilizacao, id_formato);
	});
	$("#distribuicao<?php echo $sufix?>").change(function() {
		$(".tamanho<?php echo $sufix?>").hide();
		$(".descricao<?php echo $sufix?>").hide();
		$(".valor<?php echo $sufix?>").hide();
		$("#uso<?php echo $sufix?>").val(0);
		$("#tamanho<?php echo $sufix?>").html('<option value="">--- Escolha a periodicidade primeiro ---</option>');
		
		var id_tipo=$("#tipo<?php echo $sufix?> option:selected").val();
		var id_utilizacao=$("#utilizacao<?php echo $sufix?> option:selected").val();
		var id_formato=$("#formato<?php echo $sufix?> option:selected").val();
		var id_distribuicao=$(this).val();
		
		update_periodicidade<?php echo $sufix?>(id_tipo, id_utilizacao, id_formato, id_distribuicao);
	});
	$("#periodicidade<?php echo $sufix?>").change(function() {
		$(".descricao<?php echo $sufix?>").hide();
		$(".valor<?php echo $sufix?>").hide();
		$("#uso<?php echo $sufix?>").val(0);
		
		var id_tipo=$("#tipo<?php echo $sufix?> option:selected").val();
		var id_utilizacao=$("#utilizacao<?php echo $sufix?> option:selected").val();
		var id_formato=$("#formato<?php echo $sufix?> option:selected").val();
		var id_distribuicao=$("#distribuicao<?php echo $sufix?> option:selected").val();
		var id_periodicidade=$(this).val();
		
		update_tamanho<?php echo $sufix?>(id_tipo, id_utilizacao, id_formato, id_distribuicao, id_periodicidade);
	});
	$("#tamanho<?php echo $sufix?>").change(function()	{
		var id_tipo=$("#tipo<?php echo $sufix?> option:selected").val();
		var id_utilizacao=$("#utilizacao<?php echo $sufix?> option:selected").val();
		var id_formato=$("#formato<?php echo $sufix?> option:selected").val();
		var id_distribuicao=$("#distribuicao<?php echo $sufix?> option:selected").val();
		var id_periodicidade=$("#periodicidade<?php echo $sufix?> option:selected").val();
		var id_tamanho=$(this).val();
		
		update_uso<?php echo $sufix?>(id_tipo, id_utilizacao, id_formato, id_distribuicao, id_periodicidade, id_tamanho);
	});
		
	$("#uso_video").change(function()	{
		var id=$(this).val();
		var dataString = 'action=tamanho&contrato=<?php echo isset($contrato)?$contrato:"V"?>&id_uso='+ id;

		$.ajax({
			type: "POST",
			url: "../tool_ajax.php",
			data: dataString,
			cache: false,
			success: function(html) {
				$(".tamanho").html(html);
			} 
		});
	});
});
</script>