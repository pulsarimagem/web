<script type="text/javascript">
$(document).ready(function(){ 
	$("#pfb").hide();
	$(".selectType").click(function() 
    {
        var id = $(this).val();
        $(".formCadastro").hide();
        $("#"+id).show();
    }); 
});
</script>
<?php
/* 
 * 
 * @var $this FormularioController
 * 
 * Variaveis recebidas pelo controller
 *  
 * @var $this strTypeForm Tipo do formulario que deve ser renderizado
 * @var $this objModelCadastro Instancia da Model
 * 
 * */
if($strFormEXT)
{
	$this->renderPartial('cadastroEXT', array('objModelCadastro'=>$objModelCadastroEXT, 'arrPais'=>$arrPais));
}
else 
{ 
	echo Yii::t('zii','Choose the type of registration').' '.CHtml::radioButton('selecionaForm',null, array('value'=>'pfb','class'=>'selectType',)).' '.Yii::t('zii','Individual').' '.CHtml::radioButton('selecionaForm', 'checked',array('value'=>'pjb','class'=>'selectType',)	).' '.Yii::t('zii','Legal entity');
?>	
	<div class="formCadastro" id="pfb">
	<?php 
	$this->renderPartial('cadastroPFB', array('objModelCadastro'=>$objModelCadastroBPF, 'arrPais'=>$arrPais, 'arrEstado'=> $arrEstado));
	?>
	</div>
	<div class="formCadastro" id="pjb">
	<?php 
	$this->renderPartial('cadastroPJB', array('objModelCadastro'=>$objModelCadastroBPJ, 'arrPais'=>$arrPais, 'arrEstado'=> $arrEstado));
	?>
	</div>
	<?php 
}
?>



