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
<!-- Start header -->
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
	<!-- <p>Veja também: <a href="#">Amazônia</a>   /   <a href="#">Desmatamento</a>   /   <a href="#">Erosão</a>   /   <a href="#">Desmatamento</a>   /   <a href="#">Erosão</a>   /   <a href="#">Desmatamento</a>   /   <a href="#">Erosão</a>   /   <a href="#">Desmatamento</a>   /   <a href="#">Erosão</a></p> --> 
</header>
<header id="header">
	<div id="root" class="cf">
        <div class="pulsarimagens">
        	<img src="images/logo.png" /></div>
        <nav class="menu">
            <ul>
                <li class="t"><a href="#">Temas <span>▼</span></a></li>
                <li class="m"><a href="#">Como Funciona?</a></li>
                <li class="m"><a href="#">Login</a></li>
                <li class="m"><a href="#">Registrar-se</a></li>
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
<section id="big-search" style="background-image: url(images/home/<?php echo $strImageRandon;?>.jpg)">	
    	<div class="mask">
            <div class="search">
                <input type="text" placeholder="O que você procura? (palavra-chave ou código)"><button>Buscar</button>
                <p><a href="#">busca avançada</a></p>
            </div>
        </div>
	</section>
	
		<section id="slider-bar">
    	<div class="title"><div id="root">
        	<h2>Adicionadas recentemente</h2>
        </div></div>
        <div class="carousel">
        	<div class="overflow">
                <ul>
                <?php foreach ($arrAddedLastCarousel as $strValue):?>
                    <li>
                    	<?php if(ctype_alpha(substr($strValue['tombo'], 0,1))) :?>
                    		<a href="#"><img src="http://177.71.182.64/Videos/thumbs/<?php echo $strValue['tombo'];?>_3s.jpg"></a>
                    	<?php else:?>
                        	<a href="#"><img src="http://www.pulsarimagens.com.br/bancoImagens/<?php echo $strValue['tombo'];?>p.jpg"></a>
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
        	<h2>Ultimas Pesquisas</h2>
        </div></div>
        <div class="carousel">
        	<div class="overflow">
                <ul>
                	<?php foreach ($arrlatestCarouselSearch as $strValue):?>
                    <li>
                    	<?php if(ctype_alpha(substr($strValue['tombo'], 0,1))) :?>
                    		<a href="#"><img src="http://177.71.182.64/Videos/thumbs/<?php echo $strValue['tombo'];?>_3s.jpg"></a>
                    	<?php else:?>
                        	<a href="#"><img src="http://www.pulsarimagens.com.br/bancoImagens/<?php echo $strValue['tombo'];?>p.jpg"></a>
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
	            <h2>Sobre o Pulsar</h2>
	            <p>Nós somos um banco de imagens que reúne a produção fotográfica de mais de quarenta fotógrafos, com sólidas carreiras individuais, e preocupados em documentar nosso país, seus habitantes, costumes e cultura, sua produção econômica, fauna, flora e toda sua imensa extensão territorial.</p>
	        </article>
		</div>
	</footer>