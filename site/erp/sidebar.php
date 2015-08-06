<div id="sidebar">
  <a href="#" class="visible-phone"><i class="icon icon-home"></i> Dashboard</a>
  <ul>


  
<?php 
$menu->db=$database_sig;
$menu->dbConn=$sig;

$menu->createMenu((isset($row_top_login['role'])?$row_top_login['role']:0));
?>
  
  
  </ul>
</div>

