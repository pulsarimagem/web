<div class="action-image" id="sticker">
  <ul>
    <li class="meucadastro"><a href="dadoscadastrais.php" title="Meu cadastro">Meu cadastro</a></li>
<?php if($totalRows_fotos_download > 0) {?>    
    <li class="download"><a href="historicodownload.php" title="Histórico de Downloads">Histórico de Downloads</a></li>
<?php } ?>
  </ul>
  <br/>
  <br/>
  <br/>
  <ul>
    
    <li class="criar-pasta"><a href="#" onClick="MM_callJS('document.form1.opcao.value=\'new\';document.form1.submit();')" title="Criar pasta">Criar pasta</a></li>
    <li class="renomear-pasta"><a href="#" onClick="MM_callJS('document.form1.opcao.value=\'rename\';validate2(document.form1);')" title="Renomear pasta">Renomear pasta</a></li>
    <li class="excluir-pasta"><a href="#" onClick="MM_callJS('document.form1.opcao.value=\'delete\';validate(document.form1);')" title="Excluir">Excluir</a></li>
    <li class="unir-pasta"><a href="#" onClick="MM_callJS('document.form1.opcao.value=\'mesclar\';validate5(document.form1);')" title="Excluir">Unir</a></li>
    <li class="cotacao"><a href="#" onClick="MM_callJS('document.form1.opcao.value=\'quote\';validate4(document.form1);')" title="Cotar">Cotar</a></li>
    <li class="email"><a href="#" onClick="MM_callJS('validate3(document.form1);')" title="Enviar por email">Enviar por email</a></li> 
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

