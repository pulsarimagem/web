<div class="topbar">
	<div class="size960">
		<form name="form_login" method="post" action="login.php">
			<div class="login"><div class="lat"><div class="rat">
<?php if($logged) { ?>
		        	<div class="logado">Olá <?php echo $row_top_login['nome']?> - <a href="index.php?logout=true">Logout</a></div>
<?php } else { ?>
					<div class="form">
						<label>Login:</label>
						<input name="login" type="text" class="text" />
						<label>Senha:</label>
						<input name="senha" type="password" class="text" />
						<input name="action" type="submit" class="button" value="OK" />
					</div>
<?php } ?>
					<div class="lang" id="lang">
						<div class="flag"><a href="#" class="br"></a></div>
						<a href="#" id="lang-bt" class="bt">&#9660;</a>
						<div class="clear"></div>
						<div class="open" id="lang-open" style="display: none;">
							<a href="#" class="us" onclick="location.href='http://www.pulsarimagens.com.br/en'"></a>
<!-- 
							<a href="#" class="es"></a>
-->							
						</div>
					</div>
					<div class="clear"></div>
			</div></div></div>
		</form>
	</div>
	<div class="clear"></div>
</div>

<?php include("part_header.php")?>