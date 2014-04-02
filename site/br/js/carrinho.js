// JavaScript Document

	
		//finaliza o carrinho
		$("a.finalizar-compra").live('click',function(){
			/*$('.dados-usuario').html('<img src="../images/loading.gif" border="0" id="loader" />').fadeIn(300);
			/// verifica usuario logado
			$.ajax({
				type: 'POST',
				url: 'ecommerce/processa.php',
				cache: false,
				data: 'acao=logado',
				success: function(j){
					$('#loader').fadeOut('slow');					
					$('.dados-usuario').hide();
					if(j == 1){
						$('.dados-usuario').html('<script></script>').fadeIn('slow');
					} else {
						$('.dados-usuario').html(j).fadeIn('slow');
						}
					}
			});*/
			document.location ="carrinho-concluido.php";
			return false;
		});
		
		// botao continuar comprando
		$("a.continuar-comprando").live('click',function(){
			document.location='listing.php';
			return false;
			});
		
		// botao cadastro usuario
		$("input.cadastrouser").live('click',function(){
			document.location='cadastro.php';
			return false;
			});
			
