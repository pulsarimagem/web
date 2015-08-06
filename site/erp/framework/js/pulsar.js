$(document).ready(function(){

	
	
	// === Sidebar navigation === //
	
	$('.submenu > a').click(function(e)
	{
		e.preventDefault();
		var submenu = $(this).siblings('ul');
		var li = $(this).parents('li');
		var submenus = $('#sidebar li.submenu ul');
		var submenus_parents = $('#sidebar li.submenu');
		if(li.hasClass('open'))
		{
			if(($(window).width() > 768) || ($(window).width() < 479)) {
				submenu.slideUp();
			} else {
				submenu.fadeOut(250);
			}
			li.removeClass('open');
		} else 
		{
			if(($(window).width() > 768) || ($(window).width() < 479)) {
				submenus.slideUp();			
				submenu.slideDown();
			} else {
				submenus.fadeOut(250);			
				submenu.fadeIn(250);
			}
			submenus_parents.removeClass('open');		
			li.addClass('open');	
		}
	});
	
	var ul = $('#sidebar > ul');
	
	$('#sidebar > a').click(function(e)
	{
		e.preventDefault();
		var sidebar = $('#sidebar');
		if(sidebar.hasClass('open'))
		{
			sidebar.removeClass('open');
			ul.slideUp(250);
		} else 
		{
			sidebar.addClass('open');
			ul.slideDown(250);
		}
	});
	
	// === Resize window related === //
	$(window).resize(function()
	{
		if($(window).width() > 479)
		{
			ul.css({'display':'block'});	
			$('#content-header .btn-group').css({width:'auto'});		
		}
		if($(window).width() < 479)
		{
			ul.css({'display':'none'});
			fix_position();
		}
		if($(window).width() > 768)
		{
			$('#user-nav > ul').css({width:'auto',margin:'0'});
		}
	});
	
	if($(window).width() < 468)
	{
		ul.css({'display':'none'});
		fix_position();
	}
	if($(window).width() > 479)
	{
		ul.css({'display':'block'});
	}
	
	// === Tooltips === //
	$('.tip').tooltip();	
	$('.tip-left').tooltip({ placement: 'left' });	
	$('.tip-right').tooltip({ placement: 'right' });	
	$('.tip-top').tooltip({ placement: 'top' });	
	$('.tip-bottom').tooltip({ placement: 'bottom' });	
	
	// === Search input typeahead === //
	$('#search input[type=text]').typeahead({
		source: ['Dashboard','Form elements','Common Elements','Validation','Wizard','Buttons','Icons','Interface elements','Support','Calendar','Gallery','Reports','Charts','Graphs','Widgets'],
		items: 4
	});
	
	// === Fixes the position of buttons group in content header and top user navigation === //
	function fix_position()
	{
		var uwidth = $('#user-nav > ul').width();
		$('#user-nav > ul').css({width:uwidth,'margin-left':'-' + uwidth / 2 + 'px'});
	}
	
	// === Style switcher === //

	$('#style-switcher i').click(function()
	{
		if($(this).hasClass('open'))
		{
			$(this).parent().animate({marginRight:'-=190'});
			$(this).removeClass('open');
		} else 
		{
			$(this).parent().animate({marginRight:'+=190'});
			$(this).addClass('open');
		}
		$(this).toggleClass('icon-arrow-left');
		$(this).toggleClass('icon-arrow-right');
	});
	
	$('#showBaixaLoteEsconder').click(function(){
		
		$('#showBaixaLoteShow').hide();
	});
	
	$('.checkBaixa').click(function(){
		var floAddTotal = $(this).attr('id');
		var floSumTotal = $('.sum_total').attr('val');
		var booChecked = $(this).attr("checked")
		var strLincencas = null;
		
		if(booChecked=="checked")
		{	
			floNewTotal = parseInt(floSumTotal.replace(',','.')) + parseInt(floAddTotal.replace(',','.'));
			strLincencas = $(this).attr('value') +', '+$('.sum_total').attr('lic');
		}
		else
		{
			floNewTotal = parseInt(floSumTotal.replace(',','.')) - parseInt(floAddTotal.replace(',','.'));
			strLincencas = $('.sum_total').attr('lic').replace($(this).attr('value') +', ', '');
		}
		$('.sum_total').attr('val',floNewTotal);
		$('.sum_total').attr('lic',strLincencas);
		
	});
	
	
	$('#alertBaixarLote').click(function(){
		
		var intTotal = $('.sum_total').attr('val');
		var strLr = $('#nf').val();
		var strDate = $('.input-small').attr('value');
		var strLicencas = $('.sum_total').attr('lic');
		
		if(confirm('Total: R$ '+intTotal+',00 LR: '+strLr+', Data: '+strDate+', Licenças: '+strLicencas))
		{
			return true;
		}
		else
		{
			return false;
		}	
			
	});
	/*
	$('.reusoAll').click(function(){
		alert(1);
		if($(this).attr('checked') == 'checked')
		{
			$('.reuso').attr('checked','checked');
		}
		else
		{
			$('.reuso').attr('checked','');
		}
	});
	*/
	
});
