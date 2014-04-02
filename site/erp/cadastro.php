<?php require_once('Connections/pulsar.php'); ?>
<?php include("tool_auth.php"); ?>
<?php include("tool_cadastro.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Pulsar Admin - Clientes</title>
<meta charset="iso-8859-1" />
<?php include('includes_header.php'); ?>
</head>
<body>

	<?php include('page_top.php'); ?>

	<?php include('sidebar.php'); ?>

	<div id="content">
		<div id="content-header">
			<h1>Clientes</h1>
		</div>
		<div id="breadcrumb">
			<a href="index.php" title="Go to Home" class="tip-bottom"><i class="icon-home"></i>Dashboard</a> 
			<a href="#" class="current">Cadastro</a>
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
				<div class="span9">
					<a class="btn btn-success" href="cadastro_cadastro.php?newUser=true">Novo</a> 
<!-- 					<a class="btn btn-danger" href="#">Excluir todos</a> -->
				</div>
				<div class="span3">
					<form>
						<input class="span12" type="text" placeholder="Busca" name="buscar"/>
					</form>
				</div>
			</div>
			<div class="row-fluid">
				<div class="span12">
<?php if($totalUsers>0) {?>
					<table class="table table-bordered table-striped with-check">
						<thead>
							<tr>
								<th><input type="checkbox" /></th>
								<th>Login</th>
								<th>Nome</th>
								<th>Empresa</th>
								<th>E-mail</th>
								<th>Telefone</th>
								<th>Status</th>
								<th>Ações</th>
							</tr>
						</thead>
						<tbody>
							<?php while ($rowUsers = mysql_fetch_assoc($rsUsers)) { ?>
							<tr>
								<td><input type="checkbox" /></td>
								<td><?php echo $rowUsers['login']?></td>
								<td><?php echo $rowUsers['nome']?></td>
 								<td><?php echo $rowUsers['empresa']?></td>
 								<td><?php echo $rowUsers['email']?></td>
 								<td><?php echo $rowUsers['telefone']?></td>
 								<td><?php echo (false?"Excluído":"Válido")?></td>
								<td>
									<a class="btn btn-primary" href="cadastro_cadastro.php?idUser=<?php echo $rowUsers['id_cadastro']?>">Editar</a>&nbsp;
									<a class="btn btn-danger confirmOnclick" href="cadastro_cadastro.php?delUser=<?php echo $rowUsers['id_cadastro']?>">Excluir</a>
								</td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
<?php } ?>					
				</div>
			</div>


			<?php include('page_bottom.php'); ?>
		</div>
	</div>
	<!-- END #content -->

	<?php include('includes_footer.php'); ?>

</body>
</html>
