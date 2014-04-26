<?php
/* 
 * 
 * @var $this HomeController
 * 
 * Variaveis recebidas pelo controller
 *  
 * @var $this strImageRandon Imagem randomica da home
 * @var $this arrAddedLastCarousel imagens e informacoes para o carrossel adiconadas recentimente
 * @var $this arrlatestCarouselSearch imagens e informacoes para o carrossel ultimas pesquisadas 
 * @var $this arrSearchByThemes conteudo com as imagens para busca por temas
 * 
 * */
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
<header id="header">
	<div id="root" class="cf">
        <div class="pulsarimagens">
        	<img src="images/logo.png" /></div>
        <nav class="menu">
            <ul>
                <li class="t"><a href="#"><?php echo Yii::t('zii','Themes');?> <span>▼</span></a></li>
                <li class="m"><a href="#"><?php echo Yii::t('zii', 'how it works?');?></a></li>
                <li class="m"><a href="#"><?php echo Yii::t('zii', 'Login');?></a></li>
                <li class="m"><a href="#"><?php echo Yii::t('zii', 'Sign up');?></a></li>
                <li class="l">
                    <div class="box">
                        <p><img src="images/flag-pt.png" /></p>
                        <p style="display: none;"><a href="#"><img src="images/flag-en.png" /></a></p>
                        <span>▼</span>
                    </div>
                </li>
            </ul>
        </nav>
	</div>
</header>	
<!-- End header -->
<!-- Start Container -->
<section id="big-search" style="background-image: url(images/home/<?php echo $strImageRandon;?>.jpg)">	
    	<div class="mask">
            <div class="search">
                <?php echo CHtml::form('listing','post');?>
                <?php echo CHtml::textField('buscador','', array('id'=>'search', 'placeholder'=>Yii::t('zii', 'What are you looking for? (code or keyword)')))?>
                <?php echo CHtml::submitButton(Yii::t('zii', 'Search'),array('id'=>'buttonSearch'));?>
                <?php echo CHtml::endForm();?>
                <p><a href="#"><?php echo Yii::t('zii', 'Advanced search');?></a></p>
            </div>
        </div>
	</section>
	
		<section id="slider-bar">
    	<div class="title"><div id="root">
        	<h2><?php echo Yii::t('zii', 'Recently added');?></h2>
        </div></div>
        <div class="carousel">
        	<div class="overflow">
                <ul>
                <?php foreach ($arrAddedLastCarousel as $strValue):?>
                    <li>
                    	<?php if(ctype_alpha(substr($strValue['tombo'], 0,1))) :?>
                    		<a href="#"><img src="<?php echo $strUrlCloud.$strValue['tombo'];?>_3s.jpg"></a>
                    	<?php else:?>
                        	<a href="#"><img src="<?php echo $strUrlStockPhotos.$strValue['tombo'];?>p.jpg"></a>
                    	<?php endif;?>
                    </li>
                <?php endforeach;?>    
                </ul>
            </div>
        </div>
        <nav class="nav left"></nav>
        <nav class="nav right"></nav>
	</section>
	<section id="slider-bar">
    	<div class="title"><div id="root">
        	<h2><?php echo Yii::t('zii','Last searches');?></h2>
        </div></div>
        <div class="carousel">
        	<div class="overflow">
                <ul>
                	<?php foreach ($arrlatestCarouselSearch as $strValue):?>
                    <li>
                    	<?php if(ctype_alpha(substr($strValue['tombo'], 0,1))) :?>
                    		<a href="#"><img src="<?php echo $strUrlCloud.$strValue['tombo'];?>_3s.jpg"></a>
                    	<?php else:?>
                        	<a href="#"><img src="<?php echo $strUrlStockPhotos.$strValue['tombo'];?>p.jpg"></a>
                    	<?php endif;?>
                    </li>
                    <?php endforeach;?>
                </ul>
            </div>
        </div>
        <nav class="nav left"></nav>
        <nav class="nav right"></nav>
	</section>
	<footer id="sobre">
		<div id="root">
	    	<figure><img src="images/logo.png" /></figure>
	        <article>
	            <h2><?php echo Yii::t('zii', 'About Pulsar');?></h2>
	            <p><?php echo Yii::t('zii','We are an image database that brings together the photographic production of over forty photographers with solid individual careers, and concerned with documenting our country, its people, customs and culture, its economic output, fauna, flora and all its vast territorial extension.');?></p>
	        </article>
		</div>
	</footer>
<!-- End Container -->	