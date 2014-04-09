<!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js" type="text/javascript"></script> -->
<script src="../js/jquery.js" type="text/javascript"></script>
<script src="../js/jquery.jcarousel.min.js" type="text/javascript"></script>
<script src="../js/jquery.pajinate.min.js" type="text/javascript"></script>
<script src="../js/jquery.hoverIntent.minified.js" type="text/javascript"></script>
<script src="../js/jquery.bgiframe.min.js" type="text/javascript"></script>
<script src="../js/jquery.multiSelect.js" type="text/javascript"></script>
<script src="../js/jquery.blockUI.js" type="text/javascript"></script>
<!-- <script src="../js/sessvars.js" type="text/javascript"></script> -->
<!-- <script src="../js/jquery.stickem.js" type="text/javascript"></script> -->
<link href="../css/jquery.multiSelect.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../video/jwplayer.js"></script>
<!-- <script src="../js/analytics.js"></script> -->
<?php include('google_analytics.php')?>
<script type="text/javascript">
<?php 
if(isset($_GET["popup_msg"])) { 
	$msg = $_GET["popup_msg"];
?>
	alert("<?php echo $msg?>");
<?php 
} 
?>

jQuery(document).ready(function() {
    var s = $("#sticker");
    var pos = s.position();
    $(window).scroll(function() {
        var size = $(".minhasimagens").height();
        size = size * 1.1;
	    var windowpos = $(window).scrollTop();
//	    alert("Size:" + size + "<br />Scroll position: " + windowpos);
//    	alert("Scroll position: " + windowpos);
		if ((windowpos >= 150) && (windowpos <= (size - 350))) {
//		   alert("Distance from top:" + pos.top + "<br />Scroll position: " + windowpos);	    
	    	s.addClass("stick");
		} else {
	    	s.removeClass("stick"); 
//	    	alert("Scroll position: " + windowpos);
		}
	});

//    $('.minhasimagens').stickem();
    	
	var timer;
	var timer_video;
	
	$('.hide_5s').mouseleave(function() {
		clearTimeout(timer);
		timer = setTimeout(function () {
	        $('.hide_5s').hide();
	        $('.clBar').hide();
	        $('.clLevel0').hide();
	        $('.clLevel1border').hide();
		}, 5000);
	});
	$('.clBar').mouseleave(function() {
		clearTimeout(timer);
		timer = setTimeout(function () {
	        $('.hide_5s').hide();
	        $('.clBar').hide();
	        $('.clLevel0').hide();
	        $('.clLevel1border').hide();
		}, 5000);
	});
	$('.clLevel0').mouseleave(function() {
		clearTimeout(timer);
		timer = setTimeout(function () {
	        $('.hide_5s').hide();
	        $('.clBar').hide();
	        $('.clLevel0').hide();
	        $('.clLevel1border').hide();
		}, 5000);
	});
	$('.clLevel1border').mouseleave(function() {
		clearTimeout(timer);
		timer = setTimeout(function () {
	        $('.hide_5s').hide();
	        $('.clBar').hide();
	        $('.clLevel0').hide();
	        $('.clLevel1border').hide();
		}, 5000);
	});

	$('.x-chave-btn').click(function () {
		$id = $(this).attr('id');
		$('#search_'+$id).remove();
		$(this).parent().remove();
		$('#form_block_busca').submit();
	});

	$('#select_data').change(function () {
		$('#form_block_busca').submit();
	});

/*
	var my_options = $("#select_data option");

	my_options.sort(function(a,b) {
	    if (a.text > b.text) return -1;
	    else if (a.text < b.text) return 1;
	    else return 0
	})

	$("#select_data").empty().append( my_options );
*/	
	$('#lang-bt').click(function() {
		$('#lang-open').toggle();
	});

	$('.submit_onclick').click(function (){
		$('#form_block_busca').submit();
	});

	$('.posfilter').click(function(){
		$('#posfilter_opt').val($(this).attr('id'));
		$('#form_block_busca').submit();
	});
	
	$('.multi_select').multiSelect({ selectAllText: '<?php echo SCRIPT_SELECIONAR_TODOS?>', noneSelected: '<?php echo SCRIPT_ESTADO?>', oneOrMoreSelected: '% <?php echo SCRIPT_SELECIONADO?>'});
/*
	var config = {
			over: showMenu,
			timeout: 500,
			out: hideMenu
	};
	
	$(".view-submenu").hoverIntent(config);
	
	  function showMenu () {
			  	var idm = $(this).attr('id');
			  	var aid = idm.split('_');
			  	
					var vh = $(window).height();			
					var vs = $(window).scrollTop();
					var ps = parseInt( (100*vs)/vh );
					var vtop = ( ps > 50 )? '-2px' : ($( '#s_'+aid[1] ).height() - 34) * (-1) + 'px';
					
					$( '#s_'+aid[1] ).css( 'top', vtop );
			    $( '#s_'+aid[1] ).show();

			  };
		function hideMenu() {
				  var idm = $(this).attr('id');
			  	var aid = idm.split('_');
			  		$( '#s_'+aid[1] ).hide();	
			  };
*/			  

	$(".view-submenu").hover(
			  function () {
				  $(this).removeClass('timer_hide');
				  clearTimeout(timer);
				  $('.timer_hide').hide();
				  $('.timer_hide').removeClass('timer_hide');
				  
			  	var idm = $(this).attr('id');
			  	var aid = idm.split('_');
			  	
//					var vh = $(window).height();			
//					var vs = $(window).scrollTop();
//					var ps = parseInt( (100*vs)/vh );
//					var vtop = ( ps > 50 )? '-2px' : ($( '#s_'+aid[1] ).height() - 34) * (-1) + 'px';
//					$( '#s_'+aid[1] ).css( 'top', vtop );
			    $( '#s_'+aid[1] ).show();

			  },
			  function () {
				  var idm = $(this).attr('id');
			  	var aid = idm.split('_');
//			  		$( '#s_'+aid[1] ).hide();
					$( '#s_'+aid[1] ).addClass('timer_hide');
					timer = setTimeout(function () {
						$( '#s_'+aid[1] ).hide();
					}, 2000);
			  }
	);
	$(".view-submenu-video").hover(
		  function () {
			  $(this).removeClass('timer_hide_video');
			  clearTimeout(timer_video);
			  $('.timer_hide_video').hide();
			  $('.timer_hide_video').removeClass('timer_hide_video');
			  
		  	var idm = $(this).attr('id');
		  	var aid = idm.split('_');
		  	
//				var vh = $(window).height();			
//				var vs = $(window).scrollTop();
//				var ps = parseInt( (100*vs)/vh );
//				var vtop = ( ps > 50 )? '-2px' : ($( '#s_'+aid[1] ).height() - 34) * (-1) + 'px';
//				$( '#s_'+aid[1] ).css( 'top', vtop );
		    $( '#sv_'+aid[1] ).show();

		  },
		  function () {
			  var idm = $(this).attr('id');
		  	var aid = idm.split('_');
//		  		$( '#s_'+aid[1] ).hide();
				$( '#sv_'+aid[1] ).addClass('timer_hide_video');
				timer = setTimeout(function () {
					$( '#sv_'+aid[1] ).hide();
				}, 2000);
		  }
	);
	
    jQuery("#carouselA").jcarousel({
        scroll: 1,
        wrap: 'circular',
        animation : 0,
        buttonNextHTML: '<img class="s1b" src="images/carr-s1b.png"></img>',
	    buttonPrevHTML: '<img class="s1a" src="images/carr-s1a.png"></img>'
    });
    jQuery("#carouselB").jcarousel({
        scroll: 1,
        wrap: 'circular',
        animation : 0,
        buttonNextHTML: '<img class="s1b" src="images/carr-s1b.png"></img>',
	    buttonPrevHTML: '<img class="s1a" src="images/carr-s1a.png"></img>'
    });
    jQuery("#carouselC").jcarousel({
        scroll: 1,
        wrap: 'circular',
        animation : 0,
        buttonNextHTML: '<img class="s1b" src="images/carr-s1b.png"></img>',
	    buttonPrevHTML: '<img class="s1a" src="images/carr-s1a.png"></img>'
    });
    jQuery("#carouselD").jcarousel({
        scroll: 1,
        wrap: 'circular',
        animation : 0,
        buttonNextHTML: '<img class="s1b" src="images/carr-s1b.png"></img>',
	    buttonPrevHTML: '<img class="s1a" src="images/carr-s1a.png"></img>'
    });
    jQuery('#chkNovaPasta').click(function(){
    	jQuery('#novapasta').toggle();
    });
    jQuery('.add_pasta').click(function(){
    	jQuery('.form').toggle();
    });
    jQuery('.add_mesa').click(function(){
    	$.get(this.href);
    	$(this).css("color", "#bc690f"); 
    	alert('<?php echo SCRIPT_IMAGEM_ADD?>');
    });
    jQuery('.edicao_aprovar').click(function(){
    	$.get(this.href);
    	$(this).css("color", "#bc690f"); 
//    	alert('Video aprovado. Aperte Finalizar quando terminar.');
		$(this).parent().parent().parent().parent().parent().parent().children('a').addClass("approved");
		$(this).parent().parent().parent().parent().parent().parent().children('a').removeClass("rejected");
    });
    jQuery('.edicao_recusar').click(function(){
    	$.get(this.href);
    	$(this).css("color", "#bc690f"); 
//    	alert('Video recusado! Aperte Finalizar quando terminar.');
		$(this).parent().parent().parent().parent().parent().parent().children('a').addClass("rejected");
		$(this).parent().parent().parent().parent().parent().parent().children('a').removeClass("approved");
    });
    
    $('#select_autor').keypress(function(e){
        if(e.which == 13){
    	     $('#form_buscaimagens').submit();
        }
    });
});

