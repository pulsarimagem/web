<?php require_once('Connections/pulsar.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
    <title>Pulsar Imagens</title>
    <link href="style.css" rel="stylesheet" type="text/css" />
    <?php include("scripts.php"); ?>
  </head>
  <body>
  
  
  
  

    <?php include("part_topbar.php") ?>

    <div class="main size960">
      <div class="carrinho-page">
        <h2>Meu Carrinho</h2>
        <table class="carrinho-lista">
          <tbody>
            <tr>
              <td>
                <div class="imagem">
                  <img src="bancoImagens/11PZ288.jpg" />
                  <ul class="acoes-item">
                    <li class="adicionar"><a href="#">Adicionar as minhas imagens</a></li>
                    <li class="remover last"><a href="#">Remover</a></li>
                  </ul>
                </div>
                <div class="descricao">
                  <ul>
                    <li class="autor"><span class="label">Autor:</span> André Seale</li>
                    <li class="codigo"><span class="label">Código:</span> 26AS205</li>
                    <li class="uso"><span class="label">Uso:</span> Clique aqui para adicionar o uso e o preço nessa imagem</li>
                  </ul>
                </div>
              </td>
              <td class="acoes">
                <div class="calculo-preco">
                  <div class="preco">R$0,00</div>
                  <div class="calcular"><a href="#">Calcular preço</a></div>
                </div>
              </td>
            </tr>
          </tbody>
          <tfoot>
            <tr>
              <td colspan="2" class="total">Total: R$ 0,00</td>
            </tr>
          </tfoot>
        </table>
        <div class="carrinho-footer">
          <a href="#" class="finalizar-compra">Finalizar compra</a>
          <a href="#" class="continuar-comprando">Continuar comprando</a>
        </div>
      </div>
    </div>

    <?php include("part_footer.php") ?>

  </body>
</html>
