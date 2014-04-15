$(function(){
	$('#duvidas dt').click(function(){
		$('#duvidas dt').removeClass('open');
		$('#duvidas dd').hide();
		$(this).addClass('open');
		$(this).next('dd').show();
	});
	
	
	$('#internal .l .box').click(function(){
		if($(this).children('p:nth-child(2)').is(':visible')) {
			$(this).children('p:nth-child(2)').hide();
		} else {
			$(this).children('p:nth-child(2)').show();
		}
	});
	$('#header .l .box').click(function(){
		if($(this).children('p:nth-child(2)').is(':visible')) {
			$(this).children('p:nth-child(2)').hide();
		} else {
			$(this).children('p:nth-child(2)').show();
		}
	});
	
	$('#internal .c button').click(function(){
		if($(this).next('.config').is(':visible')) {
			$(this).next('.config').hide();
		} else {
			$(this).next('.config').show();
		}
	});
	
	$('#header .t a').click(function(){
		if($('#temas').is(':visible')) {
			$('#header .t a span').html('▼');
			$('#temas').slideUp();
		} else {
			$('#header .t a span').html('▲');
			$('#temas').slideDown();
		}
		return false;
	});
	$('#internal .t a').click(function(){
		if($('#temas').is(':visible')) {
			$('#header .t a span').html('▼');
			$('#temas').slideUp();
		} else {
			$('#header .t a span').html('▲');
			$('#temas').slideDown();
		}
		return false;
	});
	
	$('#content-details .tamanhos table tr').click(function(){
		$('#content-details .tamanhos table tr').removeClass('checked');
		$(this).addClass('checked');
	});
	
	$('#content-details .buttons .download').click(function(){
		if($(this).next('.submenu').is(':visible')) {
			$(this).next('.submenu').hide();
		} else {
			$(this).next('.submenu').show();
		}
		return false;
	});
	
	$('#lightbox-details .navigation .filter button').click(function(){
		if($(this).next('.config').is(':visible')) {
			$(this).next('.config').hide();
		} else {
			$(this).next('.config').show();
		}
	});
	$('#lightbox-details .entry .box .buttons .adicionar').click(function(){
		if($(this).next('.add').is(':visible')) {
			$(this).next('.add').hide();
		} else {
			$(this).next('.add').show();
		}
	});
	
	
	$('#lightbox-details .entry .box .embed img').click(function(){
		if($(this).parents('.embed').next('.bigger').is(':visible')) {
			$(this).parents('.embed').next('.bigger').hide();
		} else {
			$('#lightbox-details .entry .box .bigger').hide();
			$(this).parents('.embed').next('.bigger').show();
		}
	});
	
	$('#signup .col .choose .radio').click(function(){
		var value = $(this).attr('value');
		$('#default-form .type-register').hide();
		$('#default-form .'+value).show();
	});
	
	
	
});