<?php 
	//Inicio, js
	Yii::app()->clientScript->registerScript('autorizacao-listarPendente',"
	
		$('.spanCodigo').click(function()
			{
				var intCodigo = $(this).attr('val');
				var intView = $(this).attr('view');
				
				if(intView == 0)
				{
					$('#'+intCodigo).show();
					$(this).attr('view',1);
				}
				else
				{
					$('#'+intCodigo).hide();
					$(this).attr('view',0);
				}
				
			}
		);
	");
	//Fim, js

?>
<div class="form">
	<?php echo CHtml::form('autorizacao','get');?>
	<div class="rowForm">
		<?php echo CHtml::label('Sigla autor','idFotografo');?>
		<?php echo CHtml::dropDownList('idFotografo', (isset($_GET['idFotografo']) ? ($_GET['idFotografo'] != '' ? $_GET['idFotografo'] : '') : ''), $arrReturnFotografosAutorizacaoPendente); ?>
		<?php echo CHtml::hiddenField('listarPendente', '1');?>
	</div>
	
	<div class="rowForm buttons" >
		<?php echo CHtml::submitButton((isset($_GET['idFotografo']) ? ($_GET['idFotografo'] != '' ? 'Nova busca' : 'Buscar') : 'Buscar'), array('class'=>'btn btn-primary', 'id'=>'listaPendenteButton')); ?>
	</div>
	<?php echo CHtml::endForm();?>
</div><!-- form -->

<?php 
if($arrReturnView['strMensagemDeErro']):
	if(isset($_GET['idFotografo'])):
		echo $arrReturnView['strMensagemDeErro'];
	endif;	
else:
?> 
	<div class="listagemDeImagensSemAutorizacaoPorAutor">
		<div class='cabecalho'>
			<div class="label2"><strong>ID DA FOTO</strong></div>
			<div class="label2"><strong>DIREITO DE IMAGEM</strong></div>
			<div class="label2"><strong>STATUS</strong></div>
			<div class="label2"><strong>C&Oacute;DIGO</strong></div>
			<div id="label2"><?php echo count($arrReturnView['arrReturnDB'])?> <strong>IMAGENS PENDENTES </strong></div>
		</div>
	
<?php 
	if(count($arrReturnView['arrReturnDB']) > 0):
		$intCountLoop = 0;
		foreach ($arrReturnView['arrReturnDB'] as $arrValue):
?>
		<div class='cabecalho' style="background-color:<?php echo (($intCountLoop % 2) == 0 ? '#d6d6d6' : '#fff' );?>">
			<div class="label2" style="background-color:<?php echo (($intCountLoop % 2) == 0 ? '#d6d6d6' : '#fff' );?>"><?php echo $arrValue['Id_Foto'];?></div>
			<div class="label2" style="background-color:<?php echo (($intCountLoop % 2) == 0 ? '#d6d6d6' : '#fff' );?>"><?php echo ($arrValue['direito_img']== 1 ? 'uso de imagem autorizado' : '');?></div>
			<div class="label2" style="background-color:<?php echo (($intCountLoop % 2) == 0 ? '#d6d6d6' : '#fff' );?>"><?php echo ($arrValue['status']== 0 ? 'pendente' : '');?></div>
			<div class="label2" style="background-color:<?php echo (($intCountLoop % 2) == 0 ? '#d6d6d6' : '#fff' );?>">
				
				<div class="bannerImage" id="<?php echo $arrValue['codigo'];?>" ><?php echo CHtml::image($this->strUrlStockPhotosInServer.$arrValue['codigo'].'p.jpg');?></div>
				<span class="spanCodigo" val="<?php echo $arrValue['codigo'];?>" view="0"><?php echo $arrValue['codigo'];?></span>
			</div>
		</div>			
<?php 	
			$intCountLoop++;	
		endforeach;
	endif;
?>
	</div>
<?php
endif;
?>