$(document).ready(function()
{
	$('.add, .bigger, .config').hide();
	
	$('#on').click(function(){
		$('#on').attr('class','first col checked');
		$('#off').attr('class','col');
		$('.entry .box .bigger .mesa ').show();
		$('.bigger').attr('style', 'margin-top: -9px; display: none;');
		//aplicar aqui a exclusão do jquery da imagem
	});
	
	$('#off').click(function(){
		$('#off').attr('class','col checked');
		$('#on').attr('class','first col');
		$('.entry .box .bigger .mesa ').hide();
		$('.bigger').attr('style', 'margin-top: 110px; display: none;');
		//aplicar aqui a exclusão do jquery da imagem
	});
	
	$('.fotos, .videos').click(function()
	{
		var idChange = $(this).attr('idChange');
		var viewPage = $(this).attr('page');
		var typePage = $(this).attr('typePage');
		
		alert($(this).attr('class')+' dasdbasndbsman '+idChange+' '+viewPage+' '+typePage);
		
		if(typePage == 'image')
		{
			$.post( 'Ajax/ajaxlistingArray',
					{ 
						idChange: idChange, page: viewPage, type: typePage
					},
					function(data)
					{
						$('.container').html(data);
					},
					'',
					function(data)
					{
						$('.entry').html('Error');
					}
			)
		}
		else if(typePage == 'video')
		{
			$.post(	'Ajax/ajaxlistingArrayVideos',
					{ 
						idChange: idChange, page: viewPage, type: typePage
					},
					function(data)
					{
						$('.container').html(data);
					},
					'',
					function(data)
					{
						$('.entry').html('Error');
					}
			)
		}
		
	});
	
	$('.page, .arrow, #50, #100, #150').click(function(){
		var idChange = $(this).attr('idChange');
		var viewPage = $(this).attr('page');
		var typePage = $(this).attr('typepage');
		
		if(typePage == 'image')
		{
			$.post(
					'Ajax/ajaxlistingArray',
					{ 
						idChange: idChange, page: viewPage, type: typePage 
					},
					function(data)
					{
						$('.container').html(data);
					},
					'',
					function(data)
					{
						$('.entry').html('Error');
					}
			)
		}
		else if(typePage == 'video')
		{
			$.post(	'Ajax/ajaxlistingArrayVideos',
					{ 
						idChange: idChange, page: viewPage, type: typePage
					},
					function(data)
					{
						$('.container').html(data);
					},
					'',
					function(data)
					{
						$('.entry').html('Error');
					}
			)
		}
	});
	
	$('#buttonSearch').click(function(){
			if($('#search').val().length < 2)
			{
				return false;
			}	
			else
			{
				return true;
			}
			
		}
	);
});