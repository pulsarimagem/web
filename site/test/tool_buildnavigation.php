<?php 
function buildNavigation($actual, $maxRows_retorno, $totalRows_query, $display_qty = 3, $separator = " ... ") {
    $pagesArray = ""; $firstArray = ""; $lastArray = ""; $debug = "";
    
    $pages_qty = ceil($totalRows_query / $maxRows_retorno);
    
    $_get_vars = '';			
	if(!empty($_GET) || !empty($HTTP_GET_VARS)){
		$_GET = empty($_GET) ? $HTTP_GET_VARS : $_GET;
		foreach ($_GET as $_get_name => $_get_value) {
			if ($_get_name != "pageNum_retorno" && $_get_name != "startRow_retorno") {
				if(is_array($_get_value )) {
					foreach ($_get_value as $get_val_arr => $val_arr) {
						$_get_vars .= "&".$_get_name."[]=".stripslashes($val_arr);
					}
				} else {
					$_get_vars .= "&$_get_name=".stripslashes($_get_value);
				}
			}
		}
	}
	
	$debug .= "Start $totalRows_query / $maxRows_retorno = $pages_qty! ";
    if($pages_qty > 1) {
	    if($actual > 0) {
	    	$precedente = $actual - 1;
	    	$firstArray = "<a href=\"$_SERVER[PHP_SELF]?pageNum_retorno=$precedente$_get_vars\" class=\"ant\">« ".BUILDNAV_ANTERIOR."</a>";
			$debug .= "First! ";
	    }
	    else {
	    	$firstArray = "<a href=\"#\" class=\"ant\"></a>";
	    }
	    
	    if ($actual < $pages_qty-1) {
	    	$successivo = $actual + 1;
	    	$lastArray = "<a href=\"$_SERVER[PHP_SELF]?pageNum_retorno=$successivo$_get_vars\" class=\"pro\">".BUILDNAV_PROXIMA." »</a>";
			$debug .= "Last! ";
	    }
	    else {
	    	$lastArray = "<a href=\"#\" class=\"pro\"></a>";
	    }

	    $debug .= "Middle! ";
	    $sep = false;
	    for($a = 0; $a < $pages_qty; $a++) {
			$debug .= "it $a! ";
	    	if($a == 0) {
	    		if($a ==  $actual)
					$pagesArray .= "<div class=\"pag\"><a href=\"$_SERVER[PHP_SELF]?pageNum_retorno=$a$_get_vars\" class=\"nav_page_num\" id=\"nav_page-$a\"><strong>1</strong></a>";
				else 
					$pagesArray .= "<div class=\"pag\"><a href=\"$_SERVER[PHP_SELF]?pageNum_retorno=$a$_get_vars\" class=\"nav_page_num\" id=\"nav_page-$a\">1</a>";
	    	}
	    	else if(($a < $display_qty + 2) && $actual < $display_qty) {
				$page = $a + 1;
	    		if($a ==  $actual)
					$pagesArray .= "<a href=\"$_SERVER[PHP_SELF]?pageNum_retorno=$a$_get_vars\" class=\"nav_page_num\" id=\"nav_page-$a\"><strong>$page</strong></a>";
	    		else 
					$pagesArray .= "<a href=\"$_SERVER[PHP_SELF]?pageNum_retorno=$a$_get_vars\" class=\"nav_page_num\" id=\"nav_page-$a\">$page</a>";
			}
	    	else if(($a > $pages_qty - $display_qty - 3) && ($actual > $pages_qty - $display_qty - 3)) {
				$page = $a + 1;
	    		if($a ==  $actual)
					$pagesArray .= "<a href=\"$_SERVER[PHP_SELF]?pageNum_retorno=$a$_get_vars\" class=\"nav_page_num\" id=\"nav_page-$a\"><strong>$page</strong></a>";
	    		else 
					$pagesArray .= "<a href=\"$_SERVER[PHP_SELF]?pageNum_retorno=$a$_get_vars\" class=\"nav_page_num\" id=\"nav_page-$a\">$page</a>";
			}
			else if($a == $pages_qty - 1){
				$page = $a + 1;
	    		if($a ==  $actual)
					$pagesArray .= "<a href=\"$_SERVER[PHP_SELF]?pageNum_retorno=$a$_get_vars\" class=\"nav_page_num\" id=\"nav_page-$a\"><strong>$page</strong></a>";
	    		else 
					$pagesArray .= "<a href=\"$_SERVER[PHP_SELF]?pageNum_retorno=$a$_get_vars\" class=\"nav_page_num\" id=\"nav_page-$a\">$page</a>";
			}	 
			else if(($a > $actual - $display_qty) && ($a < $actual + $display_qty)) {
				$sep = false;
				$page = $a + 1;
	    		if($a ==  $actual)
					$pagesArray .= "<a href=\"$_SERVER[PHP_SELF]?pageNum_retorno=$a$_get_vars\" class=\"nav_page_num\" id=\"nav_page-$a\"><strong>$page</strong></a>";
	    		else 
					$pagesArray .= "<a href=\"$_SERVER[PHP_SELF]?pageNum_retorno=$a$_get_vars\" class=\"nav_page_num\" id=\"nav_page-$a\">$page</a>";
			}
			else if(!$sep) {
				$pagesArray .= " <span>...</span> ";
				$sep = true;
			}
	    }
    }
    else {
	    	$firstArray = "<a href=\"#\" class=\"ant\"></a>";
	    	$lastArray = "<a href=\"#\" class=\"pro\"></a>";
			$pagesArray = "<div class=\"pag\"><a href=\"#\"></a>";
	    	
    }
    $pagesArray .= "</div>";
    
    return array($firstArray,$pagesArray,$lastArray,$debug);
}









