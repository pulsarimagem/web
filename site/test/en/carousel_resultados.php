<?php 
$show_results = false;
$offset = 40;

/*
if (isset($_GET['search'])) {
	$type_search = $_GET['search'];
}

if($type_search == "mostviewed")
	$show_results = false;
if($type_search == "lastadd")
	$show_results = false;
*/
$resultado_query = "";

if($ordem_foto != -1 && $total_foto != -1 && isset($tombo_array)) {
	$show_results = true;
	$carousel_start = $ordem_foto;// - $offset;
	if($carousel_start < 0)
		$carousel_start = 0;
//	$carousel_start = 0;// - $offset;
	$carousel_end = $ordem_foto + $offset;
	if($carousel_start < 0){
		$carousel_start = 0;
	}
	if($carousel_end > $total_foto){
		$carousel_end = $total_foto;
	}
	for($i = $carousel_start; $i < $carousel_end - 1; $i++) {
		$resultado_query .= "'".$tombo_array[$i]."',";
	}
	$resultado_query .= "'".$tombo_array[$carousel_end-1]."'";

	
	$query_resultados = "
SELECT 
	Fotos.Id_Foto, Fotos.id_autor, 
	Fotos.cidade, Fotos.id_estado, Fotos.id_pais, paises.nome as pais, Estados.Estado, Estados.Sigla, 
	Fotos.assunto_principal, Fotos.orientacao, Fotos.tombo, Fotos.data_foto, 
	fotografos.Nome_Fotografo 
FROM 
	Fotos
LEFT JOIN	
	fotografos 
	ON Fotos.id_autor=fotografos.id_fotografo
LEFT JOIN	
	Estados
	ON Fotos.id_estado=Estados.id_estado
LEFT JOIN	
	paises
	ON paises.id_pais=Fotos.id_pais 
WHERE
	Fotos.tombo in (".$resultado_query.") 
ORDER BY
	FIELD(Fotos.tombo,".$resultado_query.");
";
	$resultados = mysql_query($query_resultados, $pulsar) or die(mysql_error());
	$row_resultados = mysql_fetch_assoc($resultados);
	$totalRows_resultados = mysql_num_rows($resultados);
	
	$query = $_SESSION['ultima_pesquisa_query'];
	
}	
if($show_results) {	
?>
			<h2>Resultados para "<?php echo $query?>"</h2>
			<div class="box" >
 				<ul id="carouselDetails"><!--
<?php 
$i = $carousel_start;
$carousel_list = "var mycarousel_itemList = [
";
do {
	$carousel_list .= "{tombo: \"".$row_resultados['tombo']."\", total_foto: \"".$total_foto."\", ordem_foto: \"".$i."\", assunto_principal: \"".$row_resultados['assunto_principal']."\", data: \"";
if (strlen($row_resultados['data_foto']) == 4) {
	$carousel_list .= ' - '.$row_resultados['data_foto'];
} elseif (strlen($row_resultados['data_foto']) == 6) {
	$carousel_list .= ' - '.substr($row_resultados['data_foto'],4,2).'/'.substr($row_resultados['data_foto'],0,4);
} elseif (strlen($row_resultados['data_foto']) == 8) {
	$carousel_list .=' - '.substr($row_resultados['data_foto'],6,2).'/'.substr($row_resultados['data_foto'],4,2).'/'.substr($row_resultados['data_foto'],0,4);
} 
	$carousel_list .= "\", autor: \"".$row_resultados['Nome_Fotografo']."\"},\n";
	
?>				
<?php 
$i++;
} while ($row_resultados = mysql_fetch_assoc($resultados));?>					-->
					<div class="clear"></div>
				</ul> 
			</div>
<?php 
}
?>
<script>
<?php echo $carousel_list = substr($carousel_list, 0, strlen($carousel_list)-2)."];";?>
jQuery(document).ready(function() {
	jQuery("#carouselDetails").jcarousel({
	    scroll: 1,
        animation : 0,
		start: 0,
		itemLoadCallback: {onBeforeAnimation: mycarousel_itemLoadCallback},
//		setupCallback: mycarousel_initCallback,
//		size: (mycarousel_itemList.length<?php echo "-$scroll_startpos"?>),
		size: mycarousel_itemList.length,
		buttonNextHTML: '<img class="s1b" src="images/carr-s1b.png"></img>',
	    buttonPrevHTML: '<img class="s1a" src="images/carr-s1a.png"></img>'
	});
});

function mycarousel_itemLoadCallback(carousel, state)
{
	var off = 0; //<?php if(isset($scroll_startpos)) echo $scroll_startpos+1; else echo 0;?>;
	for (var i = carousel.first-1; i <= carousel.last + 1; i++) {
        if (carousel.has(i)) {
            continue;
        }
//        alert(mycarousel_itemList.length);
        
        if ((i+off) > mycarousel_itemList.length) {
            break;
        }
//        alert((i+off));
//        alert('load: '+(i) +'   '+mycarousel_itemList[i-1].autor);
        if((i+off)>0) {
        	carousel.add(i, mycarousel_getItemHTML(mycarousel_itemList[i-1+(off)]));
        } else {
//          alert('load i < 0: '+i +'   '+mycarousel_itemList[mycarousel_itemList.length-i-1].autor);            
//      	  carousel.add(i, mycarousel_getItemHTML(mycarousel_itemList[mycarousel_itemList.length-i-1]));
        }
    }
};

/**
 * Item html creation helper.
 */
function mycarousel_getItemHTML(item)
{
    var img_html = '' + 
'<a href="details.php?tombo=' + item.tombo + '&total_foto=' + item.total_foto + '&ordem_foto=' + item.ordem_foto+ '">' +
'	<img src="http://www.pulsarimagens.com.br/bancoImagens/' + item.tombo + 'p.jpg" title="" onMouseover="ddrivetip(' + item.assunto_principal + ' - ' + item.data + ') onMouseout="hideddrivetip()"/>' + 
'	<span><strong>' + item.autor + '</strong></span>' + 
'	<span>' + item.tombo + '</span>' +
'</a>';
	return img_html;
};
</script>