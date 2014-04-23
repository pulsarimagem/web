<?php
/* @var $this CadastroController */
/* @var $objModelCadastro Cadastro */
/* @var $form CActiveForm */
?>
<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'cadastro-cadastroPFB-form',
	'enableClientValidation'=>true,
	        'clientOptions'=>array(
	                'validateOnSubmit'=>true,
	        ),

)); ?>

	<?php echo $form->errorSummary($objModelCadastro); ?>
	
	<div class="row">
		<?php echo $form->labelEx($objModelCadastro,'str_primeiro_nome'); ?>
		<?php echo $form->textField($objModelCadastro,'str_primeiro_nome'); ?>
		<?php echo $form->error($objModelCadastro,'str_primeiro_nome'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($objModelCadastro,'str_segundo_nome'); ?>
		<?php echo $form->textField($objModelCadastro,'str_segundo_nome'); ?>
		<?php echo $form->error($objModelCadastro,'str_segundo_nome'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($objModelCadastro,'cep'); ?>
		<?php echo $form->textField($objModelCadastro,'cep');?>
		<?php echo $form->error($objModelCadastro,'cep'); ?>
	</div>	

	<div class="row">
		<?php echo $form->labelEx($objModelCadastro,'endereco'); ?>
		<?php echo $form->textField($objModelCadastro,'endereco'); ?>
		<?php echo $form->error($objModelCadastro,'endereco'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($objModelCadastro,'pais'); ?>
		<?php echo $form->dropDownList(
					$objModelCadastro, 
					'pais', 
					$arrPais
					); ?>
		<?php echo $form->error($objModelCadastro,'pais'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($objModelCadastro,'cidade'); ?>
		<?php echo $form->textField($objModelCadastro,'cidade'); ?>
		<?php echo $form->error($objModelCadastro,'cidade'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($objModelCadastro,'int_ddi'); ?>
		<?php 
				$form->widget('CMaskedTextField', array(
						'model' => $objModelCadastro,
			            'attribute' => 'int_ddi',
			            'mask' => '(99)',
			            'htmlOptions'=>array('size'=>'2')
		        ));
		?>
		<?php echo $form->error($objModelCadastro,'int_ddi'); ?>
	</div>	

	<div class="row">
		<?php echo $form->labelEx($objModelCadastro,'telefone'); ?>
		<?php echo $form->textField($objModelCadastro, 'telefone');?>
		<?php echo $form->error($objModelCadastro,'telefone'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($objModelCadastro,'email'); ?>
		<?php echo $form->textField($objModelCadastro,'email'); ?>
		<?php echo $form->error($objModelCadastro,'email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($objModelCadastro,'email_confirma'); ?>
		<?php echo $form->textField($objModelCadastro,'email_confirma'); ?>
		<?php echo $form->error($objModelCadastro,'email_confirma'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($objModelCadastro,'senha'); ?>
		<?php echo $form->passwordField($objModelCadastro,'senha'); ?>
		<?php echo $form->error($objModelCadastro,'senha'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($objModelCadastro,'senha_confirma'); ?>
		<?php echo $form->passwordField($objModelCadastro,'senha_confirma'); ?>
		<?php echo $form->error($objModelCadastro,'senha_confirma'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($objModelCadastro,'int_newsletter'); ?>
		<?php echo $form->checkBox($objModelCadastro,'int_newsletter',array('checked'=>'checked')); ?>
		<?php echo $form->error($objModelCadastro,'int_newsletter'); ?>
	</div>

	<div class="row">
		<?php echo $form->dropDownList(
					$objModelCadastro, 
					'int_tipo_newsletter', 
					array(
						'1'=>'Editorial',
						'2'=>'Publicitário'
					) 
					); ?>
		<?php echo $form->error($objModelCadastro,'int_tipo_newsletter'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($objModelCadastro,'int_termo_condicao'); ?>
		<?php echo $form->checkBox($objModelCadastro,'int_termo_condicao'); ?>
		<?php echo $form->error($objModelCadastro,'int_termo_condicao'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton(Yii::t('zii', 'Sign up')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->