<?php require_once('Connections/pulsar.php'); ?>
<?php include("tool_auth.php"); ?>
<?php include("tool_ftp.php"); ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Pulsar Admin - Relatórios</title>
    <meta charset="iso-8859-1" />
    <?php include('includes_header.php'); ?>
  </head>
  <body>

    <?php include('page_top.php'); ?>

    <?php include('sidebar.php'); ?>

    <div id="content">
      <div id="content-header">
        <h1>Relatórios</h1>
      </div>
      <div id="breadcrumb">
        <a href="index.php" title="Go to Home" class="tip-bottom"><i class="icon-home"></i>Dashboard</a>
        <a href="#">Site</a>
        <a href="#" class="current">FTP</a>
      </div>
      <div class="container-fluid">

        <div class="row-fluid">
<?php if(isset($msg) && $msg != "") { ?>
            <div class="alert alert-success">
              <?php echo $msg?>
              <a href="#" data-dismiss="alert" class="close">×</a>
            </div>
<?php } ?>   
<?php if(isset($error) && $error != "") { ?>
            <div class="alert alert-error">
              <?php echo $error?>
              <a href="#" data-dismiss="alert" class="close">×</a>
            </div>
<?php } ?> 	        
          <form class="form-inline">
            <div class="span7">
              <select class="span10 do_submit" name="id_login" data-placeholder="usuario">
	          	<option value="">-- Escolha o Usuário --</option>
