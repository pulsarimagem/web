$(document).ready(function(){
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