<?php
$currentURL = $_SERVER["PHP_SELF"];
$partsURL = Explode('/', $currentURL);
$this_page = $partsURL[count($partsURL) - 1];
?>

<div class="header size960">
  <a href="index.php" class="logo"></a>

  <!-- SuperBusca -->
  <div class="superBusca">
    <div class="form-search">
      <form action="listing.php" method="get" id="buscaTopo" name="busca_topo">
        <div class="input-text">
          <input type="text" class="text" name="query" placeholder="Palavra-chave ou c�digo" />
        </div>
        <div class="opcoes input-select">
          <div class="superSelect">
            <div class="label">
              <div class="default_value">Todos</div>
              <span class="arrow"></span>
            </div>
            <div class="content">
              <ul class="wrapper-inputs">
                <li><label><input name="filtro[]" type="checkbox" value="foto" title="Foto" /> Foto</label></li>
                <li class="last"><label><input name="filtro[]" type="checkbox" value="video" title="V�deo" /> V�deo</label></li>
              </ul>
            </div>
          </div>
        </div>  
        <input type="submit" value="Buscar" class="button" name="pc_action">
        <input type="hidden" value="inc_pc.php" name="tipo">
        <input type="hidden" value="true" name="home">
        <input type="hidden" value="Ir" name="pc_action">
      </form>
    </div>

    <div class="nossos-temas">
      <div class="superSelect">
        <div class="label">
          Nossos temas
          <span class="arrow"></span>
        </div>
<?php include("menu_nossos_temas.php")?>        
      </div>
    </div>

    <div class="footer-form">
      <a class="adv" href="buscaavancada.php">Busca avan�ada</a>
    </div>
  </div>
  <!-- SuperBusca -->

  <!--	<div class="menu">
      <ul>
  <?php if ($this_page == "index.php") { ?>
              <li><a href="index.php"><strong>Home</strong></a></li>
  <?php } else { ?>
              <li><a href="index.php">Home</a></li>
  <?php } ?>
  <?php if ($this_page == "comofunciona.php") { ?>
              <li><a href="comofunciona.php"><strong>Como Funciona?</strong></a></li>
  <?php } else { ?>
              <li><a href="comofunciona.php">Como Funciona?</a></li>
  <?php } ?>
  <?php if ($this_page == "fotografos.php") { ?>
              <li><a href="fotografos.php"><strong>Fot�grafos</strong></a></li>
  <?php } else { ?>
              <li><a href="fotografos.php">Fot�grafos</a></li>
  <?php } ?>
  <?php /* if($this_page == "quemsomos.php") { ?>
    <li><a href="quemsomos.php"><strong>Quem Somos</strong></a></li>
    <?php } else {?>
    <li><a href="quemsomos.php">Quem Somos</a></li>
    <?php } */ ?>
  <?php if ($this_page == "primeirapagina.php") { ?>
              <li><a href="primeirapagina.php"><strong>Minhas Imagens</strong></a></li>
  <?php } else { ?>
              <li><a href="primeirapagina.php">Minhas Imagens</a></li>
  <?php } ?>
  <?php if ($this_page == "solicitarcotacao.php") { ?>
              <li><a href="solicitarcotacao.php"><strong>Cota��o</strong></a></li>
  <?php } else { ?>
              <li><a href="solicitarcotacao.php">Cota��o</a></li>
  <?php } ?>
  <?php if ($this_page == "cadastro.php" || $this_page == "cadastro_pj.php") { ?>
              <li><a href="cadastro_pj.php"><strong>Cadastro</strong></a></li>
  <?php } else { ?>
              <li><a href="cadastro_pj.php">Cadastro</a></li>
  <?php } ?>
  <?php if ($this_page == "buscaavancada.php") { ?>
              <li><a href="buscaavancada.php"><strong>Busca avan�ada</strong></a></li>
  <?php } else { ?>
              <li><a href="buscaavancada.php">Busca avan�ada</a></li>
  <?php } ?>
      </ul>
    </div>-->
  <div class="clear"></div>
</div>