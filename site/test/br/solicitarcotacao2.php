<?php require_once('Connections/pulsar.php'); ?>
<?php
include("../tool_auth.php");
include("../tool_cotacao.php");


mysql_select_db($database_pulsar, $pulsar);
$query_fotos_pasta = sprintf("SELECT   cotacao.id_cadastro,  cotacao.id_cotacao,  cotacao.tombo,  fotografos.Nome_Fotografo,  fotografos.Iniciais_Fotografo,  Fotos.data_foto,  Fotos.cidade,  Estados.Estado,  Estados.Sigla,  Fotos.assunto_principal, paises.nome as pais FROM Fotos INNER JOIN fotografos ON (Fotos.id_autor=fotografos.id_fotografo) INNER JOIN cotacao ON (cotacao.tombo=Fotos.tombo) LEFT OUTER JOIN Estados ON (Fotos.id_estado=Estados.id_estado) LEFT JOIN paises ON (paises.id_pais=Fotos.id_pais) WHERE cotacao.id_cadastro = %s ORDER BY tombo", $row_top_login['id_cadastro']);
$fotos_pasta = mysql_query($query_fotos_pasta, $pulsar) or die(mysql_error());
$row_fotos_pasta = mysql_fetch_assoc($fotos_pasta);
$totalRows_fotos_pasta = mysql_num_rows($fotos_pasta);

if ($totalRows_fotos_pasta == 0 && !$submit)
  header("Location: primeirapagina.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
    <title>Pulsar Imagens</title>
    <link href="style.css" rel="stylesheet" type="text/css" />
    <?php include("scripts.php"); ?>
    <script language="JavaScript" type="text/JavaScript">
      function MM_callJS(jsStr) { //v2.0
        return eval(jsStr)
      }

      function validate(f) {
        if (document.form1.length<2) {
          return false;
        }
        var chkbox = f.elements['chkbox[]'];
        var noneChecked = true;
        if (typeof chkbox.length == 'undefined') {
          // there's only one checkbox on the form
          // normalize it to an array/collection
          chkbox = new Array(chkbox);
        }
        for (var i = 0; i < chkbox.length; i++) {
          if (chkbox[i].checked) {
            noneChecked = false;
            break;
          }
        }
        if (noneChecked) {
          alert('Você deve selecionar pelo menos uma foto!');
          return false;
        } else {     
	
          var agree=confirm("Confirma exclusão?");
          if (agree) {
            document.form1.submit();return true;
          }
          else
            return false ;
        }
      }
    </script>
  </head>
  <body>

    <?php include("part_topbar.php") ?>

    <div class="main size960 cotacao-new">
      <div class="primeirapagina">
        <div class="minhasimagens">
          <h2 class="titulo-pagina">Solicitar cotação</h2>

          <div class="grid-cotacao">
            <div class="wrapper-select-filtros">
              <div class="form-item">
                <label>Filtro 1</label>
                <select>
                  <option>Select 1</option>
                  <option>Select 1</option>
                  <option>Select 1</option>
                </select>
              </div>
              <div class="form-item">
                <label>Filtro 1</label>
                <select>
                  <option>Select 1</option>
                  <option>Select 1</option>
                  <option>Select 1</option>
                </select>
              </div>
              <div class="form-item">
                <label>Filtro 1</label>
                <select>
                  <option>Select 1</option>
                  <option>Select 1</option>
                  <option>Select 1</option>
                </select>
              </div>
            </div>
            <form name="form1" method="post" action="solicitarcotacao.php">


              <?php if ($has_error) { ?>
                <div class="error-msg">Ops! Você precisa arrumar os campos em destaque para continuar.</div>
              <?php } ?>


              <textarea name="descricao" cols="" rows="" <?php if ($descricao_error) { ?>class="error"<?php } ?>><?php echo $descricao; ?>Descreva os fins para utilização da(s) foto(s)</textarea>
              <ul>
                <?php do { ?>					
                  <li>
                    <div class="checkbox">
                      <input name="chkbox[]" type="checkbox" value="<?php echo $row_fotos_pasta['tombo']; ?>" checked/>
                    </div>
                    <p class="img">
                      <img src="<?php echo "http://www.pulsarimagens.com.br/"; //$homeurl;   ?>bancoImagens/<?php echo $row_fotos_pasta['tombo']; ?>p.jpg" alt="<?php echo $row_fotos_pasta['assunto_principal']; ?>" style="max-width:110px; max-height:75px;" />
                      <span><?php echo ""; //$row_fotos_pasta['assunto_principal'];   ?></span>

                    </p>

                  </li>
                <?php } while ($row_fotos_pasta = mysql_fetch_assoc($fotos_pasta)); ?>					
                <div class="clear"></div>
              </ul>
              <div class="clear"></div>
              <div class="bts">
                <input name="action" type="submit" value="Enviar e-mail" class="button" />
                <?php /* ?><div class="bt-cancelar"><a href="primeirapagina.php"></a></div>
                  <div class="bt-deletar"><a href="#" onClick="MM_callJS('document.form1.opcao.value=\'delete\';validate(document.form1);')"></a></div><?php */ ?>
                <input type="hidden" name="opcao" value="" />
                <div class="clear"></div>
              </div>

            </form>
          </div>

          <?php include("part_minhasimagens_botoes_pastas.php") ?>

          <div class="clear"></div>

        </div>
        <?php include("part_minhasimagens_home.php") ?>
      </div>
    </div>

    <?php include("part_footer.php") ?>

  </body>
</html>
