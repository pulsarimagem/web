<div class="action-image">
  <ul>
    
    <li class="trocar-pasta"><a href="#" title="Trocar de pasta">Copy</a></li>
    <li class="excluir-pasta"><a href="#" title="Excluir">Delete</a></li>
    <li class="cotacao"><a href="<?php print $_SESSION['last_detail']; ?>&cotar=true" title="Cotar">Add to cart</a></li>
    <li class="download"><a href="details_download.php?tombo=<?php echo $tombo;?>" title="Download">Download</a></li>
    <li class="email"><a href="enviarporemail.php?tombo=<?php echo $tombo;?>" title="Enviar por email">Send via e-mail</a></li> 
  </ul>
  <br />
  <ul>
    <li class="meucadastro"><a href="#" title="Meu cadastro">My details</a></li>
    <li class="download"><a href="details_download.php?tombo=<?php echo $tombo;?>" title="Hist�rico de Downloads">Download history</a></li>
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

