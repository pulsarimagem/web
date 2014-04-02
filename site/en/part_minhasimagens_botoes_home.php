<div class="action-image" id="sticker">
  <ul>
    <li class="meucadastro"><a href="dadoscadastrais.php" title="Meu cadastro">My details</a></li>
<?php if($totalRows_fotos_download > 0) {?>    
    <li class="download"><a href="historicodownload.php" title="Histórico de Downloads">Downloads history</a></li>
<?php } ?>
  </ul>
  <br/>
  <br/>
  <br/>
  <ul>
    
    <li class="criar-pasta"><a href="#" onClick="MM_callJS('document.form1.opcao.value=\'new\';document.form1.submit();')" title="Criar pasta">Create new folder</a></li>
    <li class="renomear-pasta"><a href="#" onClick="MM_callJS('document.form1.opcao.value=\'rename\';validate2(document.form1);')" title="Renomear pasta">Rename folder</a></li>
    <li class="excluir-pasta"><a href="#" onClick="MM_callJS('document.form1.opcao.value=\'delete\';validate(document.form1);')" title="Excluir">Delete</a></li>
    <li class="unir-pasta"><a href="#" onClick="MM_callJS('document.form1.opcao.value=\'mesclar\';validate5(document.form1);')" title="Excluir">Merge</a></li>
    <li class="carrinho"><a href="#" onClick="MM_callJS('document.form1.opcao.value=\'quote\';validate4(document.form1);')" title="Cotar">Add to shopping cart</a></li>
    <!--<li class="cotacao"><a href="#" onClick="MM_callJS('document.form1.opcao.value=\'quote\';validate4(document.form1);')" title="Cotar">Cotação</a></li>-->
    <li class="email"><a href="#" onClick="MM_callJS('validate3(document.form1);')" title="Enviar por email">Send via e-mail</a></li> 
  </ul>
</div>

<!--					<div class="bts">
						<div class="left">
							<div class="bt-criarnovapasta"><a href="#" onClick="MM_callJS('document.form1.opcao.value=\'new\';document.form1.submit();')"></a></div>
							<div class="bt-deletar"><a href="#" onClick="MM_callJS('document.form1.opcao.value=\'delete\';validate(document.form1);')"></a></div>
						</div>
						<div class="right">
							<div class="bt-renomearpasta"><a href="#" onClick="MM_callJS('document.form1.opcao.value=\'rename\';validate2(document.form1);')"></a></div>
							<div class="bt-unirpastas"><a href="#" onClick="MM_callJS('document.form1.opcao.value=\'mesclar\';validate5(document.form1);')"></a></div>
							<div class="bt-cotar"><a href="#" onClick="MM_callJS('document.form1.opcao.value=\'quote\';validate4(document.form1);')"></a></div>
							<div class="bt-enviarpastaporemail"><a href="#" onClick="MM_callJS('validate3(document.form1);')"></a></div>
						</div>
						<div class="clear"></div>
					</div>-->