jQuery(document).ready(function() {
	var timer_lampada;
//	$("ul#lista-script li div.bt-mesadeluz").hover(
//		function () {
//			$(this).children("a.icon").addClass("icon-hover");
//			$(this).children("div.box").show();
			
//		},
//		function () {
//			$(this).children("a.icon").removeClass("icon-hover");
//			$(this).children("div.box").hide();
//		}
//	);
	$("ul#lista-script li div.bt-mesadeluz a.icon").click(function(){
		$(this).parent().children("div.box").toggle();
		clearTimeout(timer_lampada);
		timer_lampada = setTimeout(function () {
	        $('ul#lista-script li div.bt-mesadeluz div.box').hide();
		}, 5000);
		$('ul#lista-script li div.bt-mesadeluz div.box').mouseenter(function() {
			clearTimeout(timer_lampada);
		});
		$('ul#lista-script li div.bt-mesadeluz div.box').mouseleave(function() {
			timer_lampada = setTimeout(function () {
		        $('ul#lista-script li div.bt-mesadeluz div.box').hide();
			}, 5000);
		});
	});
	$("ul#lista-script li div.bt-zoom").hover(
		function () {
			$(this).children("div.mzoom").show();
			var $img = $(this).find("img");
			if($img.attr('class') == 'on-demand') {
				$img.attr('src',$img.attr('longdesc')).removeClass('on-demand');
			}
			var $jwp = $(this).children("div.mzoom").children("div");
			var $jwp_id = $jwp.attr('id').split('_')[0];
			jwplayer($jwp_id).play(true);
		},
		function () {
			$(this).children("div.mzoom").hide();
			var $jwp = $(this).children("div.mzoom").children("div");
			var $jwp_id = $jwp.attr('id').split('_')[0];
			jwplayer($jwp_id).stop(true);
		}
	);
});

