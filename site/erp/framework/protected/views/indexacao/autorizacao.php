<?php 
//Inicio, arquivos para a pagina em questao
	
	//Inicio, css
	Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/IndexacaoAutorizacaoImagem.css?v=1.1');
	//Fim, css
	
	//Inicio, js
	Yii::app()->clientScript->registerScript('AutorizacaoDeImagem',"
		
		var strIdControllerPadrao = '".$strPostOrDefault."';
	
		$('.botao-submenu:first').css('margin-left','-10px');
		
		$('#'+strIdControllerPadrao).fadeIn(1000);
		
		$('.botao-submenu').click(function(){
			$('.mensagem').hide();
			$('.infomacaoDoSubmenu').hide();
			$('.botao-submenu-selecionado').attr('class','botao-submenu');
			$(this).attr('class','botao-submenu-selecionado');
			var intIdShow = $(this).attr('iddiv');
			$('#'+intIdShow).fadeIn(1000);
			
		});	
	");
	//Fim, js
	
//Fim, arquivos para a pagina em questao
?>
<?php
//Inicio, HTML com o titulo da pagina
echo $strTituloPagina;
//Fim, HTML com o titulo da pagina

//Inicio, HTML com o BreadCrumb
echo $strBreadCrumb;
//Fim, HTML com o BreadCrumb
?>
<div class="conteudo">
	<div class="conteudo-submenu">
<!-- inicio, botao-submenu -->	
		<div class="botao-submenu" id="aba-subirAutorizacao" iddiv="subirAutorizacao"><?php echo utf8_decode(Yii::t('zii','SUBIR AUTORIZAÇÃO'));?></div>
		<div class="botao-submenu" id="aba-listarPendentes" iddiv="listarPendentes"><?php echo Yii::t('zii','FOTOS PENDENTES');?></div>
		<div class="botao-submenu" id="aba-atualizarFotoAutorizacao" iddiv="atualizarFotoAutorizacao" ><?php echo Yii::t('zii','ATUALIZAR LOTES');?></div>
<!-- Fim, botao-submenu -->		
	</div>
<!-- inicio, Default -->		
	<div class="infomacaoDoSubmenu" id="default">
		<?php echo Yii::t('zii','Por favor, selecione um dos itens acima para continuar.');?>
	</div>
<!-- fim, Default -->		
<!-- inicio, subirAutorizacao -->	
	<div class="infomacaoDoSubmenu" id="subirAutorizacao">
<!-- inicio, Mensagem de subir autorizacao -->		
		<?php if($strMensagemDeErro != null): ?>	
			<div class="mensagem" id="mensagemDeErro">
				<?php echo $strMensagemDeErro;?>
			</div>
		<?php elseif($strMensagemDeSucesso != null): ?>
			<div class="mensagem" id="mensagemDeSucesso">
				<?php echo $strMensagemDeSucesso;?>
			</div>
		<?php endif; ?>
<!-- fim, Mensagem de subir autorizacao -->		
		<?php	
			//Inicio, Formulario para subir uma nova autorizacao 
			
			$this->renderPartial(
				'../Form/FormAutorizacaoDeImagem',
				array
				(
					'objModelAutorizacaoImagem' => $objModelAutorizacaoImagem,
					'objDropDownFotografo'		=> $objDropDownFotografo,
				)
			);
			
			//Fim, Formulario para subir uma nova autorizacao 
		?>
	</div>
<!-- fim, subirAutorizacao -->	

<!-- inicio, infomacaoDoSubmenu -->	
	<div class="infomacaoDoSubmenu" id="listarPendentes">
		<?php
			//Inicio, listagem de autorizações pendentes 
			$this->renderPartial(
				'listarPendente',
				array
				(
					'arrReturnFotografosAutorizacaoPendente' => $arrReturnFotografosAutorizacaoPendente,
					'arrReturnView'							 => $arrReturnView,
				)
			);
			//Fim, listagem de autorizações pendentes 
		?>
	</div>
<!-- fim, listarPendentes -->
		
<!-- inicio, infomacaoDoSubmenu -->		
	<div class="infomacaoDoSubmenu" id="atualizarFotoAutorizacao">
		<?php
			//Inicio, listagem de autorizações pendentes 
			$this->renderPartial(
				'atualizar',
				array
				(
					'arrReturnFotografosAutorizacaoPendente' => $arrReturnFotografosAutorizacaoPendente,
					'arrReturnView'							 => $arrReturnView,
				)
			);
			//Fim, listagem de autorizações pendentes 
		?>
	</div>
<!-- fim, infomacaoDoSubmenu -->		
</div>
