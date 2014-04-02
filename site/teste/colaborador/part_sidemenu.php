<?php 
$currentURL = $_SERVER["PHP_SELF"];
$partsURL = Explode('/', $currentURL);
$this_page = $partsURL[count($partsURL) - 1];
?>
    	<div class="secao_admin">
        	<div class="title">
            	<p>Seções do Admin.:</p>
            </div>
            <ol>
            	<li><a href="menu.php" <?php if($this_page == "menu.php") echo "class=\"select\"><span><img src=\"images/secao_admin-span.jpg\" /></span";?>> Menu Principal</a></li>
            	<li><a href="adm_index.php" <?php if($this_page == "adm_index.php") echo "class=\"select\"><span><img src=\"images/secao_admin-span.jpg\" /></span";?>>1. Indexação</a></li>
            	<li><a href="adm_video_index_inc.php" <?php if($this_page == "adm_video_index_inc.php") echo "class=\"select\"><span><img src=\"images/secao_admin-span.jpg\" /></span";?>>2. Indexação de Videos</a></li>
            	<li><a href="consulta_comissoes.php" <?php if($this_page == "consulta_comissoes.php") echo "class=\"select\"><span><img src=\"images/secao_admin-span.jpg\" /></span";?>>3. Relatório de Comissões</a></li>
            	<li><a href="adm_import_xls.php" <?php if($this_page == "adm_import_xls.php") echo "class=\"select\"><span><img src=\"images/secao_admin-span.jpg\" /></span";?>>4. Importar Excel</a></li>
            	<li><a href="alterar_senha.php" <?php if($this_page == "alterar_senha.php") echo "class=\"select\"><span><img src=\"images/secao_admin-span.jpg\" /></span";?>>5. Alterar Senha</a></li>
            	<li><a href="../colaborador/">6. Logout</a></li>
            	</ol>
        </div>