<?php while ($row_diretorios = mysql_fetch_assoc($diretorios)) { ?>
			    <option value="<?php echo $row_diretorios['id_login']?>"<?php if (isset($idLogin) && !(strcmp($row_diretorios['id_login'], $idLogin))) {echo "selected=\"selected\"";} ?>><?php echo $row_diretorios['nome']?>/<?php echo $row_diretorios['empresa']?></option>
<?php }?>
  			  </select>	
            </div>
            <div class="span1">
              <button type="submit" class="btn btn-success do_button">Consultar</button>
            </div>
            <div class="span2">
              <a class="btn btn-primary" href="ftp_criar.php">Criar Novo</a>
            </div>            
          </form>
        </div>
        <br />
        
	
        <div class="row-fluid">
          <div class="span12">
          
            <?php if ($idLogin!=-1) { ?>
	          <form class="form-inline" method="post">
	
				  <input type="button" class="btn btn-success" id="btnFtpCopy" name="Submit6" value="Copiar arquivo de Alta">
				  <input type="button" class="btn btn-primary" id="btnFtpVideo" name="Submit7" value="Copiar Videos">
				  <input <?php if ($totalRows_arquivos > 0) { // Show if recordset not empty ?>disabled <?php } ?>type="submit"  class="btn btn-danger" name="Submit4" value="remover pasta">
			      <input name="diretorioxxx" type="hidden" id="diretorioxxx" value="<?php echo $idLogin; ?>">
			      <input type="button" class="btn btn-warning" id="btnFtpEmail" name="Submit5" value="enviar email">
			      <a href="ftp.php?id_login=<?php echo $idLogin; ?>&delall=true" class="btn btn-danger" id="btnFtpDelall">Apagar todas</a>
			 </form>
		
          </div>
	    </div>

        <div class="row-fluid">
    	<div class="span12">
        </div>
        </div>

        
        
        <div id="ftpCopy" class="row-fluid" style="display:none">
    	<div class="span12">

<?php 
$MMColParam_dados_foto = "12SDM000";
$sufix = "F";
$rowUso = $rowLastImageUso;
?>    	
<form id="form1" name="form1" method="post">
<?php if ($totalLastImageUso > 0) { ?>
    <tr>
		<td></td>
	  	<td><input name="" type="button" value="Copiar dados do ultimo arquivo salvo" class="button" onclick="copiar<?php echo $sufix?>();"/></td>
    </tr>
<?php } ?>
   <table width="500" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td><span class="style14">Codigos:</span></td>
      <td><input name="tombo" type="text" id="tombo" size="60" /></td>
    </tr>
    <tr>
      <td><span class="style14">Validade: </span></td>
      <td><span class="style14">
        <input name="validade" type="text" id="validade" size="7" value="<?php echo (isset($_POST['validade'])?$_POST['validade']:"");?>"/> dias</span></td>
    </tr>
    <tr>
      <td><span class="style14">Observa&ccedil;&otilde;es: </span></td>
      <td><input name="observacoes" type="text" id="observacoes" size="60" value="<?php echo (isset($_POST['observacoes'])?$_POST['observacoes']:"");?>"/></td>
    </tr>
    <tr>
                        <label>* Título do livro/projeto:</label>
	                    <input id="titulo<?php echo $sufix?>" name="titulo" type="text" class="titulo<?php if($titulo_error) echo " error"?>" value="<?php echo $titulo?>" size="" />
	                    <input id="titulo_ant<?php echo $sufix?>" name="titulo_ant" type="hidden" value="<?php echo $rowLastImage['projeto']; ?>"/>

<?php include("part_form_uso.php");?>
    <tr>
      <td>&nbsp;</td>
      <td><input name="diretorio" type="hidden" id="diretorio" value="<?php echo $idLogin?>" /></td>
    </tr>
    <tr>
      <td colspan="2"><div align="center" class="style14">
        <input type="submit" name="Submit" value="Copiar" />
        <input type="hidden" name="action" value="copiarFoto" /> 
      </div></td>
    </tr>
  </table>
</form>    	
    	
    	
    	
    	
        </div>
        </div>

        <div id="ftpVideo" class="row-fluid" style="display:none">
    	<div class="span12">

<?php 
$MMColParam_dados_foto = "SDM120000";
$sufix = "V";
$rowUso = $rowLastVideoUso;
?>    	
<form id="form1" name="form1" method="post">
<?php if ($totalLastVideoUso > 0) { ?>
    <tr>
		<td></td>
	  	<td><input name="" type="button" value="Copiar dados do ultimo arquivo salvo" class="button" onclick="copiar<?php echo $sufix?>();"/></td>
    </tr>
<?php } ?>
  <table width="500" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td><span class="style14">Codigos:</span></td>
      <td><input name="tombo" type="text" id="tombo" size="60" /></td>
    </tr>
    <tr>
      <td><span class="style14">Validade: </span></td>
      <td><span class="style14">
        <input name="validade" type="text" id="validade" size="7" value="<?php echo (isset($_POST['validade'])?$_POST['validade']:"");?>"/> dias</span></td>
    </tr>
    <tr>
      <td><span class="style14">Observa&ccedil;&otilde;es: </span></td>
      <td><input name="observacoes" type="text" id="observacoes" size="60" value="<?php echo (isset($_POST['observacoes'])?$_POST['observacoes']:"");?>"/></td>
    </tr>
    <tr>
    
                        <label>* Título do livro/projeto:</label>
	                    <input id="titulo<?php echo $sufix?>" name="titulo" type="text" class="titulo<?php if($titulo_error) echo " error"?>" value="<?php echo $titulo?>" size="" />
	                    <input id="titulo_ant<?php echo $sufix?>" name="titulo_ant" type="hidden" value="<?php echo $row_formulario['projeto']; ?>"/>

<?php include("part_form_uso.php");?>
    <tr>
      <td>&nbsp;</td>
      <td><input name="diretorio" type="hidden" id="diretorio" value="<?php echo $idLogin?>" /></td>
    </tr>
    <tr>
      <td colspan="2"><div align="center" class="style14">
        <input type="submit" name="Submit" value="Copiar" />
        <input type="hidden" name="action" value="copiarVideo" /> 
      </div></td>
    </tr>
  </table>
</form>    	
    	
    	
    	
        </div>
        </div>
        
        <div id="ftpEmail" class="row-fluid" style="display:none">
    	<div class="span12">

    	
    	<form name="form1" method="post">
		<table width="700" border="1" cellpadding="3" cellspacing="0" bordercolor="#666666">
		  <tr>
		    <td class="style4">Enviado por :</td>
		    <td><select name="responder" id="responder">
		      <?php
		do {  
		?>
		      <option value="<?php echo $row_emails['email']?>"<?php if (!(strcmp($row_emails['email'], $_SESSION['MM_Username_erp']))) {echo "selected=\"selected\"";} ?>><?php echo $row_emails['login']?> - <?php echo $row_emails['email']?></option>
		      <?php
		} while ($row_emails = mysql_fetch_assoc($emails));
		  $rows = mysql_num_rows($emails);
		  if($rows > 0) {
		      mysql_data_seek($emails, 0);
			  $row_emails = mysql_fetch_assoc($emails);
		  }
		?>
		    </select>
		      <input name="to" type="hidden" id="to" value="<?php echo $row_to['email']?>"></td>
		  </tr>
		  <tr>
		    <td width="187" class="style4">Assunto da mensagem:</td>
		    <td width="495"><input name="subject" type="text" id="subject" size="30">    </td>
		  </tr>
		  <tr>
		    <td class="style4">Mensagem:</td>
		    <td>
		    <textarea name="FCKeditor1" id="FCKeditor1">
		    	<br><br>Suas imagens já estão disponíveis em nosso FTP.<br><br>Para acessa-las basta seguir estes passos:<br><br>1. Clique no link <a href="http://www.pulsarimagens.com.br/login_ftp">http://www.pulsarimagens.com.br/login_ftp</a>  ou copie-o e cole no campo de endereço de seu navegador de internet. <br>2. Use seu login e senha cadastrados em nosso site para ter acesso à sua área de FTP. <br>3. Baixe e salve em seu computador as imagens solicitadas.<br><br> Todas as informações de identificação estão no site ou no File Info do Photoshop.<br>Seus arquivos estarão disponíveis por um prazo de 15 dias a partir da data deste e-mail.<br><br>Caso encontre alguma dificuldade, por favor entre em contato.<br><br><br>Obrigado.<br><br>Equipe Pulsar Imagens.<br>
			</textarea>
			<br>
		      <font face="Verdana, Arial, Helvetica, sans-serif" color="#48493F" size="1">Pulsar Imagens<br>
		        </font> <font face="Verdana, Arial, Helvetica, sans-serif" color="#999999" size="1">www.pulsarimagens.com.br<br>
		      pulsar@pulsarimagens.com.br</font></td></tr>
		  <tr>
		    <td colspan="2"><div align="center">      
		      <p><br>
		          <input type="submit" name="Submit" value="Enviar">    
        		<input type="hidden" name="action" value="enviarEmail" /> 
		          <br>
		          <br>
		      </p>
		    </div></td>
		  </tr>
		</table>
		</form>
		    	
    	
    	
    	   <?php if ($totalRows_arquivos > 0) { // Show if recordset not empty ?>
        
    	
        </div>
        </div>
        
	
        <div class="row-fluid">
            <div class="span12">


    <span>Arquivos:</span><br>
    <br>
    <table class="table table-bordered table-striped data-table">
    <thead>
      <tr>
        <th><strong>Arquivo</strong></th>
        <th><div align="right">Tamanho</div></th>
        <th><div align="center">Data Upload </div></th>
        <th><div align="center">Validade</div></th>
        <th>Ação</th>
      </tr>
      </thead>
      <tbody>
      <?php do { ?>
      <tr>
        <td><?php echo $row_arquivos['nome']; ?></td>
        <td><div align="right">
<?php 
        $tamanho = DoFormatNumber($row_arquivos['tamanho'], 0, ',', '.');
        if($tamanho == 0) {
			if($row_arquivos['flag'] == "VS")
				$tamanho = "SD";
			else if($row_arquivos['flag'] == "VH")
				$tamanho = "HD";
		}
        echo $tamanho; 
?>
        </div></td>
        <td><div align="center"><?php echo makeDateTime($row_arquivos['data_cria'], 'd/m/y'); ?>-<?php echo makeDateTime($row_arquivos['data_cria'], 'H:i:s'); ?></div></td>
        <td><div align="center"><?php echo $row_arquivos['validade']; ?></div></td>
		<td>
			<form name="delete" method="post" >
				<input class="btn btn-warning confirmOnclick" type="submit" name="deleta" value="Deleta">
<?php if(date("Y-m-d",strtotime($row_arquivos['data_cria'])) == date("Y-m-d", strtotime('now'))) { ?>				
				<input class="btn btn-danger confirmOnclick" type="submit" name="cancela" value="Cancela">
<?php } ?>				
		        <input name="id_login" type="hidden" id="id_login" value="<?php echo $_GET['id_login']; ?>">
		        <input name="arquivo" type="hidden" id="arquivo" value="<?php echo $row_arquivos['nome']; ?>">
		        <input name="MM_Del" type="hidden" id="MM_Del" value="delete">
	        </form>
        </td>
      </tr>
        <?php } while ($row_arquivos = mysql_fetch_assoc($arquivos)); ?>
        </tbody>
	</table>
    <?php } else { ?>
	<span class="style7">Diretório vazio!!! </span>
	<?php }; ?>
	</div>
	</div>
	<div class="row-fluid">
	<form name="upload" action="adm_ftp2.php" method="post" enctype="multipart/form-data" >
    <div class="span12">
<!-- 	<table> -->
<!--         <tr> -->
<!--           <td> -->
<!--           	<table class="table table-bordered table-striped"> -->
<!--             <tr> -->
<!--               <td colspan="2">Arquivo1: <input name="arquivo1" type="file" id="arquivo1" size="60"></td> -->
<!--             </tr> -->
<!--             <tr> -->
<!--               <td>Validade: <input name="validade1" type="text" id="validade1" value="15" size="5"><span> dias </span></td> -->
<!--               <td valign="top">Observa&ccedil;&otilde;es: <input name="observacoes1" type="text" id="observacoes1" value="" size="60"></td> -->
<!--             </tr> -->
<!--           	</table> -->
<!--           </td> -->
<!--         </tr> -->
<!--         <tr> -->
<!--           <td> -->
<!--           	<table class="table table-bordered table-striped"> -->
<!--             <tr> -->
<!--               <td colspan="2">Arquivo2: <input name="arquivo2" type="file" id="arquivo2" size="60"></td> -->
<!--             </tr> -->
<!--             <tr> -->
<!--               <td>Validade: <input name="validade2" type="text" id="validade2" value="15" size="5"><span> dias </span></td> -->
<!--               <td valign="top">Observa&ccedil;&otilde;es: <input name="observacoes2" type="text" id="observacoes2" value="" size="60"></td> -->
<!--             </tr> -->
<!--           	</table> -->
<!--           </td> -->
<!--         </tr> -->
<!--         <tr> -->
<!--           <td> -->
<!--           	<table class="table table-bordered table-striped"> -->
<!--             <tr> -->
<!--               <td colspan="2">Arquivo3: <input name="arquivo3" type="file" id="arquivo3" size="60"></td> -->
<!--             </tr> -->
<!--             <tr> -->
<!--               <td>Validade: <input name="validade3" type="text" id="validade3" value="15" size="5"><span> dias </span></td> -->
<!--               <td valign="top">Observa&ccedil;&otilde;es: <input name="observacoes3" type="text" id="observacoes3" value="" size="60"></td> -->
<!--             </tr> -->
<!--           	</table> -->
<!--           </td> -->
<!--         </tr> -->
<!--         <tr> -->
<!--           <td> -->
<!--           	<table class="table table-bordered table-striped"> -->
<!--             <tr> -->
<!--               <td colspan="2">Arquivo4: <input name="arquivo4" type="file" id="arquivo4" size="60"></td> -->
<!--             </tr> -->
<!--             <tr> -->
<!--               <td>Validade: <input name="validade4" type="text" id="validade4" value="15" size="5"><span> dias </span></td> -->
<!--               <td valign="top">Observa&ccedil;&otilde;es: <input name="observacoes4" type="text" id="observacoes4" value="" size="60"></td> -->
<!--             </tr> -->
<!--           	</table> -->
<!--           </td> -->
<!--         </tr> -->
<!--         <tr> -->
<!--           <td> -->
<!--           	<table class="table table-bordered table-striped"> -->
<!--             <tr> -->
<!--               <td colspan="2">Arquivo5: <input name="arquivo5" type="file" id="arquivo5" size="60"></td> -->
<!--             </tr> -->
<!--             <tr> -->
<!--               <td>Validade: <input name="validade5" type="text" id="validade5" value="15" size="5"><span> dias </span></td> -->
<!--               <td valign="top">Observa&ccedil;&otilde;es: <input name="observacoes5" type="text" id="observacoes5" value="" size="60"></td> -->
<!--             </tr> -->
<!--           	</table> -->
<!--           </td> -->
<!--         </tr> -->
<!--         <tr> -->
<!--           <td><div align="center"> -->
            <input name="id_login" type="hidden" id="id_login" value="<?php echo $idLogin; ?>">
<!--             <input type="submit" class="btn btn-success" name="enviar" value="Upload!"> -->
<!--           </div></td> -->
<!--         </tr> -->
<!--       </table> -->
	  <br>
<?php }; ?>
	  
</div>
</form>
</div>



        <?php include('page_bottom.php'); ?>
      </div>
    </div><!-- END #content -->

    <?php include('includes_footer.php'); ?>

  </body>
</html>
