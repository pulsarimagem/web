<?php

if(isset($menu_busca_adv)) {
	include_once("inc_menu_p2_busca_adv.php");
}/* else {
	include_once("inc_menu_p2.php");
} 
*/
?>

<div class="socialbar size960">
	<div class="social">
		<a href="http://www.facebook.com/pulsar.imagens" class="facebook" target="_blank"></a>
		<a href="http://www.flickr.com/photos/pulsarimagens/" class="flickr" target="_blank"></a>
	</div>
	<div class="newsletter">
		<form name="form_newsletter" method="get" action="../tool_newsletter.php">
			<label>Sign up our newsletter:</label>
			<div class="form">
				<input id="newsletter_email" name="email" type="text" class="text"/>
				<input id="newsletter_email_clear" type="text" class="text" value="email"/> 
				<input name="lingua" type="hidden" value="<?php echo $lingua?>"/> 
				<!--<select name="tipo" class="select">
				<option>Editorial</option>
				<option>Publicitário</option>
				</select>-->
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
			<dt>Menu</dt>
			<dd><a href="index.php">Home</a></dd>
            <dd><a href="quemsomos.php">About us</a></dd>
<!--		<dd><a href="fotografos.php">Collaborators</a></dd>-->
			<dd><a href="primeirapagina.php">My Area</a></dd>
<!--            <dd><a href="solicitarcotacao.php">Shopping Cart</a></dd>-->
			<dd><a href="cadastro.php">Register</a></dd>
			<dd><a href="buscaavancada.php">Advanced Search</a></dd>
		</dl>
	</div>
	<div class="col">
		<dl>
			<dt>Auxiliary menu</dt>
            <dd><a href="comofunciona.php">How does it work?</a></dd>
			<dd><a href="faq.php">F.A.Q.</a></dd>
			<dd><a href="contato.php">Contact</a></dd>
		</dl>
	</div>
	<div class="col">
		<dl>
			<dt>Contact</dt>
			<dd>
				<p>+44 20 3290 9066</p>
				<p><a href="mailto:contact@pulsarimages.com">contact@pulsarimages.com</a></p>
			</dd>
			<dd style="padding-top: 6px;">
				<p>2 Queen Caroline St</p>
				<p>W6 9DX</p>
				<p>London - UK</p>
			</dd>
		</dl>
	</div>
	<div class="clear"></div>
</div>

<div class="footer size960">
	<p>® Pulsar Images 2013 - All rights reserved.</p>
	<span class="<?php echo $lingua?>"></span>
	<div class="clear"></div>
</div>
<?php 
$stopRenderTime = microtime(true);
$diff = $stopRenderTime - $startRenderTime;
echo "<!-- Render time: $diff</br>-->";
?>