$(document).ready(function() {

	$('#newsletter_email_clear').show();
	$('#newsletter_email').hide();

	$('#newsletter_email_clear').focus(function() {
		$('#newsletter_email_clear').hide();
		$('#newsletter_email').show();
		$('#newsletter_email').focus();
	});
	$('#newsletter_email').blur(function() {
		if($('#newsletter_email').val() == '') {
			$('#newsletter_email_clear').show();
			$('#newsletter_email').hide();
		}
	});

	$('.default-value').each(function() {
		var default_value = this.value;
		$(this).focus(function() {
			if(this.value == default_value) {
				this.value = '';
			}
		});
		$(this).blur(function() {
			if(this.value == '') {
				this.value = default_value;
			}
		});
	});

});

$(document).ready(function() {
  	var item1 = $('#buscaTopo .opcoes input[type="checkbox"]').eq(0);
  	var item2 = $('#buscaTopo .opcoes input[type="checkbox"]').eq(1);
	if ((item1.is(':checked') && item2.is(':checked')) || (!item1.is(':checked') && !item2.is(':checked'))) {
        $('.default_value').html('<?php echo SCRIPT_TODOS?>');
    }
    else {
        $('.default_value').html($('#buscaTopo .opcoes input[type="checkbox"]:checked').attr('title'));
    } 
    
  $('#buscaTopo .opcoes input[type="checkbox"]').click(function() {
    var item1 = $('#buscaTopo .opcoes input[type="checkbox"]').eq(0);
    var item2 = $('#buscaTopo .opcoes input[type="checkbox"]').eq(1);
    if ((item1.is(':checked') && item2.is(':checked')) || (!item1.is(':checked') && !item2.is(':checked'))) {
      $('.default_value').html('<?php echo SCRIPT_TODOS?>');
    } 
    else {
      $('.default_value').html($('#buscaTopo .opcoes input[type="checkbox"]:checked').attr('title'));
    }
  });

  	$('#buscaTopo').submit(function() {
  	  	$.blockUI({message: '<h3><?php echo SCRIPT_BLOCKER?></h3>',
			overlayCSS: { backgroundColor: '#999' },
			css: {
			border: 'none',
			padding: '15px', 
            backgroundColor: '#000', 
            '-webkit-border-radius': '10px', 
            '-moz-border-radius': '10px', 
            opacity: .8, 
            color: '#fff' 
			}});
	});
  
  $(".header .nossos-temas .superSelect").click(function() {
    $(this).find('.content').toggle();
  });
  var submenu_config = {    
     over: function(){
//         $('.mostrar').hide();
//         $('.mostrar').removeClass('mostrar');
    	 $(this).find(' > ul').show();
//         $(this).find(' > ul').addClass('mostrar');
     	}, // function = onMouseOver callback (REQUIRED)    
     timeout: 2000, // number = milliseconds delay before onMouseOut    
     out: function(){
         $(this).find(' > ul').hide(); 
        } // function = onMouseOut callback (REQUIRED)    
  };
//  $(".header .nossos-temas li").hoverIntent( submenu_config );


});





