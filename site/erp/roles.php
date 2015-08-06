<?php require_once('Connections/pulsar.php'); ?>
<?php include("tool_auth.php"); ?>
<?php include("tool_roles.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Pulsar Admin - Regras</title>
<meta charset="iso-8859-1" />
<?php include('includes_header.php'); ?>
</head>
<body>

	<?php include('page_top.php'); ?>

	<?php include('sidebar.php'); ?>

	<div id="content">
		<div id="content-header">
			<h1>Usuários</h1>
		</div>
		<div id="breadcrumb">
			<a href="index.php" title="Go to Home" class="tip-bottom"><i class="icon-home"></i>Dashboard</a> 
			<a href="#" class="current">Regras</a>
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
					<a class="btn btn-success" href="roles_cadastro.php?newUser=true">Novo</a> 
				</div>
				<div class="span3">
					<form>
						<input class="span12" type="text" placeholder="Busca" />
					</form>
				</div>
			</div>
			<div class="row-fluid">
				<div class="span12">

					<table class="table table-bordered table-striped with-check">
						<thead>
							<tr>
								<th><input type="checkbox" /></th>
								<th>Nome</th>
								<th>Status</th>
								<th>Açoes</th>
							</tr>
						</thead>
						<tbody>
							<?php while ($rowUsers = mysql_fetch_assoc($rsUsers)) { ?>
							<tr>
								<td><input type="checkbox" /></td>
								<td><a href="roles_cadastro.php?idUser=<?php echo $rowUsers['id']?>"><?php echo $rowUsers['nome']?></a></td>
								<td><?php echo ($rowUsers['status']==-1?"Excluído":"Válido")?></td>
								<td>
									<a class="btn btn-primary" href="roles_cadastro.php?idUser=<?php echo $rowUsers['id']?>">Editar</a>&nbsp;
									<a class="btn btn-danger confirmOnclick" href="roles_cadastro.php?delUser=<?php echo $rowUsers['id']?>">Excluir</a>
								</td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>


			<?php include('page_bottom.php'); ?>
		</div>
	</div>
	<!-- END #content -->

	<?php include('includes_footer.php'); ?>

</body>
</html>
