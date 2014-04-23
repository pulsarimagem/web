<?php
?>
<!-- Start Themes -->
<header id="temas" style="display: none;">
			<div class="breadcrumbs"><?php foreach ($arrSearchBreadcrumb as $intKey => $strValue):?><a href="#" <?php echo 'dad='.$intKey;?> onclick="jQuery.ajax({'type':'POST','url':'/pulsar/ajax/AjaxSearchByThemes','data':{'dad':<?php echo $intKey; ?>},'cache':false,'success':function(html){jQuery('#temas').html(html)}});"><?php echo $strValue;?></a><?php endforeach;?></div> 
	<section class="scroller">
		<?php foreach ($arrSearchByThemes as $arrThemes):?>
		<div class="box">
				<figure>
				<?php 
				echo 
					CHtml::link(
						CHtml::image(
								$strUrlStockPhotos.$arrThemes['tombo'].'p.jpg',
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
</header>
<!-- End Themes -->
<!-- Start header -->
<header id="internal">
	<div id="root" class="cf">
		<div class="pulsarimagens">
			<img src="images/logo.png">
		</div>
		<div class="search">
			<?php echo CHtml::form('listing','post');?>
			
			<input type="text" placeholder="<?php echo Yii::t('zii', 'What are you looking for?');?>">
			<?php echo CHtml::submitButton(Yii::t('zii', 'Search'),array('id'=>'buttonHeader','style'=>'background: linear-gradient(to bottom, #FFF002 0%, #FFC600 100%) repeat scroll 0 0 rgba(0, 0, 0, 0); border: 1px solid #CACACA; border-radius: 4px; color: #452929; font-weight: 700; margin-left: 6px; padding: 8px 16px 7px; vertical-align: top; text-transform: none; line-height: normal; font-family: inherit; font-size: 100%;'));?>
			<p>
				<a href="#"><?php echo Yii::t('zii', 'Advanced search');?></a>
			</p>
			 <?php echo CHtml::endForm();?>
		</div>
		<nav class="menu">
			<ul>
				<li class="t">
					<a href="#"><?php echo Yii::t('zii', 'Themes');?><span>▼</span></a>
				</li>
				<li class="m">
					<a href="#"><?php echo Yii::t('zii', 'Login');?></a>
				</li>
				<li class="m">
					<a href="#"><?php echo Yii::t('zii', 'Sign up');?></a>
				</li>
				<li class="l">
					<div class="box">
						<p><img src="images/flag-pt.png"></p>
						<p style="display: none;"><a href="#"></p>
						<span>▼</span>
					</div>
				</li>
			</ul>
		</nav>
	</div>
</header>
<!-- End header -->
<!-- Star Container -->
<!-- End Container -->