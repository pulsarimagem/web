<?php
/* @var $this CadastroController */
/* @var $model Cadastro */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'cadastro-cadastroPFB-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'senha'); ?>
		<?php echo $form->textField($model,'senha'); ?>
		<?php echo $form->error($model,'senha'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'tim_data_ultimo_acesso'); ?>
		<?php echo $form->textField($model,'tim_data_ultimo_acesso'); ?>
		<?php echo $form->error($model,'tim_data_ultimo_acesso'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'limite'); ?>
		<?php echo $form->textField($model,'limite'); ?>
		<?php echo $form->error($model,'limite'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'id_cliente_sig'); ?>
		<?php echo $form->textField($model,'id_cliente_sig'); ?>
		<?php echo $form->error($model,'id_cliente_sig'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'id_contato_sig'); ?>
		<?php echo $form->textField($model,'id_contato_sig'); ?>
		<?php echo $form->error($model,'id_contato_sig'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'int_ddd'); ?>
		<?php echo $form->textField($model,'int_ddd'); ?>
		<?php echo $form->error($model,'int_ddd'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'int_ddi'); ?>
		<?php echo $form->textField($model,'int_ddi'); ?>
		<?php echo $form->error($model,'int_ddi'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'int_inscricao_estadual'); ?>
		<?php echo $form->textField($model,'int_inscricao_estadual'); ?>
		<?php echo $form->error($model,'int_inscricao_estadual'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'int_cnpj'); ?>
		<?php echo $form->textField($model,'int_cnpj'); ?>
		<?php echo $form->error($model,'int_cnpj'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'int_cpf'); ?>
		<?php echo $form->textField($model,'int_cpf'); ?>
		<?php echo $form->error($model,'int_cpf'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'nome'); ?>
		<?php echo $form->textField($model,'nome'); ?>
		<?php echo $form->error($model,'nome'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'empresa'); ?>
		<?php echo $form->textField($model,'empresa'); ?>
		<?php echo $form->error($model,'empresa'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'endereco'); ?>
		<?php echo $form->textField($model,'endereco'); ?>
		<?php echo $form->error($model,'endereco'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'str_razao_social'); ?>
		<?php echo $form->textField($model,'str_razao_social'); ?>
		<?php echo $form->error($model,'str_razao_social'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'str_segundo_nome'); ?>
		<?php echo $form->textField($model,'str_segundo_nome'); ?>
		<?php echo $form->error($model,'str_segundo_nome'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cargo'); ?>
		<?php echo $form->textField($model,'cargo'); ?>
		<?php echo $form->error($model,'cargo'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cidade'); ?>
		<?php echo $form->textField($model,'cidade'); ?>
		<?php echo $form->error($model,'cidade'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'telefone'); ?>
		<?php echo $form->textField($model,'telefone'); ?>
		<?php echo $form->error($model,'telefone'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'str_primeiro_nome'); ?>
		<?php echo $form->textField($model,'str_primeiro_nome'); ?>
		<?php echo $form->error($model,'str_primeiro_nome'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cpf_cnpj'); ?>
		<?php echo $form->textField($model,'cpf_cnpj'); ?>
		<?php echo $form->error($model,'cpf_cnpj'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cep'); ?>
		<?php echo $form->textField($model,'cep'); ?>
		<?php echo $form->error($model,'cep'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'estado'); ?>
		<?php echo $form->textField($model,'estado'); ?>
		<?php echo $form->error($model,'estado'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'pais'); ?>
		<?php echo $form->textField($model,'pais'); ?>
		<?php echo $form->error($model,'pais'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'download'); ?>
		<?php echo $form->textField($model,'download'); ?>
		<?php echo $form->error($model,'download'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'idioma'); ?>
		<?php echo $form->textField($model,'idioma'); ?>
		<?php echo $form->error($model,'idioma'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email'); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'login'); ?>
		<?php echo $form->textField($model,'login'); ?>
		<?php echo $form->error($model,'login'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'tipo'); ?>
		<?php echo $form->textField($model,'tipo'); ?>
		<?php echo $form->error($model,'tipo'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'temporario'); ?>
		<?php echo $form->textField($model,'temporario'); ?>
		<?php echo $form->error($model,'temporario'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'data_cadastro'); ?>
		<?php echo $form->textField($model,'data_cadastro'); ?>
		<?php echo $form->error($model,'data_cadastro'); ?>
	</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton('Submit'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->