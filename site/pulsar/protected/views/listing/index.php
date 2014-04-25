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
<!-- Start Container -->
<!-- Start  Search Advanced -->
<section id="lightbox-details">
	<aside class="results" style="width: 25%;"><div class="box">
			<h4><?php echo Yii::t('zii', 'Your Search');?></h4>
			<div class="palavras-chave">
				<h5><?php echo Yii::t('zii', 'Keywords');?></h5>
				<p class="tag"><span class="t">amazônia</span><span class="remove">x</span></p>
				<p class="tag"><span class="t">amazônia</span><span class="remove">x</span></p>
				<p class="clean"><a href="#"><?php echo Yii::t('zii', 'clear all');?></a></p>
			</div>
			<ul>
				<li>
					<label><?php echo Yii::t('zii', 'Date');?></label>
					<select style="width:47.5%"></select> <select style="width:50%"></select>
				</li>
				<li>
					<label><?php echo Yii::t('zii', 'Format');?></label>
					<input type="checkbox"><span class="label"><?php echo Yii::t('zii', 'Horizontal');?></span><input type="checkbox"><span class="label"><?php echo Yii::t('zii', 'Vertical');?></span>
				</li>
				<li>
					<label><?php echo Yii::t('zii', 'Add Keywords');?></label>
					<input type="text">
				</li>
				<li>
					<button><span><?php echo Yii::t('zii', 'Filter results');?></span></button>
					<p><a href="#"><?php echo Yii::t('zii', 'Advanced search');?></a></p>
				</li>
			</ul>
		</div>
	</aside>