function buildNavigation2($pageNum_Recordset1,$totalPages_Recordset1,$prev_Recordset1,$next_Recordset1,$separator=" | ",$max_links=10, $show_page=true)
{
    GLOBAL $maxRows_retorno,$totalRows_retorno;
	$pagesArray = ""; $firstArray = ""; $lastArray = "";
	if($max_links<2)$max_links=2;
	if($pageNum_Recordset1<=$totalPages_Recordset1 && $pageNum_Recordset1>=0)
	{
		if ($pageNum_Recordset1 > ceil($max_links/2))
		{
			$fgp = $pageNum_Recordset1 - ceil($max_links/2) > 0 ? $pageNum_Recordset1 - ceil($max_links/2) : 1;
			$egp = $pageNum_Recordset1 + ceil($max_links/2);
			if ($egp >= $totalPages_Recordset1)
			{
				$egp = $totalPages_Recordset1+1;
				$fgp = $totalPages_Recordset1 - ($max_links-1) > 0 ? $totalPages_Recordset1  - ($max_links-1) : 1;
			}
		}
		else {
			$fgp = 0;
			$egp = $totalPages_Recordset1 >= $max_links ? $max_links : $totalPages_Recordset1+1;
		}
		if($totalPages_Recordset1 >= 1) {
			$_get_vars = '';			
			if(!empty($_GET) || !empty($HTTP_GET_VARS)){
				$_GET = empty($_GET) ? $HTTP_GET_VARS : $_GET;
				foreach ($_GET as $_get_name => $_get_value) {
					if ($_get_name != "pageNum_retorno") {
						$_get_vars .= "&$_get_name=$_get_value";
					}
				}
			}
			$successivo = $pageNum_Recordset1+1;
			$precedente = $pageNum_Recordset1-1;
			$firstArray = ($pageNum_Recordset1 > 0) ? "<a href=\"$_SERVER[PHP_SELF]?pageNum_retorno=$precedente$_get_vars\">$prev_Recordset1</a>" :  "$prev_Recordset1";
			for($a = $fgp+1; $a <= $egp; $a++){
				$theNext = $a-1;
				if($show_page)
				{
					$textLink = $a;
				} else {
					$min_l = (($a-1)*$maxRows_retorno) + 1;
					$max_l = ($a*$maxRows_retorno >= $totalRows_retorno) ? $totalRows_retorno : ($a*$maxRows_retorno);
					$textLink = "$min_l - $max_l";
				}
				$_ss_k = floor($theNext/26);
				if ($theNext != $pageNum_Recordset1)
				{
					$pagesArray .= "<a href=\"$_SERVER[PHP_SELF]?pageNum_retorno=$theNext$_get_vars\" class=\"retorno\">";
					$pagesArray .= "$textLink</a>" . ($theNext < $egp-1 ? $separator : "");
				} else {
					if ($pageNum_Recordset1<9) {
						$pagesArray .= "<span class=\"retornosemlink\">$textLink</span>"  . ($theNext < $egp-1 ? $separator : "");
					} else {
						$pagesArray .= "<span class=\"retornosemlink2\">$textLink</span>"  . ($theNext < $egp-1 ? $separator : "");
					}
				}
			}
			$theNext = $pageNum_Recordset1+1;
			$offset_end = $totalPages_Recordset1;
			$lastArray = ($pageNum_Recordset1 < $totalPages_Recordset1) ? "<a href=\"$_SERVER[PHP_SELF]?pageNum_retorno=$successivo$_get_vars\">$next_Recordset1</a>" : "$next_Recordset1";
		}
	}
	return array($firstArray,$pagesArray,$lastArray);
}
?>