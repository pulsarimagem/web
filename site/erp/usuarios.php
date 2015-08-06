<?php require_once('Connections/pulsar.php'); ?>
<?php include("tool_auth.php"); ?>
<?php include("tool_usuarios.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Pulsar Admin - Usuários</title>
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
			<a href="#" class="current">Usuários</a>
		</div>
		<div class="container-fluid">

			<div class="row-fluid">
				<div class="span9">
					<a class="btn btn-success" href="usuarios_cadastro.php?newUser=true">Novo</a> 
<!-- 					<a class="btn btn-danger" href="#">Excluir todos</a> -->
				</div>
				<div class="span3">
					<form>
						<input class="span12" type="text" name="busca" placeholder="Busca" />
					</form>
				</div>
			</div>
			<div class="row-fluid">
				<div class="span12">

					<table class="table table-bordered table-striped with-check">
						<thead>
							<tr>
								<th><input type="checkbox" /></th>
								<th>Login</th>
								<th>Nome</th>
								<th>Função</th>
								<!--                   <th>E-mail</th> -->
								<th>Status</th>
								<th>Açoes</th>
							</tr>
						</thead>
						<tbody>
							<?php while ($rowUsers = mysql_fetch_assoc($rsUsers)) { ?>
							<tr>
								<td><input type="checkbox" /></td>
								<td><a href="usuarios_cadastro.php?idUser=<?php echo $rowUsers['id']?>"><?php echo $rowUsers['usuario']?></a></td>
								<td><?php echo $rowUsers['nome']?></td>
								<td><?php echo $rowUsers['role']?></td>
								<!--                     <td>zoca@zoca.com.br</td> -->
								<td><?php echo ($rowUsers['status']=='D'?"Excluído":"Válido")?></td>
								<td>
									<a class="btn btn-primary" href="usuarios_cadastro.php?idUser=<?php echo $rowUsers['id']?>">Editar</a>&nbsp;
									<a class="btn btn-danger confirmOnclick" href="usuarios_cadastro.php?delUser=<?php echo $rowUsers['id']?>">Excluir</a>
								</td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
					<!-- 
            <div class="pagination pagination-right">
              <ul>
                <li class="disabled"><a href="#">«</a></li>
                <li class="active"><a href="#">1</a></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a href="#">4</a></li>
                <li><a href="#">5</a></li>
                <li><a href="#">»</a></li>
              </ul>
            </div>
 -->
				</div>
			</div>


			<?php include('page_bottom.php'); ?>
		</div>
	</div>
	<!-- END #content -->

	<?php include('includes_footer.php'); ?>

</body>
</html>
