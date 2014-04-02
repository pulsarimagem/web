<div class="topbar">
  <div class="size960">
    <form name="form_login" method="post" action="login.php">
      <div class="login">
        <div class="lat">
          <div class="rat">
            
              <!--<div class="logado">Olá <?php echo $row_top_login['nome'] ?> - <a href="index.php?logout=true">Logout</a></div>-->
            
              <div class="menu-topo">
                <ul>
                  <li class="como-funciona"><a href="comofunciona.php" title="Como funciona?"><span>Como funciona?</span></a></li>
                  <li class="carrinho"><a href="carrinho.php" title="Carrinho"><span>Meu carrinho</span></a></li>
                  <?php if ($logged) { ?>
                  <li class="user-item logado">Olá <?php echo @$row_top_login['nome'] ?> - <a href="index.php?logout=true">Logout</a></li>
                  <?php } else { ?>
                  <li class="user-item login"><a href="primeirapagina.php" title="Login"><span>Login</span></a></li>
                  <li class="user-item registro"><a href="cadastro.php" title="Cadastro"><span>Registrar-se</span></a></li>
                  <?php } ?>
                  <li class="language">
                    <a class="pt-br" href="http://www.pulsarimagens.com.br">Português</a>
                    <a class="en" href="http://www.pulsarimagens.com.br/en">Inglês</a>
                  </li>
                </ul>
              </div>
              <!--					<div class="form">
                          <label>Login:</label>
                          <input name="login" type="text" class="text" />
                          <label>Senha:</label>
                          <input name="senha" type="password" class="text" />
                          <input name="action" type="submit" class="button" value="OK" />
                        </div>-->
            
            <!--					<div class="lang" id="lang">
                        <div class="flag"><a href="#" class="br"></a></div>
                        <a href="#" id="lang-bt" class="bt">&#9660;</a>
                        <div class="clear"></div>
                        <div class="open" id="lang-open" style="display: none;">
                          <a href="#" class="us" onclick="location.href='http://www.pulsarimagens.com.br/en'"></a>
             
                          <a href="#" class="es"></a>
                          
                        </div>
                      </div>-->
            <div class="clear"></div>
          </div>

        </div>

        
    
      </div>
    </form>


  </div>
  <div class="clear"></div>
</div>

<?php include("part_header.php") ?>