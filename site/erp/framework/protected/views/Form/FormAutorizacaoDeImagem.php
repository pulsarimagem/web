<?php 
//Inicio, arquivos para a pagina em questao
	
	//Inicio, css
	Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/FormFormAutorizacaoImagem.css?v=1.1');
	//Fim, css
	
//Fim, arquivos para a pagina em questao
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'autorizacao-imagem-formBase-form',
	'enableAjaxValidation'=>false,
	//'htmlOptions' => array('enctype' => 'multipart/form-data'),
	'clientOptions'=>array(
      'validateOnSubmit'=>true,
     ),
     'htmlOptions' => array(
     	'enctype' => 'multipart/form-data'
     ),
)); ?>
	
	<div class="rowForm">
		<?php echo $form->labelEx($objModelAutorizacaoImagem,'str_sigla_autor'); ?>
		<?php echo CHtml::dropDownList('str_sigla_autor', '', CHtml::listData(Fotografos::model()->findAll(), 'Iniciais_Fotografo', 'Iniciais_Fotografo')); ?>
		<?php echo $form->error($objModelAutorizacaoImagem,'str_sigla_autor'); ?>
	</div>
		
	<div class="rowForm">
		<?php echo $form->labelEx($objModelAutorizacaoImagem,'str_nome_arquivo_autorizacao'); ?>
		<?php echo $form->fileField($objModelAutorizacaoImagem,'str_nome_arquivo_autorizacao',array('value'=>''));?>
		<?php echo $form->error($objModelAutorizacaoImagem,'str_nome_arquivo_autorizacao'); ?>
	</div>

	<div class="rowForm">
		<?php echo $form->labelEx($objModelAutorizacaoImagem,'dat_data'); ?>
		<?php echo $form->textField($objModelAutorizacaoImagem,'dat_data',array('placeholder'=>'ex.: mm/aaaa','value'=>'')); ?>
		<?php echo $form->error($objModelAutorizacaoImagem,'dat_data'); ?>
	</div>

	<div class="rowForm">
		<?php echo $form->labelEx($objModelAutorizacaoImagem,'str_autorizado_por'); ?>
		<?php echo $form->textField($objModelAutorizacaoImagem,'str_autorizado_por',array('placeholder'=>'nome completo','value'=>'')); ?>
		<?php echo $form->error($objModelAutorizacaoImagem,'str_autorizado_por'); ?>
	</div>
	
	<div class="rowForm">
		<?php echo $form->labelEx($objModelAutorizacaoImagem,'str_descricao'); ?>
		<?php echo $form->textField($objModelAutorizacaoImagem,'str_descricao',array('placeholder'=>'nome completo do autorizado','value'=>'')); ?>
		<?php echo $form->error($objModelAutorizacaoImagem,'str_descricao'); ?>
	</div>	

	<div class="rowForm">
		<?php echo $form->labelEx($objModelAutorizacaoImagem,'str_cidade'); ?>
		<?php echo $form->textField($objModelAutorizacaoImagem,'str_cidade',array('value'=>'')); ?>
		<?php echo $form->error($objModelAutorizacaoImagem,'str_cidade'); ?>
	</div>

	<div class="rowForm">
		<?php echo $form->labelEx($objModelAutorizacaoImagem,'str_estado'); ?>
		<?php echo CHtml::dropDownList('str_estado', '',CHtml::listData(Estados::model()->findAll(), 'Sigla', 'Sigla')); ?>
		<?php echo $form->error($objModelAutorizacaoImagem,'str_estado'); ?>
	</div>


	<div class="rowForm buttons">
		<?php echo CHtml::submitButton('Gravar', array('class'=>'btn btn-primary')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->