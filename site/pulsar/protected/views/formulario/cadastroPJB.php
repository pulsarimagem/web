<?php
/* @var $this CadastroController */
/* @var $objModelCadastro Cadastro */
/* @var $form CActiveForm */
?>
<div class="form">
<?php 
	$form=$this->beginWidget('CActiveForm', array(
	'id'=>'cadastro-cadastroPJB-form',
	'enableClientValidation'=>true,
	        'clientOptions'=>array(
	                'validateOnSubmit'=>true,
	        ),

)); 
?>
	
	<?php echo $form->errorSummary($objModelCadastro); ?>

	<div class="row">
		<?php echo $form->labelEx($objModelCadastro,'empresa'); ?>
		<?php echo $form->textField($objModelCadastro,'empresa'); ?>
		<?php echo $form->error($objModelCadastro,'empresa'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($objModelCadastro,'str_razao_social'); ?>
		<?php echo $form->textField($objModelCadastro,'str_razao_social'); ?>
		<?php echo $form->error($objModelCadastro,'str_razao_social'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($objModelCadastro,'int_inscricao_estadual'); ?>
		<?php 
				$form->widget('CMaskedTextField', array(
					'model' => $objModelCadastro,
		            'attribute' => 'int_inscricao_estadual',
		            'mask' => '999999999?9999',
		            'htmlOptions'=>array('size'=>'13')
	            ));
		?>
		<?php echo $form->error($objModelCadastro,'int_inscricao_estadual'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($objModelCadastro,'int_cnpj'); ?>
		<?php	
				$form->widget('CMaskedTextField', array(
					'model' => $objModelCadastro,
		            'attribute' => 'int_cnpj',
		            'mask' => '99.999.999.999/9999-99',
		            'htmlOptions'=>array('size'=>'14')
	            ));
		?>        
		<?php echo $form->error($objModelCadastro,'int_cnpj'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($objModelCadastro,'cargo'); ?>
		<?php echo $form->textField($objModelCadastro,'cargo'); ?>
		<?php echo $form->error($objModelCadastro,'cargo'); ?>
	</div>
	
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
		<?php	
				$form->widget('CMaskedTextField', array(
					'model' => $objModelCadastro,
		            'attribute' => 'cep',
		            'mask' => '99999-999',
		            'htmlOptions'=>array('size'=>'7')
	            ));
		?>
		<?php echo $form->error($objModelCadastro,'cep'); ?>
	</div>	

	<div class="row">
		<?php echo $form->labelEx($objModelCadastro,'endereco'); ?>
		<?php echo $form->textField($objModelCadastro,'endereco'); ?>
		<?php echo $form->error($objModelCadastro,'endereco'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($objModelCadastro,'str_numero'); ?>
		<?php echo $form->textField($objModelCadastro,'str_numero'); ?>
		<?php echo $form->error($objModelCadastro,'str_numero'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($objModelCadastro,'str_complemento'); ?>
		<?php echo $form->textField($objModelCadastro,'str_complemento'); ?>
		<?php echo $form->error($objModelCadastro,'str_complemento'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($objModelCadastro,'estado'); ?>
		<?php echo $form->dropDownList(
					$objModelCadastro, 
					'estado', 
					$arrEstado
					); ?>
		<?php echo $form->error($objModelCadastro,'estado'); ?>
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
		<?php echo $form->labelEx($objModelCadastro,'int_ddd'); ?>
		<?php 
				$form->widget('CMaskedTextField', array(
						'model' => $objModelCadastro,
			            'attribute' => 'int_ddd',
			            'mask' => '(99)',
			            'htmlOptions'=>array('size'=>'2')
		        ));
		 ?>
		<?php echo $form->error($objModelCadastro,'int_ddd'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($objModelCadastro,'telefone'); ?>
		<?php 
				$form->widget('CMaskedTextField', array(
						'model' => $objModelCadastro,
			            'attribute' => 'telefone',
			            'mask' => '99999-999?9',
			            'htmlOptions'=>array('size'=>'9')
		        ));
		 ?>
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