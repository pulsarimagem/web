<?php
if(isset($menu_busca_adv)) {
	include_once("inc_menu_p2_busca_adv.php");
} else {
	include_once("inc_menu_p2.php");
} 

?>

<div class="socialbar size960">
	<div class="social">
		<a href="http://www.facebook.com/pulsar.imagens" class="facebook" target="_blank"></a>
		<a href="http://www.flickr.com/photos/pulsarimagens/" class="flickr" target="_blank"></a>
	</div>
	<div class="newsletter">
		<form name="form_newsletter" method="get" action="tool_newsletter.php">
			<label>Assine nosso Newsletter:</label>
			<div class="form">
				<input id="newsletter_email" name="email" type="text" class="text"/>
				<input id="newsletter_email_clear" type="text" class="text" value="email"/> 
				<select name="tipo" class="select">
				<option>Editorial</option>
				<option>Publicit�rio</option>
				</select>
				<input name="action" type="submit" class="button" value="Ok" />
			</div>
		</form>
	</div>
	<div class="clear"></div>
</div>

<div class="map size960">
	<a href="#" class="logo"></a>
	<div class="col">
		<dl>
			<dt>Sess�es</dt>
			<dd><a href="index.php">Home</a></dd>
            <dd><a href="quemsomos.php">Quem Somos</a></dd>
			<dd><a href="fotografos.php">Fot�grafos</a></dd>
			<dd><a href="primeirapagina.php">Minhas Imagens</a></dd>
            <dd><a href="solicitarcotacao.php">Cota��o</a></dd>
			<dd><a href="cadastro.php">Cadastro</a></dd>
			<dd><a href="buscaavancada.php">Busca avan�ada</a></dd>
		</dl>
	</div>
	<div class="col">
		<dl>
			<dt>Navega��o Auxiliar</dt>
            <dd><a href="comofunciona.php">Como Funciona?</a></dd>
			<dd><a href="faq.php">D�vidas</a></dd>
			<dd><a href="contato.php">Contato</a></dd>
		</dl>
	</div>
	<div class="col">
		<dl>
			<dt>Contato</dt>
			<dd>
				<p>55 (11) 3875-0101</p>
				<p><a href="mailto:pulsar@pulsarimagens.com.br">pulsar@pulsarimagens.com.br</a></p>
			</dd>
			<dd style="padding-top: 6px;">
				<p>Rua Apiac�s, 934</p>
				<p>05017-020</p>
				<p>S�o Paulo - SP - Brasil</p>
			</dd>
		</dl>
	</div>
	<div class="clear"></div>
</div>

<div class="footer size960">
	<p>� Pulsar Imagens 2012 - Todos os direitos reservados.</p>
	<span class="br"></span>
	<div class="clear"></div>
</div>
<?php 
$stopRenderTime = microtime(true);
$diff = $stopRenderTime - $startRenderTime;
echo "<!-- Render time: $diff</br>-->";
?>