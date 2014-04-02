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
   function constructTree($query, &$html, $pulsar, $prefix, $tema2 = 0) {
   	  $k = 1;
      while ($row_temas = mysql_fetch_assoc($query))
      {
        $nextQuery = mysql_query("SELECT * FROM temas where Pai = ".$row_temas['Id']." ORDER BY Pai,Tema ASC");
        
        if (mysql_num_rows($nextQuery) > 0) {
        	$html .= "
						<li>        					
	        				<a href=\"listing.php?tema_action=&tema=".$row_temas['Id']."&tema2=".$tema2."\"><span>&#9668;</span>".$row_temas['Tema']."</a>
							<ul>";
//	        				<div class=\"submenu view-submenu\" style=\"display: none;\">";
        	constructTree($nextQuery, $html, $pulsar, $prefix."-".$k);
        	$html .= "
    	    				</ul>
    	    			</li>";
        }
        else {
        	$html .= "
        				<li><a href=\"listing.php?tema_action=&tema=".$row_temas['Id']."&tema2=".$tema2."\">".$row_temas['Tema']."</a></li>";
        }
        $k++;        
      }
   }
   function rootTree($query, &$html, $pulsar, $tema2 = 0) {
   	  $k = 1;
      while ($row_temas = mysql_fetch_assoc($query))
      {
        $nextQuery = mysql_query("SELECT * FROM temas where Pai = ".$row_temas['Id']." ORDER BY Pai,Tema ASC");
		      	      	
        if (mysql_num_rows($nextQuery) > 0) {
        	$html .= "				
        		<li>
        			<a href=\"listing.php?tema_action=&tema=".$row_temas['Id']."&tema2=".$tema2."\"><span>&#9668;</span>".$row_temas['Tema']."</a>
					<ul>";
//        			<div class=\"submenu view-submenu\" style=\"display: none;\">";
        	constructTree($nextQuery, $html, $pulsar, $k, $tema2);
        	$html .= "
        			</ul>
        		</li>";
        }
        else {
        	$html .= "
        		<li><a href=\"listing.php?tema_action=&tema=".$row_temas['Id']."&tema2=".$tema2."\">".$row_temas['Tema']."</a></li>";
        }
        $k++;
      }
   }
 
?>