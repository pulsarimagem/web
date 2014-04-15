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
	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/code.js');?>
	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/html5.js');?>
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
	    		<a href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/social-flickr.png" /></a></div>
	        <div class="newsletter">
	        	<fieldset>
	            	<h3>Assine a newsletter</h3>
	                <label><span class="label">e-mail</span>
	                <input type="text"></label>
	                <label>
	                	<select>
	                		<option value="" selected>Editorial</option></select>
	                </label>
	                <button>Ok</button>
	            </fieldset>
	        </div>
		</div>
	</footer>
	<nav id="map">
		<div id="root" class="cf">
			<dl>
	    		<dt>Sessões</dt>
	            <dd><a href="#">Home</a></dd>
	            <dd><a href="#">Quem somos</a></dd>
	            <dd><a href="#">Minha conta</a></dd>
	            <dd><a href="#">Cotação</a></dd>
	            <dd><a href="#">Cadastro</a></dd>
	            <dd><a href="#">Busca avançada</a></dd>
	        </dl>
	    	<dl>
	        	<dt>Sessões</dt>
	            <dd><a href="#">Como Funciona?</a></dd>
	            <dd><a href="#">Dúvidas</a></dd>
	            <dd><a href="#">Contato</a></dd>
	        </dl>
	    	<dl class="contato">
	        	<dt>Contato</dt>
	            <dd>55 (11) 3875 0101<br/>
					<a href="pulsar@pulsarimagens.com.br">pulsar@pulsarimagens.com.br</a></dd>
	            <dd>Rua Apiacás, 934 <br/>05017-020<br/>São Paulo - SP - Brasil</dd>
	        </dl>
	    	<dl class="language">
	        	<dt>Escolha o idioma</dt>
	                <dd><a href="#">Português (BR)</a></dd>
	                <dd><a href="#">English</a></dd>
	        	</dl>
	    </div>
	</nav>
	<footer id="copyright">
		<div id="root">
			&reg; Pulsar Imagens <?php echo date('Y').' - '. Yii::t('zii', 'All Rights Reserved'); ?>.
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