<div id="sidebar">
  <a href="#" class="visible-phone"><i class="icon icon-home"></i> Dashboard</a>
  <ul>
<!--     <li class="active"><a href="main.php"><i class="icon icon-home"></i> <span>Dashboard</span></a></li> -->
<!--     <li><a href="#paginas.php"><i class="icon icon-book"></i> <span>P�ginas</span></a></li> -->
<!--     <li class="submenu"> -->
<!--       <a href="#"><i class="icon icon-picture"></i> <span>Indexa��o</span> <span class="label">4</span></a> -->
<!--       <ul> -->
<!--         <li><a href="#indexacao_imagens.php">Imagens</a></li> -->
<!--         <li><a href="#indexacao_videos.php">V�deos</a></li> -->
<!--         <li><a href="#indexacao_temas.php">Temas</a></li> -->
<!--         <li><a href="#indexacao_palavra_chave.php">Palavras-chave</a></li> -->
<!--       </ul> -->
<!--     </li> -->
<!--     <li class="submenu"> -->
<!--       <a href="#"><i class="icon icon-picture"></i> <span>Minera��o de Dados</span> <span class="label">4</span></a> -->
<!--       <ul> -->
<!-- 	    <li><a href="sinonimos.php"><i class="icon icon-briefcase"></i> <span>Comparativo Sin�nimos</span></a></li> -->
<!-- 	    <li><a href="pauta.php"><i class="icon icon-briefcase"></i> <span>Pauta das Pesquisas</span></a></li> -->
<!-- 	    <li><a href="pauta_venda.php"><i class="icon icon-briefcase"></i> <span>Pauta das Vendas</span></a></li> -->
<!-- 	    <li><a href="temas_descritores.php"><i class="icon icon-briefcase"></i> <span>Rela��o Temas-Descritores</span></a></li> -->
<!--       </ul> -->
<!--     </li> -->
<!--     <li><a href="#profissionais.php"><i class="icon icon-briefcase"></i> <span>Profissionais</span></a></li> -->
<!--     <li><a href="#clientes.php"><i class="icon icon-list"></i> <span>Clientes</span></a></li> -->
<!--     <li><a href="usuarios.php"><i class="icon icon-user"></i> <span>Usu�rios</span></a></li> -->
<!--     <li class="submenu"> -->
<!--       <a href="#"><i class="icon icon-signal"></i> <span>Administrativo</span> <span class="label">5</span></a> -->
<!--       <ul> -->
<!--         <li><a href="administrativo_comissoes.php">Relat�rio Comiss�es</a></li> -->
<!--         <li><a href="administrativo_contratos.php">Contratos</a></li> -->
<!--         <li><a href="administrativo_licencas.php">Licen�as</a></li> -->
<!--         <li><a href="administrativo_precos.php">Pre�os</a></li> -->
<!--         <li><a href="administrativo_indios.php">Indios</a></li> -->
<!--       </ul> -->
<!--     </li> -->

  
<?php 
$menu->db=$database_sig;
$menu->dbConn=$sig;

$menu->createMenu((isset($row_top_login['role'])?$row_top_login['role']:0));
?>
  
  
  </ul>
</div>

