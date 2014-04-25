<?php
echo '<script type="text/javascript" src="'.Yii::app()->baseUrl.'/js/code.js'.'"></script>';
echo '<script type="text/javascript" src="'.Yii::app()->baseUrl.'/js/html5.js'.'"></script>';
echo '<script type="text/javascript" src="'.Yii::app()->baseUrl.'/js/search.js'.'"></script>';
?>
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
				<a href="#" class="select fotos"  idChange='<?php echo $intChange;?>' typePage='image'  page='<?php echo $intPage;?>' >
					<span><?php echo Yii::t('zii', 'Photos');?></span>
				</a>
				<a href="#" class="videos"   idChange='<?php echo $intChange;?>' typePage='video'  page='<?php echo $intPage;?>' >
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
						<?php $booStop = true;?>
						<!-- for -->
						<?php for($intCountImage = 1; $intCountImage <= $intImagePage; $intCountImage++):?>
							<!-- 1 -->						
							<?php if($intImagePage <= 7):?>
								<!-- 2 -->
									<?php if($intPage == $intCountImage):?>
										<a href="#" idChange='<?php echo $intChange;?>' typePage='<?php echo $strType;?>' page='<?php echo $intCountImage;?>' class="page checked">
											<?php echo $intCountImage;  $intPageCurrent = $intCountImage;?>
										</a>
									<?php else:?>
								<!-- 2 -->	
										<a href="#" idChange='<?php echo $intChange;?>' typePage='<?php echo $strType;?>' page='<?php echo $intCountImage;?>' class="page">
											<?php echo $intCountImage;?>
										</a>
									<?php endif;?>
								<!-- 2 -->	
							<!-- 1 -->		
							<?php else:?>
								<!-- 1b -->
								<?php if($intCountImage == 1 || $intCountImage == 2):?>
									<!-- 3 -->
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
									<!-- 3 -->
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
									<!-- 3 -->
									<?php endif;?>
									<!-- 4 -->
									<?php if($intPage != 1 & $intPage != 2):?>
										
										<a href="#" idChange='<?php echo $intCountImage;?>' typePage='<?php echo $strType;?>' page='<?php echo $intCountImage;?>' class="page">
										<?php echo $intCountImage;  $intPageCurrent = $intCountImage;?>
										</a>
									<!-- 4 -->		
									<?php endif;?>
								<!-- 1b -->								
								<?php endif;?>
								<!-- 5 -->					
								<?php if($strExecute):?>	
									<!-- 6 -->	
									<?php if($intPage == $intCountImage):?>
										<!-- 7 -->
										<?php if($intPage != 3):?>
											<span>...</span>
										<!-- 7 -->	
										<?php endif;?>
										<!-- 8 -->
										<?php if($intPage > 3):?>
										<a href="#" idChange='<?php echo $intCountImage-1;?>' typePage='<?php echo $strType;?>' page='<?php echo $intCountImage-1;?>' class="page">
											<?php $booStop = true;?>
											<?php echo $intCountImage-1;?>
										<!-- 8 -->
										<?php endif;?>
										<!-- sempre -->
										<a href="#" idChange='<?php echo $intCountImage;?>' typePage='<?php echo $strType;?>' page='<?php echo $intCountImage;?>' class="page checked">
											<?php //$strExecute = true;?>
											<?php //$booStop = true;?>	
											<?php echo $intCountImage;  $intPageCurrent = $intCountImage;?>
										</a>
										<?php $booStop2 = true;?>
										<!-- 9 -->
										<?php if(($intImagePage ) == ($intCountImage)):?>
											<?php //echo 'intImagePage == intCountImage';?> 
											<?php $booStop = false;?>	
											<?php $booStop2 = false;?>
										<!-- 9 -->
										<?php elseif(($intImagePage ) >= ($intCountImage)):?>
											<?php //echo 'intImagePage >= intCountImage';?>
											<?php $booStop = false;?>	
											<?php $booStop2 = true;?>	
										<!-- 9 -->
										<?php endif;?>
										<!-- 10 -->
										<?php if($intPage == 3):?>
											<?php $booStop2 = false;?>
											<?php $booStop = true;?>
											<a href="#" idChange='<?php echo $intCountImage+1;?>' typePage='<?php echo $strType;?>' page='<?php echo $intCountImage+1;?>' class="page">
												<?php echo $intCountImage+1;?>	
											</a>
											<a href="#" idChange='<?php echo $intCountImage+2;?>' typePage='<?php echo $strType;?>' page='<?php echo $intCountImage+2;?>' class="page">
												<?php echo $intCountImage+2;?>
											</a>
										<!-- 10 -->	
										<?php endif;?>
										<!-- 11 -->
										<?php if($booStop2):?>	
											<a href="#" idChange='<?php echo $intCountImage+1;?>' typePage='<?php echo $strType;?>' page='<?php echo $intCountImage+1;?>' class="page">
												
												<?php echo $intCountImage+1;?>	
											</a>
											<!-- 12 -->	
											<?php if(($intImagePage ) == ($intCountImage)):?>
												<?php $booStop = false;?>
												<a href="#" idChange='<?php echo $intCountImage;?>' typePage='<?php echo $strType;?>' page='<?php echo $intCountImage;?>' class="page">
												<?php echo $intCountImage;?>
												</a>
											<!-- 12 -->	
											<?php endif;?>
										<!-- 11 -->	
										<?php endif;?>
									<!-- 6 -->	
									<?php endif;?>
								<!-- 5 -->	
								<?php endif;?>
							<!-- 1 -->	
							<?php endif;?>
						<!-- for -->	
						<?php endfor;?>
						<!-- 8b -->
						<?php /*if($intPage > 3 && $booStop == false):?>
						8b<span>...</span>
							<a href="#" idChange='<?php echo $intCountImage;?>' typePage='<?php echo $strType;?>' page='<?php echo $intLimit;?>' class="page">
								<?php echo $intLimit;?>
							</a>
							<a href="#" idChange='<?php echo $intCountImage;?>' typePage='<?php echo $strType;?>' page='<?php echo $intImagePage;?>' class="page">
								<?php echo $intImagePage;?>
							</a>
								<a href="#" idChange='<?php echo $intChange;?>' typePage='<?php echo $strType;?>' page='<?php echo $intPage+1;?>' class="arrow">&gt;</a>
							</a>
						<?endif;*/ ?>	
						<!-- 2 --><!-- novo, antes funcionava -->
						
						<?php //if($intImagePage > 1):?>
							<!-- 13 -->
							<?php if(($intPage ) == ((int) $booPrintNex)):?>
								
								<a href="#" idChange='<?php echo $intImagePage;?>' typePage='<?php echo $strType;?>' page='<?php echo $intImagePage;?>' class="page">
										<?php echo $intImagePage;?>
								</a>
								<?php //echo '1z';?>
							<!-- 13 -->	
							<?php elseif(($intPage - $booPrintNex) == 2):?>
								<?php //echo 13;?>
							<!-- 13 -->
							<?php elseif(($intPage ) > ((int) $booPrintNex)):?>
								
							<!-- 13 -->
							<?php else:?>	
								<!-- 14 -->	
								<?php if(($intPage ) == ((int) $booPrintNex - 1)):?>	
									<a href="#" idChange='<?php echo $intCountImage;?>' typePage='<?php echo $strType;?>' page='<?php echo $intLimit;?>' class="page">
										<?php echo $intLimit;?>
									</a>
									<a href="#" idChange='<?php echo $intCountImage;?>' typePage='<?php echo $strType;?>' page='<?php echo $intImagePage;?>' class="page">
										<?php echo $intImagePage;?>
									</a>
								<!-- 14 -->	
								<?php elseif($intImagePage < $intCountImage & $intImagePage != $intCountImage):?>
									<span>...</span>
									<a href="#" idChange='<?php echo $intCountImage;?>' typePage='<?php echo $strType;?>' page='<?php echo $intLimit;?>' class="page">
										<?php echo $intLimit;?>
									</a>
									<a href="#" idChange='<?php echo $intCountImage;?>' typePage='<?php echo $strType;?>' page='<?php echo $intImagePage;?>' class="page">
										<?php echo $intImagePage;?>
									</a>
									<a href="#" idChange='<?php echo $intChange;?>' typePage='<?php echo $strType;?>' page='<?php echo $intPage+1;?>' class="arrow">&gt;</a>
								<!-- 14 -->
								<?php endif;?>
							<!-- 13 -->	
							<?php endif;?>
						<!-- 2 --><!-- novo, antes funcionava -->	
						<?php //endif;?>		
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
				<?php foreach ($arrImage[$intPage] as $strValue) :?>
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
						<?php $booStop = true;?>
						<!-- for -->
						<?php for($intCountImage = 1; $intCountImage <= $intImagePage; $intCountImage++):?>
							<!-- 1 -->						
							<?php if($intImagePage <= 9):?>
								<!-- 2 -->
									<?php if($intPage == $intCountImage):?>
										<a href="#" idChange='<?php echo $intChange;?>' typePage='<?php echo $strType;?>' page='<?php echo $intCountImage;?>' class="page checked">
											<?php echo $intCountImage.' - '.$intPage;  $intPageCurrent = $intCountImage;?>
										</a>
									<?php else:?>
								<!-- 2 -->	
										<a href="#" idChange='<?php echo $intChange;?>' typePage='<?php echo $strType;?>' page='<?php echo $intCountImage;?>' class="page">
											<?php echo $intCountImage;?>
										</a>
									<?php endif;?>
								<!-- 2 -->	
							<!-- 1 -->		
							<?php else:?>
								<!-- 1b -->
								<?php if($intCountImage == 1 || $intCountImage == 2):?>
									<!-- 3 -->
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
									<!-- 3 -->
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
									<!-- 3 -->
									<?php endif;?>
									<!-- 4 -->
									<?php if($intPage != 1 & $intPage != 2):?>
										
										<a href="#" idChange='<?php echo $intCountImage;?>' typePage='<?php echo $strType;?>' page='<?php echo $intCountImage;?>' class="page">
										<?php echo $intCountImage;  $intPageCurrent = $intCountImage;?>
										</a>
									<!-- 4 -->		
									<?php endif;?>
								<!-- 1b -->								
								<?php endif;?>
								<!-- 5 -->					
								<?php if($strExecute):?>	
									<!-- 6 -->	
									<?php if($intPage == $intCountImage):?>
										<!-- 7 -->
										<?php if($intPage != 3):?>
											<span>...</span>
										<!-- 7 -->	
										<?php endif;?>
										<!-- 8 -->
										<?php if($intPage > 3):?>
										<a href="#" idChange='<?php echo $intCountImage-1;?>' typePage='<?php echo $strType;?>' page='<?php echo $intCountImage-1;?>' class="page">
											<?php $booStop = true;?>
											<?php echo $intCountImage-1;?>
										<!-- 8 -->
										<?php endif;?>
										<!-- sempre -->
										<a href="#" idChange='<?php echo $intCountImage;?>' typePage='<?php echo $strType;?>' page='<?php echo $intCountImage;?>' class="page checked">
											<?php //$strExecute = true;?>
											<?php //$booStop = true;?>	
											<?php echo $intCountImage;  $intPageCurrent = $intCountImage;?>
										</a>
										<?php $booStop2 = true;?>
										<!-- 9 -->
										<?php if(($intImagePage ) == ($intCountImage)):?>
											<?php //echo 'intImagePage == intCountImage';?> 
											<?php $booStop = false;?>	
											<?php $booStop2 = false;?>
										<!-- 9 -->
										<?php elseif(($intImagePage ) >= ($intCountImage)):?>
											<?php //echo 'intImagePage >= intCountImage';?>
											<?php $booStop = false;?>	
											<?php $booStop2 = true;?>	
										<!-- 9 -->
										<?php endif;?>
										<!-- 10 -->
										<?php if($intPage == 3):?>
											<?php $booStop2 = false;?>
											<?php $booStop = true;?>
											<a href="#" idChange='<?php echo $intCountImage+1;?>' typePage='<?php echo $strType;?>' page='<?php echo $intCountImage+1;?>' class="page">
												<?php echo $intCountImage+1;?>	
											</a>
											<a href="#" idChange='<?php echo $intCountImage+2;?>' typePage='<?php echo $strType;?>' page='<?php echo $intCountImage+2;?>' class="page">
												<?php echo $intCountImage+2;?>
											</a>
										<!-- 10 -->	
										<?php endif;?>
										<!-- 11 -->
										<?php if($booStop2):?>	
											<a href="#" idChange='<?php echo $intCountImage+1;?>' typePage='<?php echo $strType;?>' page='<?php echo $intCountImage+1;?>' class="page">
												
												<?php echo $intCountImage+1;?>	
											</a>
											<!-- 12 -->	
											<?php if(($intImagePage ) == ($intCountImage)):?>
												<?php $booStop = false;?>
												<a href="#" idChange='<?php echo $intCountImage;?>' typePage='<?php echo $strType;?>' page='<?php echo $intCountImage;?>' class="page">
												<?php echo $intCountImage;?>
												</a>
											<!-- 12 -->	
											<?php endif;?>
										<!-- 11 -->	
										<?php endif;?>
									<!-- 6 -->	
									<?php endif;?>
								<!-- 5 -->	
								<?php endif;?>
							<!-- 1 -->	
							<?php endif;?>
						<!-- for -->	
						<?php endfor;?>
						<!-- 8b -->
						<?php /*if($intPage > 3 && $booStop == false):?>
						8b<span>...</span>
							<a href="#" idChange='<?php echo $intCountImage;?>' typePage='<?php echo $strType;?>' page='<?php echo $intLimit;?>' class="page">
								<?php echo $intLimit;?>
							</a>
							<a href="#" idChange='<?php echo $intCountImage;?>' typePage='<?php echo $strType;?>' page='<?php echo $intImagePage;?>' class="page">
								<?php echo $intImagePage;?>
							</a>
								<a href="#" idChange='<?php echo $intChange;?>' typePage='<?php echo $strType;?>' page='<?php echo $intPage+1;?>' class="arrow">&gt;</a>
							</a>
						<?endif;*/ ?>	
						<!-- 2 -->
						<?php //if($booStop):?>
							<!-- 13 -->
							<?php if(($intPage ) == ((int) $booPrintNex)):?>
								
								<a href="#" idChange='<?php echo $intImagePage;?>' typePage='<?php echo $strType;?>' page='<?php echo $intImagePage;?>' class="page">
										<?php echo $intImagePage;?>
								</a>
								<?php //echo '1z';?>
							<!-- 13 -->	
							<?php elseif(($intPage - $booPrintNex) == 2):?>
								<?php //echo 13;?>
							<!-- 13 -->
							<?php elseif(($intPage ) > ((int) $booPrintNex)):?>
								
							<!-- 13 -->
							<?php else:?>	
								<!-- 14 -->	
								<?php if(($intPage ) == ((int) $booPrintNex - 1)):?>	
									<a href="#" idChange='<?php echo $intCountImage;?>' typePage='<?php echo $strType;?>' page='<?php echo $intLimit;?>' class="page">
										<?php echo $intLimit;?>
									</a>
									<a href="#" idChange='<?php echo $intCountImage;?>' typePage='<?php echo $strType;?>' page='<?php echo $intImagePage;?>' class="page">
										<?php echo $intImagePage;?>
									</a>
								<!-- 14 -->	
								<?php elseif($intImagePage < $intCountImage & $intImagePage != $intCountImage):?>
									<span>...</span>
									<a href="#" idChange='<?php echo $intCountImage;?>' typePage='<?php echo $strType;?>' page='<?php echo $intLimit;?>' class="page">
										<?php echo $intLimit;?>
									</a>
									<a href="#" idChange='<?php echo $intCountImage;?>' typePage='<?php echo $strType;?>' page='<?php echo $intImagePage;?>' class="page">
										<?php echo $intImagePage;?>
									</a>
									<a href="#" idChange='<?php echo $intChange;?>' typePage='<?php echo $strType;?>' page='<?php echo $intPage+1;?>' class="arrow">&gt;</a>
								<!-- 14 -->
								<?php endif;?>
							<!-- 13 -->	
							<?php endif;?>
						<!-- 2 -->	
						<?php //endif;?>		
				</div>
			</nav>
		<?php endif;?>	
		</div>
    