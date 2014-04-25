<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml' xml:lang='en' lang='en' dir="ltr">
<head>
	<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta http-equiv="ClearType" content="true" />
	
	<meta name='language' content='en' />
	<meta name="keywords" content="" />
	
	<meta property="og:site_name" content="Pulsar Imagens"/>
	<meta property="og:title" content="Pulsar Imagens"/>
	<meta property="og:type" content="website"/>
	<meta property="og:image" content="facebook.png"/>
	<meta property="og:url" content="http://pulsarimagens.com.br"/>
	<meta name="description" content="Banco de imagens do Brasil" />
	<meta name="viewport" content="width=980" />
	<meta name="robots" content="ALL" /> 
	<link rel="dns-prefetch" href="//www.google-analytics.com" />
    <link rel="shortcut icon" href="favicon.ico" />
	
	<!-- blueprint CSS framework -->
	<link rel='stylesheet' type='text/css' href='<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css' media='screen, projection' />
	<link rel='stylesheet' type='text/css' href='<?php echo Yii::app()->request->baseUrl; ?>/css/print.css' media='print' />
	<!--[if lt IE 8]>
	<link rel='stylesheet' type='text/css' href='<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css' media='screen, projection' />
	<![endif]-->
	<link rel='stylesheet' type='text/css' href='<?php echo Yii::app()->request->baseUrl; ?>/css/main.css' />
	<link rel='stylesheet' type='text/css' href='<?php echo Yii::app()->request->baseUrl; ?>/css/form.css' />
	<!-- Css dos designers -->
	<link rel='stylesheet' type='text/css' href='<?php echo Yii::app()->request->baseUrl; ?>/css/fonts.css' />
	<link rel='stylesheet' type='text/css' href='<?php echo Yii::app()->request->baseUrl; ?>/css/style.css' />
	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/search.js');?>
	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/code.js');?>
	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/html5.js');?>
	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jcarousel.js');?>
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>
<body>
<!-- Start page -->
	<!-- Start Templates -->
		<?php echo $content; ?>	
	<!-- End Templates -->
	<!-- Start footer -->
	<footer id="social">
		<div id="root" class="cf">
	    	<div class="social">
	    		<a href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/social-facebook.png" /></a>
	    		<?php //<a href="#"><img src=" echo Yii::app()->request->baseUrl; /images/social-flickr.png" /></a>?>
	    	</div>	
	        <div class="newsletter">
	        	<fieldset>
	            	<h3><?php echo Yii::t('zii', 'Subscribe to newsletter');?></h3>
	                <label><span class="label"><?php echo Yii::t('zii', 'e-mail');?></span>
	                <input type="text"></label>
	                <?php if(Yii::app()->user->getState('strFormType')!='ext') :?>
	                <label>
	                	<select>
	                		<option value="" selected>Editorial</option>
	                	</select>
	                </label>
	                <?php endif;?>
	                <button><?php echo Yii::t('zii', 'Ok');?></button>
	            </fieldset>
	        </div>
		</div>
	</footer>
	<nav id="map">
		<div id="root" class="cf">
			<dl>
	    		<dt><?php echo Yii::t('zii', 'Sessions');?></dt>
	            <dd><a href="#"><?php echo Yii::t('zii', 'Home');?></a></dd>
	            <dd><a href="#"><?php echo Yii::t('zii', 'About Us');?></a></dd>
	            <dd><a href="#"><?php echo Yii::t('zii', 'My Account');?></a></dd>
	            <dd><a href="#"><?php echo Yii::t('zii', 'Quotation');?></a></dd>
	            <dd><a href="#"><?php echo Yii::t('zii', 'Cadastre');?></a></dd>
	            <dd><a href="#"><?php echo Yii::t('zii', 'Advanced search');?></a></dd>
	        </dl>
	    	<dl>
	        	<dt><?php echo Yii::t('zii', 'Sessions');?></dt>
	            <dd><a href="#"><?php echo Yii::t('zii', 'how it works?');?></a></dd>
	            <dd><a href="#"><?php echo Yii::t('zii', 'F.A.Q');?></a></dd>
	            <dd><a href="#"><?php echo Yii::t('zii', 'Contact');?></a></dd>
	        </dl>
	    	<dl class="contato">
	        	<dt><?php echo Yii::t('zii', 'Contact');?></dt>
	            <dd><?php echo Yii::t('zii', '+44 20 3290 9066');?><br/>
					<a href="pulsar@pulsarimagens.com.br"><?php echo Yii::t('zii', 'contact@pulsarimages.com');?></a></dd>
	            <dd><?php echo Yii::t('zii', '2 Queen Caroline St');?> <br/><?php echo Yii::t('zii', 'W6 9DX');?><br/><?php echo Yii::t('zii', 'London - UK');?></dd>
	        </dl>
	    	<dl class="language">
	        	<dt><?php echo Yii::t('zii', 'Choose the language');?></dt>
	                <dd><a href="#"><?php echo Yii::t('zii', 'Portuguese (BR)');?></a></dd>
	                <dd><a href="#"><?php echo Yii::t('zii', 'English');?></a></dd>
	        	</dl>
	    </div>
	</nav>
	<footer id="copyright">
		<div id="root">
			&reg; <?php echo Yii::t('zii', 'Pulsar Images');?> <?php echo date('Y').' - '. Yii::t('zii', 'All Rights Reserved'); ?>.
		</div>
	</footer>
<!-- End footer -->
			
		<!-- End page -->
		<!-- Start ClickTale -->
		<!-- Render time: 3.2934019565582</br>-->
		<script type='text/javascript'>
			document.write(unescape("%3Cscript%20src='"+
			(document.location.protocol=='https:'?
			"https://clicktalecdn.sslcs.cdngc.net/www07/ptc/efdebe89-ebe0-4e26-9eb3-aafab269ca8e.js":
			"http://cdn.clicktale.net/www07/ptc/efdebe89-ebe0-4e26-9eb3-aafab269ca8e.js")+"'%20type='text/javascript'%3E%3C/script%3E"));
		</script>
		<!-- End ClickTale -->
		<!-- Start Analytics -->
		<script type="text/javascript">
			// google analytics
			  var _gaq = _gaq || [];
			  _gaq.push(['_setAccount', 'UA-3064149-1']);
			  _gaq.push(['_trackPageview']);
			
			  (function() {
			    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
			  })();
		</script>
		<!-- Start Analytics -->
</body>
</html>