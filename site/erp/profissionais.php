<?php require_once('Connections/pulsar.php'); ?>
<?php include("tool_auth.php"); ?>
<?php include("tool_profissionais.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Pulsar Admin - Profissionais</title>
<meta charset="iso-8859-1" />
<?php include('includes_header.php'); ?>
</head>
<body>

	<?php include('page_top.php'); ?>

	<?php include('sidebar.php'); ?>

	<div id="content">
		<div id="content-header">
			<h1>Profissionais</h1>
		</div>
		<div id="breadcrumb">
			<a href="index.php" title="Go to Home" class="tip-bottom"><i class="icon-home"></i>Dashboard</a> 
			<a href="#" class="current">Profissionais</a>
		</div>
		<div class="container-fluid">
			<div class="row-fluid">
<?php if(isset($msg) && $msg != "") { ?>
            <div class="alert alert-success">
              <?php echo $msg?>
              <a href="#" data-dismiss="alert" class="close">×</a>
            </div>
<?php } ?>   			
				<div class="span9">
					<a class="btn btn-success" href="profissionais_cadastro.php?newUser=true">Novo</a> 
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

					<table class="table table-bordered table-striped with-check">
						<thead>
							<tr>
								<th><input type="checkbox" /></th>
								<th>Sigla</th>
								<th>Nome</th>
								<th>E-mail</th>
								<th>Celular</th>
								<th>Status</th>
								<th>Açoes</th>
							</tr>
						</thead>
						<tbody>
							<?php while ($rowUsers = mysql_fetch_assoc($rsUsers)) { ?>
							<tr>
								<td><input type="checkbox" /></td>
								<td><a href="profissionais_cadastro.php?idUser=<?php echo $rowUsers['ID']?>"><?php echo $rowUsers['SIGLA']?></a></td>
								<td><a href="profissionais_cadastro.php?idUser=<?php echo $rowUsers['ID']?>"><?php echo $rowUsers['NOME']?></a></td>
								<td><?php echo $rowUsers['EMAIL']?></td>
								<td><?php echo $rowUsers['CELULAR']?></td>
								<td><?php echo ($rowUsers['STATUS']=='D'?"Excluído":"Válido")?></td>
								<td>
									<a class="btn btn-primary" href="profissionais_cadastro.php?idUser=<?php echo $rowUsers['ID']?>">Editar</a>&nbsp;
									<a class="btn btn-danger confirmOnclick" href="profissionais_cadastro.php?delUser=<?php echo $rowUsers['ID']?>">Excluir</a>
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
