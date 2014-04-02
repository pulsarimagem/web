<!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js" type="text/javascript"></script> -->
<script src="jquery.min.js" type="text/javascript"></script>
<script src="jquery.jcarousel.min.js" type="text/javascript"></script>
<script src="jquery.pajinate.min.js" type="text/javascript"></script>
<script src="jquery.hoverIntent.minified.js" type="text/javascript"></script>
<script src="./js/jquery.bgiframe.min.js" type="text/javascript"></script>
<script src="./js/jquery.multiSelect.js" type="text/javascript"></script>
<link href="./css/jquery.multiSelect.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="video/jwplayer.js"></script>
<?php include('google_analytics.php')?>
<script type="text/javascript">
jQuery(document).ready(function() {
	var timer;
/*	
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
*/	
	
	$('#lang-bt').click(function() {
		$('#lang-open').toggle();
	});

//	$('.multi_select').multiSelect({ selectAllText: 'Selecionar Todos', noneSelected: 'Estado', oneOrMoreSelected: '% selecionados'});
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
			  	var idm = $(this).attr('id');
			  	var aid = idm.split('_');
			  	
					var vh = $(window).height();			
					var vs = $(window).scrollTop();
					var ps = parseInt( (100*vs)/vh );
					var vtop = ( ps > 50 )? '-2px' : ($( '#s_'+aid[1] ).height() - 34) * (-1) + 'px';
					$( '#s_'+aid[1] ).css( 'top', vtop );
			    $( '#s_'+aid[1] ).show();

			  },
			  function () {
				  var idm = $(this).attr('id');
			  	var aid = idm.split('_');
			  		$( '#s_'+aid[1] ).hide();	
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
    	alert('Imagem Adicionada na Pasta.');
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
	$("ul#lista-script li div.bt-mesadeluz").hover(
		function () {
			$(this).children("a.icon").addClass("icon-hover");
			$(this).children("div.box").show();
			
		},
		function () {
			$(this).children("a.icon").removeClass("icon-hover");
			$(this).children("div.box").hide();
		}
	);
	$("ul#lista-script li div.bt-zoom").hover(
		function () {
			$(this).children("div.mzoom").show();
			var $img = $(this).find("img");
			if($img.attr('class') == 'on-demand') {
				$img.attr('src',$img.attr('longdesc')).removeClass('on-demand');
			}
		},
		function () {
			$(this).children("div.mzoom").hide();
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
	$("#uso").change(function()	{
		var id=$(this).val();
		var dataString = 'action=tamanho&id_uso='+ id;

		$.ajax({
			type: "POST",
			url: "tool_ajax.php",
			data: dataString,
			cache: false,
			success: function(html) {
				$(".tamanho").html(html);
			} 
		});
	});
});





$(document).ready(function() {
  $('#buscaTopo .opcoes input[type="checkbox"]').click(function() {
    var item1 = $('#buscaTopo .opcoes input[type="checkbox"]').eq(0);
    var item2 = $('#buscaTopo .opcoes input[type="checkbox"]').eq(1);
    if ((item1.is(':checked') && item2.is(':checked')) || (!item1.is(':checked') && !item2.is(':checked'))) {
      $('.default_value').html('Todos');
    } 
    else {
      $('.default_value').html($('#buscaTopo .opcoes input[type="checkbox"]:checked').attr('title'));
    }
  });
});





var RecaptchaOptions = {
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
	theme : 'clean',
};
</script>
<?php if(isset($add_script)) echo $add_script;?>