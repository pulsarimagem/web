<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml' xml:lang='pt-br' lang='pt-br' dir="ltr">
<head>
	<meta name='language' content='pt-br' />
	<meta name="keywords" content="" />
	<meta name="robots" content="noindex" /> 
	
	<!-- Inicio, folhas de estilo -->
	<?php Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/bootstrap.css?v=1.1'); ?>
	<?php Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/bootstrap-responsive.min.css?v=1.1'); ?>
	<?php Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/bootstrap-datetimepicker.min.css?v=1.1'); ?>
	<?php Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/uniform.css?v=1.1'); ?>
	<?php Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/chosen.css?v=1.1'); ?>
	<?php Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/select2.css?v=1.1'); ?>
	<?php Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/pulsar.main.css?v=1.1'); ?>
	<?php Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/pulsar.custom.css?v=1.1'); ?>
	<?php Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/pulsar.grey.css?v=1.1'); ?>
	<?php Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/ui-lightness/jquery-ui-1.8.22.custom.css?v=1.1'); ?>
	<?php Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/mbTooltip.css?v=1.1'); ?>
	<?php Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/ajustes_layout.css?v=1.1'); ?>
	<!-- Fim, folhas de estilo -->
	<!-- Inicio, javascript -->
	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery-1.8.3.min.js?v=1.1'); ?>
	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.jeditable.mini.js?v=1.1'); ?>
	<?php //Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/ckeditor/ckeditor.js?v=1.1'); ?>
	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/mbTooltip.js?v=1.1'); ?>
	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.dropshadow.js?v=1.1'); ?>
	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.timers.js?v=1.1'); ?>
	<!-- Fim, javascript --> 
	
</head>
<body>
	<div id="header">
		<h1><a href="<?php echo Yii::app()->baseUrl.'/home/index';?>">Pulsar Admin</a></h1>		
	</div>
	<!-- Inicio, Navegador topo ERP -->
	<div id="user-nav" class="navbar">
  		<ul class="nav btn-group">
    		<li class="btn btn-mini btn-inverse">
    			<a title="" href="#"><i class="icon icon-cog"></i> <span class="text">Configura��es</span></a>
    		</li>
			<li class="btn btn-mini btn-inverse">
				<a title="" href="./"><i class="icon icon-share-alt"></i> <span class="text">Logout</span></a>
			</li>
		</ul>
	</div>
	<!-- Fim, Navegador topo ERP -->
	<!-- Inicio, Menu ERP -->
	<div id="sidebar">
		<a href="#" class="visible-phone"><i class="icon icon-home"></i> Dashboard</a>
		<ul>
			<?php print_r($this->arrMenu); ?>
		</ul>
	</div>
	<!-- Fim, Menu ERP -->
<?php echo $content; ?>	
</body>
<!-- Inicio, JavaScript -->
	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/excanvas.min.js?v=1.1'); ?>
	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.ui.custom.js?v=1.1'); ?>
	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/bootstrap.min.js?v=1.1'); ?>
	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/bootstrap-datetimepicker.min.js?v=1.1'); ?>
	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/pulsar.js?v=1.1'); ?>
	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/pulsar.dashboard.js?v=1.1'); ?>
	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.uniform.js?v=1.1'); ?>
	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.chosen.js?v=1.1'); ?>
	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.dataTables.min.js?v=1.1'); ?>
	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/pulsar.form_common.js?v=1.1'); ?>
	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/pulsar.tables.js?v=1.1'); ?>
	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/select2.min.js?v=1.1'); ?>
	<?php //Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery-ui-1.8.22.custom.min.js?v=1.1'); ?>
	<?php // Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.ui.datepicker-pt-BR.js?v=1.1'); ?>
	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/video/jwplayer.js?v=1.1'); ?>
	<?php Yii::app()->clientScript->registerScriptFile('http://tarruda.github.com/bootstrap-datetimepicker/assets/js/bootstrap-datetimepicker.pt-BR.js?v=1.1'); ?>
	<!-- Fim, JavaScript -->
</html>