<?php require_once('Connections/pulsar.php'); ?>
<?php include("tool_auth.php"); ?>
<?php include("tool_clientes.php"); ?>
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
			<a href="#" class="current">Clientes</a>
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
					<a class="btn btn-success" href="clientes_cadastro.php?newUser=true">Novo</a> 
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
								<th>Razão</th>
								<th>Fantasia</th>
<!-- 								<th>Função</th> -->
								<!--                   <th>E-mail</th> -->
								<th>Status</th>
								<th>Açoes</th>
							</tr>
						</thead>
						<tbody>
							<?php while ($rowUsers = mysql_fetch_assoc($rsUsers)) { ?>
							<tr>
								<td><input type="checkbox" /></td>
								<td><a href="clientes_cadastro.php?idUser=<?php echo $rowUsers['ID']?>"><?php echo $rowUsers['RAZAO']?></a></td>
								<td><?php echo $rowUsers['FANTASIA']?></td>
<!-- 								<td><?php echo $rowUsers['role']?></td> -->
								<!--                     <td>zoca@zoca.com.br</td> -->
								<td><?php echo ($rowUsers['STATUS']=='A'?"Válido":"Excluído")?></td>
								<td>
									<a class="btn btn-primary" href="clientes_cadastro.php?idUser=<?php echo $rowUsers['ID']?>">Editar</a>&nbsp;
<?php if($rowUsers['STATUS']=='A') { ?>
									<a class="btn btn-danger confirmOnclick" href="clientes_cadastro.php?delUser=<?php echo $rowUsers['ID']?>">Excluir</a>
<?php } else { ?>									
									<a class="btn btn-success" href="clientes_cadastro.php?addUser=<?php echo $rowUsers['ID']?>">Ativar</a>
<?php } ?>									
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
