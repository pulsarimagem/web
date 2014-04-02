<?php
 
   //-------------------------------------------------------------------------
   // Get a listing of all the first-level products. Their parent level is set
   // to zero (0).
   //-------------------------------------------------------------------------
//   $productsFirstLevel = mysql_query("SELECT id, productName, price FROM mockProducts WHERE parent=0 ORDER BY productName");
//$row_temas = mysql_fetch_assoc($temas);
//$totalRows_temas = mysql_num_rows($temas);
   
   //-------------------------------------------------------
   // Construct the HTML for the multi-level unordered list.
   //-------------------------------------------------------
   function constructTree($query, $table, &$html, $pulsar, $idioma, $prefix, $tema2 = 0) {
   	  $k = 1;
      while ($row_temas = mysql_fetch_assoc($query))
      {
        $nextQuery = mysql_query("SELECT Id,Tema$idioma as Tema, Pai FROM $table where Pai = ".$row_temas['Id']." ORDER BY Pai,Tema ASC");
        
        if (mysql_num_rows($nextQuery) > 0) {
        	$html .= "
						<li id=\"mn_$prefix-$k\" class=\"view-submenu\" >        					
	        				<a href=\"listing.php?tema_action=&tema=".$row_temas['Id']."&tema2=".$tema2."&filtro[]=foto&clear=true\"><span></span>".$row_temas['Tema']."</a>
							<ul id=\"s_$prefix-$k\" style=\"display: none;\" class=\"submenu\">";
//	        				<div class=\"submenu view-submenu\" style=\"display: none;\">";
        	constructTree($nextQuery, $table, $html, $pulsar, $idioma, $prefix."-".$k);
        	$html .= "
    	    				</ul>
    	    			</li>";
        }
        else {
        	$html .= "
        				<li id=\"mn_$prefix-$k\" class=\"view-submenu\" ><a href=\"listing.php?tema_action=&tema=".$row_temas['Id']."&tema2=".$tema2."&filtro[]=foto&clear=true\" class=\"sub\">".$row_temas['Tema']."</a></li>";
        }
        $k++;        
      }
   }
   function rootTree($query, $table, &$html, $pulsar, $idioma, $tema2 = 0) {
   	  $k = 1;
      while ($row_temas = mysql_fetch_assoc($query))
      {
        $nextQuery = mysql_query("SELECT Id,Tema$idioma as Tema, Pai FROM $table where Pai = ".$row_temas['Id']." ORDER BY Pai,Tema ASC");
		      	      	
        if (mysql_num_rows($nextQuery) > 0) {
        	$html .= "				
        		<li id=\"mn_$k\" class=\"view-submenu\">
        			<a href=\"listing.php?tema_action=&tema=".$row_temas['Id']."&tema2=".$tema2."&filtro[]=foto&clear=true\" class=\"sub\"><span></span>".$row_temas['Tema']."</a>
					<ul id=\"s_$k\" style=\"display: none;\" class=\"submenu\">";
//        			<div class=\"submenu view-submenu\" style=\"display: none;\">";
        	constructTree($nextQuery, $table, $html, $pulsar, $idioma, $k, $tema2);
        	$html .= "
        			</ul>
        		</li>";
        }
        else {
        	$html .= "
        		<li id=\"mn_$k\" class=\"view-submenu\"><a href=\"listing.php?tema_action=&tema=".$row_temas['Id']."&tema2=".$tema2."&filtro[]=foto&clear=true\" class=\"sub\">".$row_temas['Tema']."</a></li>";
        }
        $k++;
      }
   }
 
?>