<!-- End  Search Advanced -->
<!-- Start  Search Results -->		
		<div class="container" style="width: 74%;">
		<?php if(!Yii::app()->user->getState('arrImage') && !Yii::app()->user->getState('arrVideo')) :?>
			<?php echo $strMessageError;?>
		<?php else:?>
			<?php if(isset($arrVideo[$intPage])):?>
				<?php $intPageMenu = ($intPage <= $intVideoPage ? $intPage : 1);?>
			<?php else:?>	
				<?php $strType = 'video';?>
				<?php $intPageMenu = ($intPage <= $intVideoPage ? $intPage : 1);?>
			<?php endif;?>
			<nav class="tabs">
				<a href="#" class="select fotos"  idChange='<?php echo $intChange;?>' typePage='image'  page='<?php echo $intPageMenu;?>' >
					<span><?php echo Yii::t('zii', 'Photos');?></span>
				</a>
				<a href="#" class="videos"   idChange='<?php echo $intChange;?>' typePage='video'  page='<?php echo $intPageMenu;?>' >
					<span><?php echo Yii::t('zii', 'Videos');?></span>
				</a>
			<span class="exibindo"><?php echo Yii::t('zii', 'Showing');?> <?php echo (Yii::app()->user->getState('intViewPage') >= Yii::app()->user->getState('countImage') ? Yii::app()->user->getState('countImage') : Yii::app()->user->getState('intViewPage'));?> <?php echo Yii::t('zii', 'of');?> <?php echo Yii::app()->user->getState('countImage');?> <?php echo Yii::t('zii', 'images');?></span>
			</nav>
			<nav class="navigation cf">
				<div class="ordernar">
					<label><?php echo Yii::t('zii', 'Order by');?>:</label>
					<select>
						<option><?php echo Yii::t('zii', 'File size');?></option>
					</select>
				</div>
				<div class="pages">
						<?php $booReticencias = true;?>
						<?php if($intPage != 1):?>
							<a href="#" idChange='<?php echo $intChange;?>' typePage='<?php echo $strType;?>' page='<?php echo $intPage-1;?>' class="arrow">&lt;</a>
						<?php endif;?>
						<?php $intNext = 0;?>
						<?php $booPrintPre = true;?>
						<?php $booPrintNex = $intImagePage-2; ?>
						<?php $strExecute = true;?>
						<?php $intLimit = $intImagePage-1; ?>
						<?php for($intCountImage = 1; $intCountImage <= $intImagePage; $intCountImage++):?>
							
							<?php if($intImagePage <= 7):?>
									<?php $booReticencias = false;?>
									<?php if($intPage == $intCountImage):?>
										<a href="#" idChange='<?php echo $intChange;?>' typePage='<?php echo $strType;?>' page='<?php echo $intCountImage;?>' class="page checked">
											<?php echo $intCountImage;  $intPageCurrent = $intCountImage;?>
										</a>
									<?php else:?>
										<a href="#" idChange='<?php echo $intChange;?>' typePage='<?php echo $strType;?>' page='<?php echo $intCountImage;?>' class="page">
											<?php echo $intCountImage;?>
										</a>
									<?php endif;?>	
							<?php else:?>
								<?php if($intCountImage == 1 || $intCountImage == 2):?>
									<?php if($intPage == 1 & $intCountImage != 2):?>
										
										<a href="#" idChange='<?php echo 1;?>' typePage='<?php echo $strType;?>' page='<?php echo 1;?>' class="page checked">
											<?php echo 1;?>
										</a>
										<a href="#" idChange='<?php echo 2;?>' typePage='<?php echo $strType;?>' page='<?php echo 2;?>' class="page">
											<?php echo 2;?>
										</a>
										<a href="#" idChange='<?php echo 3;?>' typePage='<?php echo $strType;?>' page='<?php echo 3;?>' class="page">
											<?php echo 3;?>
										</a>
										<?php $strExecute = false;?>
									<?php elseif($intPage == 2 & $intCountImage != 1):?>
										
										<a href="#" idChange='<?php echo $intCountImage-1;?>' typePage='<?php echo $strType;?>' page='<?php echo $intCountImage-1;?>' class="page">
										<?php echo $intCountImage-1;?>
										</a>
										<a href="#" idChange='<?php echo $intCountImage;?>' typePage='<?php echo $strType;?>' page='<?php echo $intCountImage;?>' class="page checked">
										<?php echo $intCountImage;  $intPageCurrent = $intCountImage;?>
										</a>
										<a href="#" idChange='<?php echo $intCountImage+1;?>' typePage='<?php echo $strType;?>' page='<?php echo $intCountImage+1;?>' class="page">
											<?php echo $intCountImage+1;?>
										</a>
										<?php $strExecute = false;?>
									<?php endif;?>
									<?php if($intPage != 1 & $intPage != 2):?>
										
										<a href="#" idChange='<?php echo $intCountImage;?>' typePage='<?php echo $strType;?>' page='<?php echo $intCountImage;?>' class="page">
										<?php echo $intCountImage;  $intPageCurrent = $intCountImage;?>
										</a>
									<?php endif;?>
								<?php endif;?>
									
								<?php if($strExecute):?>	
									<?php if($intPage == $intCountImage):?>
										<?php if($intPage > 3):?>
											<span>...</span>
										<?php endif;?>
										<?php if($intPage > 3):?>
										<a href="#" idChange='<?php echo $intCountImage-1;?>' typePage='<?php echo $strType;?>' page='<?php echo $intCountImage-1;?>' class="page">
											<?php echo $intCountImage-1;?>
										</a>
										<?php endif;?>
										<a href="#" idChange='<?php echo $intCountImage;?>' typePage='<?php echo $strType;?>' page='<?php echo $intCountImage;?>' class="page checked">
											<?php echo $intCountImage;  $intPageCurrent = $intCountImage;?>
										</a>
										<a href="#" idChange='<?php echo $intCountImage+1;;?>' typePage='<?php echo $strType;?>' page='<?php echo $intCountImage+1;?>' class="page">
											<?php echo $intCountImage+1;?>
										</a>
										<?php if($intPage == 3):?>
										<a href="#" idChange='<?php echo $intCountImage+2;?>' typePage='<?php echo $strType;?>' page='<?php echo $intCountImage+2;?>' class="page">
											<?php echo $intCountImage+2;?>
										</a>
										<?php elseif(($intImagePage ) == ($intCountImage)):?>
											<a href="#" idChange='<?php echo $intCountImage;?>' typePage='<?php echo $strType;?>' page='<?php echo $intCountImage;?>' class="page">
											<?php echo $intCountImage;?>
											</a>
										<?php endif;?>
									<?php endif;?>
								<?php endif;?>
							<?php endif;?>
						<?php endfor;?>	
						<?php if($booReticencias):?>
							<?php if(($intPage ) == ((int) $booPrintNex - 1)):?>	
								<a href="#" idChange='<?php echo $intCountImage;?>' typePage='<?php echo $strType;?>' page='<?php echo $intCountImage;?>' class="page">
									<?php echo $intLimit;?>
								</a>
								<a href="#" idChange='<?php echo $intCountImage;?>' typePage='<?php echo $strType;?>' page='<?php echo $intCountImage;?>' class="page">
									<?php echo $intImagePage;?>
								</a>
							<?php elseif($intImagePage < $intCountImage & $intImagePage != $intCountImage):?>
								<span>...</span>
								<a href="#" idChange='<?php echo $intCountImage;?>' typePage='<?php echo $strType;?>' page='<?php echo $intLimit;?>' class="page">
									<?php echo $intLimit;?>
								</a>
								<a href="#" idChange='<?php echo $intCountImage;?>' typePage='<?php echo $strType;?>' page='<?php echo $intImagePage;?>' class="page">
									<?php echo $intImagePage;?>
								</a>
								<a href="#" idChange='<?php echo $intChange;?>' typePage='<?php echo $strType;?>' page='<?php echo $intPage+1;?>' class="arrow">&gt;</a>
							<?php endif;?>
						<?php else:?>
							<a href="#" idChange='<?php echo $intChange;?>' typePage='<?php echo $strType;?>' page='<?php echo $intPage+1;?>' class="arrow">&gt;</a>	
						<?php endif;?>	
				</div>
				<div class="filter">
					<button></button>
					<div class="config">
						<p>
							<span class="label"><?php echo Yii::t('zii', 'Display');?></span>
							<a href="#" class="first col <?php echo ($intChange == 50 ? 'checked' : '');?>" id='50' idChange='50' page='<?php echo $intPage;?>' typePage='image'>
								<span class="mark">▼</span>
								50
							</a><a href="#" class="col <?php echo ($intChange == 100 ? 'checked' : '');?>" id='100' idChange='100' page='<?php echo $intPage;?>'  typePage='image'>
								<span class="mark" id='100'>▼</span>
								100
							</a><a href="#" class="col  <?php echo ($intChange == 150 ? 'checked' : '');?>" id='150' idChange='150'page='<?php echo $intPage;?>'  typePage='image'>
								<span class="mark" id='150'>▼</span>
								150
							</a>
						</p>
						<p>
							<span class="label"><?php echo Yii::t('zii', 'Preview');?></span>
							<a href="#" class="first col checked" id='on'>
								<span class="mark">▼</span>
								<?php echo Yii::t('zii', 'on');?>
							</a>
							<a href="#" class="col" id='off'>
								<span class="mark">▼</span>
								<?php echo Yii::t('zii', 'off');?>
							</a>
						</p>
					</div>
				</div>
			</nav>
			<div class="entry">
				<?php foreach ($arrImage[1] as $strValue) :?>
				<div class="box">
					<div class="embed">
						<?php echo CHtml::image($strUrlStockPhotos.$strValue['tombo'].'p.jpg' );?>
						<div class="buttons">
							<button class="adicionar"><span><?php echo Yii::t('zii', 'Add');?></span></button>
							<?php if(Yii::app()->user->GetState('logado')) :?>
							<div class="add">
								<a href="#">Amazônia (12)</a>
								<a href="#">Índios (23)</a>
								<a href="#">Rios (234)</a>
								<a href="#"><?php echo Yii::t('zii', 'CREATE NEW FOLDER');?></a>
							</div>
							<?php else:?>
							<div class="add">
								<a href="#"><?php echo Yii::t('zii', 'Add to My Folders: To add this image to your folders you must login first');?></a>
							</div>
							<?php endif;?>
						</div>
					</div>
					<div class="bigger">
						<div class="mesa">
							<?php echo CHtml::image($strUrlStockPhotos.$strValue['tombo'].'.jpg', $strValue['tombo'],array('style'=>'max-width:350px;'));?>
						</div>
						<p class="name"><?php echo $strValue['tombo'];?></p>
						<div class="div"></div>
						<p class="local"><?php echo $strValue['assunto_principal'].' - '.$strValue['cidade'].' - '.$strValue['Sigla'];?></p>
						
					</div>
				</div>
				<?php endforeach;?>	
			</div>
			<nav class="navigation" class="cf">
				<div class="pages">
						<?php $booReticencias = true;?>
						<?php if($intPage != 1):?>
							<a href="#" idChange='<?php echo $intChange;?>' typePage='<?php echo $strType;?>' page='<?php echo $intPage-1;?>' class="arrow">&lt;</a>
						<?php endif;?>
						<?php $intNext = 0;?>
						<?php $booPrintPre = true;?>
						<?php $booPrintNex = $intImagePage-2; ?>
						<?php $strExecute = true;?>
						<?php $intLimit = $intImagePage-1; ?>
						<?php for($intCountImage = 1; $intCountImage <= $intImagePage; $intCountImage++):?>
							
							<?php if($intImagePage <= 9):?>
									<?php $booReticencias = false;?>
									<?php if($intPage == $intCountImage):?>
										<a href="#" idChange='<?php echo $intChange;?>' typePage='<?php echo $strType;?>' page='<?php echo $intCountImage;?>' class="page checked">
											<?php echo $intCountImage;  $intPageCurrent = $intCountImage;?>
										</a>
									<?php else:?>
										<a href="#" idChange='<?php echo $intChange;?>' typePage='<?php echo $strType;?>' page='<?php echo $intCountImage;?>' class="page">
											<?php echo $intCountImage;?>
										</a>
									<?php endif;?>	
							<?php else:?>
								<?php if($intCountImage == 1 || $intCountImage == 2):?>
									<?php if($intPage == 1 & $intCountImage != 2):?>
										
										<a href="#" idChange='<?php echo 1;?>' typePage='<?php echo $strType;?>' page='<?php echo 1;?>' class="page checked">
											<?php echo 1;?>
										</a>
										<a href="#" idChange='<?php echo 2;?>' typePage='<?php echo $strType;?>' page='<?php echo 2;?>' class="page">
											<?php echo 2;?>
										</a>
										<a href="#" idChange='<?php echo 3;?>' typePage='<?php echo $strType;?>' page='<?php echo 3;?>' class="page">
											<?php echo 3;?>
										</a>
										<?php $strExecute = false;?>
									<?php elseif($intPage == 2 & $intCountImage != 1):?>
										
										<a href="#" idChange='<?php echo $intCountImage-1;?>' typePage='<?php echo $strType;?>' page='<?php echo $intCountImage-1;?>' class="page">
										<?php echo $intCountImage-1;?>
										</a>
										<a href="#" idChange='<?php echo $intCountImage;?>' typePage='<?php echo $strType;?>' page='<?php echo $intCountImage;?>' class="page checked">
										<?php echo $intCountImage;  $intPageCurrent = $intCountImage;?>
										</a>
										<a href="#" idChange='<?php echo $intCountImage+1;?>' typePage='<?php echo $strType;?>' page='<?php echo $intCountImage+1;?>' class="page">
											<?php echo $intCountImage+1;?>
										</a>
										<?php $strExecute = false;?>
									<?php endif;?>
									<?php if($intPage != 1 & $intPage != 2):?>
										
										<a href="#" idChange='<?php echo $intCountImage;?>' typePage='<?php echo $strType;?>' page='<?php echo $intCountImage;?>' class="page">
										<?php echo $intCountImage;  $intPageCurrent = $intCountImage;?>
										</a>
									<?php endif;?>
								<?php endif;?>
									
								<?php if($strExecute):?>	
									<?php if($intPage == $intCountImage):?>
										<?php if($intPage > 3):?>
											<span>...</span>
										<?php endif;?>
										<?php if($intPage > 3):?>
										<a href="#" idChange='<?php echo $intCountImage-1;?>' typePage='<?php echo $strType;?>' page='<?php echo $intCountImage-1;?>' class="page">
											<?php echo $intCountImage-1;?>
										</a>
										<?php endif;?>
										<a href="#" idChange='<?php echo $intCountImage;?>' typePage='<?php echo $strType;?>' page='<?php echo $intCountImage;?>' class="page checked">
											<?php echo $intCountImage;  $intPageCurrent = $intCountImage;?>
										</a>
										<a href="#" idChange='<?php echo $intCountImage+1;;?>' typePage='<?php echo $strType;?>' page='<?php echo $intCountImage+1;?>' class="page">
											<?php echo $intCountImage+1;?>
										</a>
										<?php if($intPage == 3):?>
										<a href="#" idChange='<?php echo $intCountImage+2;?>' typePage='<?php echo $strType;?>' page='<?php echo $intCountImage+2;?>' class="page">
											<?php echo $intCountImage+2;?>
										</a>
										<?php elseif(($intImagePage ) == ($intCountImage)):?>
											<a href="#" idChange='<?php echo $intCountImage;?>' typePage='<?php echo $strType;?>' page='<?php echo $intCountImage;?>' class="page">
											<?php echo 'a'.$intCountImage;?>
											</a>
										<?php endif;?>
									<?php endif;?>
								<?php endif;?>
							<?php endif;?>
						<?php endfor;?>	
						<?php if($booReticencias):?>
							<?php if(($intPage ) == ((int) $booPrintNex - 1)):?>	
								<a href="#" idChange='<?php echo $intCountImage;?>' typePage='<?php echo $strType;?>' page='<?php echo $intCountImage;?>' class="page">
									<?php echo $intLimit;?>
								</a>
								<a href="#" idChange='<?php echo $intCountImage;?>' typePage='<?php echo $strType;?>' page='<?php echo $intCountImage;?>' class="page">
									<?php echo $intImagePage;?>
								</a>
							<?php elseif($intImagePage < $intCountImage & $intImagePage != $intCountImage):?>
								<span>...</span>
								<a href="#" idChange='<?php echo $intCountImage;?>' typePage='<?php echo $strType;?>' page='<?php echo $intLimit;?>' class="page">
									<?php echo $intLimit;?>
								</a>
								<a href="#" idChange='<?php echo $intCountImage;?>' typePage='<?php echo $strType;?>' page='<?php echo $intImagePage;?>' class="page">
									<?php echo $intImagePage;?>
								</a>
								<a href="#" idChange='<?php echo $intChange;?>' typePage='<?php echo $strType;?>' page='<?php echo $intPage+1;?>' class="arrow">&gt;</a>
							<?php endif;?>
						<?php else:?>
							<a href="#" idChange='<?php echo $intChange;?>' typePage='<?php echo $strType;?>' page='<?php echo $intPage+1;?>' class="arrow">&gt;</a>	
						<?php endif;?>	
				</div>
			</nav>
		<?php endif;?>	
		</div>
    </section>
<!-- End Search Results -->	    
<!-- End Container -->