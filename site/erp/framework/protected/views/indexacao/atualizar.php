<?php 
	//Inicio, js
	Yii::app()->clientScript->registerScript('autorizacao-atualizar',"
	
	
		$('.0').hide();
	
		$('.atualizar-codigoFoto div').click(function()
			{
				$(this).attr('class','0');
				$(this).hide();
				
				$('#remove_'+$(this).attr('value')).attr('class','1');
				$('#remove_'+$(this).attr('value')).show();
				
				var strIdCodigo = $('.idCodigo').attr('value');
				var strNewIdCodigo = ','+$(this).attr('value');
				$('.idCodigo').attr('value', strIdCodigo+strNewIdCodigo);
			}
		);
		
		$('.atualizar-SelectCodigoFoto div').click(function()
			{
				$(this).attr('class','0');
				$(this).hide();
				
				$('#add_'+$(this).attr('value')).attr('class','codigo');
				$('#add_'+$(this).attr('value')).show();
				
				var strIdCodigo = $('.idCodigo').attr('value');
				
				var strRemoveIdCodigo = ','+$(this).attr('value');
				
				var strNewIdCodigo = strIdCodigo.replace(strRemoveIdCodigo,'');
				$('.idCodigo').attr('value', strNewIdCodigo);
				
			}
		);
		
		$('.atualizar-codigoAutorizacao div').click(function()
			{
				$(this).attr('class','0');
				$(this).hide();
				
				$('#remove_'+$(this).attr('value')).attr('class','1');
				$('#remove_'+$(this).attr('value')).show();
				
				var strIdAutorizacao = $('.idAutorizacao').attr('value');
				
				var strRemoveIdAutorizacao = ','+$(this).attr('value');
				
				var strNewIdAutorizacao = strIdAutorizacao.replace(strRemoveIdAutorizacao,'');
				$('.idAutorizacao').attr('value', strNewIdAutorizacao);
			}
		);
		
		$('.atualizar-SelectCodigoAutorizacao div').click(function()
			{
				$(this).attr('class','0');
				$(this).hide();
				
				$('#add_'+$(this).attr('value')).attr('class','1');
				$('#add_'+$(this).attr('value')).show();
				
				var strIdAutorizacao = $('.idAutorizacao').attr('value');
				var strNewIdAutorizacao = ','+$(this).attr('value');
				$('.idAutorizacao').attr('value', strIdAutorizacao+strNewIdAutorizacao);
				
			}
		);
		
		$('#atualizar-botao-save').click(function(){
			var idCodigo = $('.idCodigo').val();
			var idAutorizacao = $('.idAutorizacao').val(); 
			
			if(idCodigo == '')
			{
				$('.atualizacao-messagemDeErro').show();
				$('#erroCodigo').show();
				if(idAutorizacao == '')
				{
					$('#erroAutorizacao').show();
				}
				else
				{
					$('#erroAutorizacao').hide();
				}
				return false;
			}
			
			if(idAutorizacao == '')
			{
				$('.atualizacao-messagemDeErro').show();
				$('#erroCodigo').hide();
				$('#erroAutorizacao').show();
				return false;
			}
			
		});
	");
	//Fim, js

?>
<?php if(isset($arrReturnView['arrReturnDB']) && isset($arrReturnView['arrAutorizacao']) ):?>
<div class="atualizacao-messagemDeErro">
	<div id="erroCodigo">O campo c&oacute;digo adicionado n&atilde;o pode estar vazio</div>
	<div id="erroAutorizacao">O campo autoriza&ccedil;&atilde;o adicionado n&atilde;o pode estar vazio</div>
</div>
<?php if(isset($arrReturnView['strSucessoAutorizacao'])):?>
<div class="atualizacao-messagemDeSucesso">
	<?php echo $arrReturnView['strSucessoAutorizacao'];?>
</div>	
<?php endif;?>
<div class="atualizar-conteiner">
	<div class="atualizar-label">C&oacute;digo</div>
	<div class="atualizar-label">C&oacute;digo adicionado</div>
</div>
<div class="atualizar-conteiner">
	<div class="atualizar-codigoFoto">
		<?php foreach ($arrReturnView['arrReturnDB'] as $arrValue):?>
		<div value="<?php echo $arrValue['Id_Foto'];?>" name="<?php echo $arrValue['codigo'];?>" class="1" id="add_<?php echo $arrValue['Id_Foto'];?>"> [+] <?php echo $arrValue['codigo'];?></div>
		<?php endforeach;?>
	</div>
	
	<div class="atualizar-SelectCodigoFoto">
		<?php foreach ($arrReturnView['arrReturnDB'] as $arrValue):?>
		<div value="<?php echo $arrValue['Id_Foto'];?>" name="<?php echo $arrValue['codigo'];?>" class="0" id="remove_<?php echo $arrValue['Id_Foto'];?>"> [-] <?php echo $arrValue['codigo'];?></div>
		<?php endforeach;?>
	</div>
	
	<div class="atualizar-conteiner">
		<div class="atualizar-label">Autoriza&ccedil;&atilde;o adicionada</div>
		<div class="atualizar-label">Autoriza&ccedil;&atilde;o</div>
	</div>	
	
	<div class="atualizar-codigoAutorizacao">
		<?php foreach ($arrReturnView['arrAutorizacao'] as $arrValue):?>
		<div value="<?php echo $arrValue['id_autorizacao_imagem'];?>"  class="0" id="add_<?php echo $arrValue['id_autorizacao_imagem'];?>"> [-] <?php echo utf8_decode($arrValue['str_descricao']).' - '.utf8_decode($arrValue['str_autorizado_por']);?></div>
		<?php endforeach;?>
	</div>

	<div class="atualizar-SelectCodigoAutorizacao">
		<?php foreach ($arrReturnView['arrAutorizacao'] as $arrValue):?>
		<div value="<?php echo $arrValue['id_autorizacao_imagem'];?>"  class="1"  id="remove_<?php echo $arrValue['id_autorizacao_imagem'];?>"> [+] <?php echo utf8_decode($arrValue['str_descricao']).' - '.utf8_decode($arrValue['str_autorizado_por']);?></div>
		<?php endforeach;?>
	</div>
	<?php echo CHtml::form(Yii::app()->baseUrl.'/Indexacao/autorizacao/principal/Indexação/pagina/autorizacao/&yt1=Buscar','GET');?>
		<?php echo CHtml::hiddenField('idCodigo','',array('class'=>'idCodigo'));?>	
		<?php echo CHtml::hiddenField('idAutorizacao','',array('class'=>'idAutorizacao'));?>
		
		<?php echo CHtml::hiddenField('idFotografo',$_GET['idFotografo'],array('class'=>'idFotografo'));?>	
		<?php echo CHtml::hiddenField('listarPendente',$_GET['listarPendente'],array('class'=>'listarPendente'));?>
	
	<div class="rowForm buttons" >
		<?php echo CHtml::submitButton('Salvar', array('class'=>'btn btn-primary', 'id'=>'atualizar-botao-save')); ?>
	</div>
	<?php echo CHtml::endForm();?>
</div>
<?php endif;?>