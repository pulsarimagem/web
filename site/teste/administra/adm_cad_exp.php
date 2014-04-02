<?php require_once('Connections/pulsar.php'); ?>
<?

mysql_select_db($database_pulsar, $pulsar);
$query_cadastro = "select * from cadastro";
$cadastro = mysql_query($query_cadastro, $pulsar) or die(mysql_error());
$row_cadastro = mysql_fetch_assoc($cadastro);
$totalRows_cadastro = mysql_num_rows($cadastro);


   $csv_output = "nome,email"; 
   $csv_output .= "\n"; 

   while($row_cadastro = mysql_fetch_assoc($cadastro)) { 
       $csv_output .= $row_cadastro['nome'].",".$row_cadastro['email']."\n";
       } 

 header("Content-type: application/vnd.ms-excel");
  header("Content-disposition: csv; filename=document_" . date("Ymd") .
".csv");
   echo $csv_output;
   exit;  
?>
<script>
window.close();
</script>