<?php if($arrSearchByThemes[0]['tombo'] == '' && $arrSearchByThemes[0]['Id'] == ''):?>
	<div class="box">
		<figure>
			<?php echo $strMensagem; ?>
		</figure>
		<span class="titulo">
		</span>
	</div>			
<?php else: ?>
	<?php $intCont = 1;?>
	<div class="breadcrumbs">
		<?php foreach ($arrSearchBreadcrumb as $intKey => $strValue):?><a href="#" <?php echo 'dad='.$intKey;?> onclick="jQuery.ajax({'type':'POST','url':'/pulsar/ajax/AjaxSearchByThemes','data':{'dad':<?php echo $intKey; ?>},'cache':false,'success':function(html){jQuery('#temas').html(html)}});"><?php echo $strValue;?></a><?php echo  ($intCountArrayBreadcumb > $intCont ? ' > ' : ''); $intCont++;?> <?php endforeach;?>
	</div>
	<section class="scroller">
		<?php foreach ($arrSearchByThemes as $arrThemes):?>
		<div class="box">
				<figure>
				<?php 
				echo 
					CHtml::link(
						CHtml::image(
								'http://www.pulsarimagens.com.br/bancoImagens/'.$arrThemes['tombo'].'p.jpg',
								$arrThemes['Tema'].' '.$arrThemes['Id'], 
								array('onclick'=>CHtml::ajax(array(
													'update'=>'#temas',
													'type'=>'POST',
													'url'=>array('ajax/AjaxSearchByThemes'),
													'data'=>array('dad'=>$arrThemes['Id'])
												 )
									 )
								)
					), '#');
				?>
				</figure>
				<span class="titulo">
					<h2><?php echo CHtml::link($arrThemes['Tema'],'#' );?></h2>
				</span>
		</div>	
		<?php endforeach;?>
	</section>
<?php endif;?>