var RecaptchaOptions = {
<?php if($lingua == "br") { ?>
	custom_translations : {
    	instructions_visual : "Escreva as duas palavras:",
    	instructions_audio : "Transcreva o que você ouvir:",
    	play_again : "Tocar novamente",
        cant_hear_this : "Baixar audio em formato MP3",
        visual_challenge : "Modalidade visual",
        audio_challenge : "Modalidade auditiva",
        refresh_btn : "Trocar por palavras novas",
        help_btn : "Ajuda",
        incorrect_try_again : "Incorreto, tente novamente.",
	},
	lang : 'pt',
<?php } else { ?>
	lang : 'en',
<?php } ?>
	theme : 'clean',
};
/*
 * 
 $(document).ready(function() {
		$("#tipo_proj").change(function()	{
			var id=$(this).val();
			var dataString = 'action=distribuicao&contrato=<?php echo isset($contrato)?$contrato:"F"?>&id_projeto='+ id;

			$.ajax({
				type: "POST",
				url: "../tool_ajax.php",
				data: dataString,
				cache: false,
				success: function(html) {
					$("#uso").html(html);
					$(".tamanho").html('<option value="">--- Escolha um uso primeiro ---</option>');
				} 
			});
		});
		$("#uso").change(function()	{
			var id=$(this).val();
			var dataString = 'action=tamanho&contrato=<?php echo isset($contrato)?$contrato:"F"?>&id_uso='+ id;

			$.ajax({
				type: "POST",
				url: "../tool_ajax.php",
				data: dataString,
				cache: false,
				success: function(html) {
					$(".tamanho").html(html);
				} 
			});
		});
		
		$("#uso_video").change(function()	{
			var id=$(this).val();
			var dataString = 'action=tamanho&contrato=<?php echo isset($contrato)?$contrato:"V"?>&id_uso='+ id;

			$.ajax({
				type: "POST",
				url: "../tool_ajax.php",
				data: dataString,
				cache: false,
				success: function(html) {
					$(".tamanho").html(html);
				} 
			});
		});
	});
	 
 */

//JavaScript Document

$(document).ready(function() {
	//finaliza o carrinho
	$("a.finalizar-compra").live('click',function(){
		document.location ="carrinho-concluido.php";
		return false;
	});
	
	// botao bloqueia carrinho
	$("a.bloq-compra").live('click',function(){
		alert("<?php echo CARRINHO_BLOQ_COMPRA_BTN?>");
		return false;
	});
	
	// botao continuar comprando
	$("a.continuar-comprando").live('click',function(){
		document.location='buscaavancada.php';
		return false;
	});

	// botao cadastro usuario
	$("input.cadastrouser").live('click',function(){
		document.location='cadastro.php';
		return false;
	});
});		
 

</script>
<?php if(isset($add_script)) echo $add_script;?>