<?php require_once('Connections/pulsar.php'); ?>
<?php
$menu_busca_adv = true;

mysql_select_db($database_pulsar, $pulsar);
$query_fotografos = "SELECT * FROM fotografos ORDER BY Nome_Fotografo ASC";
$fotografos = mysql_query($query_fotografos, $pulsar) or die(mysql_error());
$row_fotografos = mysql_fetch_assoc($fotografos);
$totalRows_fotografos = mysql_num_rows($fotografos);

mysql_select_db($database_pulsar, $pulsar);
$query_estados = "SELECT * FROM Estados ORDER BY Estado ASC";
$estados = mysql_query($query_estados, $pulsar) or die(mysql_error());
$row_estados = mysql_fetch_assoc($estados);
$totalRows_estados = mysql_num_rows($estados);

mysql_select_db($database_pulsar, $pulsar);
$query_paises = "SELECT * FROM paises ORDER BY nome ASC";
$paises = mysql_query($query_paises, $pulsar) or die(mysql_error());
$row_paises = mysql_fetch_assoc($paises);
$totalRows_paises = mysql_num_rows($paises);

if (isset($_GET['estado'])) {
  mysql_select_db($database_pulsar, $pulsar);
  $query_estado = "SELECT * FROM Estados LEFT JOIN temas ON (Estados.Estado like temas.Tema) WHERE Sigla = '" . $_GET['estado'] . "' ORDER BY Estado ASC";
  $estado = mysql_query($query_estado, $pulsar) or die(mysql_error());
  $row_estado = mysql_fetch_assoc($estado);
  $totalRows_estado = mysql_num_rows($estado);

//	$query_temas_menu = "select * from temas left join (select distinct id_pai from lista_temas left join (select distinct id_tema from rel_fotos_temas left join (select id_foto from rel_fotos_temas left join (select id from temas where pai in (select id from temas where pai = 3 and Tema like \"".$row_estado['Estado']."\") union select id from temas where pai = 3 and Tema like \"".$row_estado['Estado']."\") as temas_estado on rel_fotos_temas.id_tema = temas_estado.id where id_tema = id) as fotos_tema_estado on rel_fotos_temas.id_foto = fotos_tema_estado.id_foto where rel_fotos_temas.id_foto = fotos_tema_estado.id_foto) as  id_temas_faltando on lista_temas.id_tema = id_temas_faltando.id_tema where lista_temas.id_tema = id_temas_faltando.id_tema) as temas_estado_id on temas.Id = temas_estado_id.id_pai where temas.Id = temas_estado_id.id_pai order by Pai,Tema ASC";
  $query_temas_menu = "
		select * from temas left join 
		(select distinct id_pai from lista_temas left join 
		(select distinct id_tema from rel_fotos_temas left join 
		(select distinct id_foto from Fotos where id_estado = " . $row_estado['id_estado'] . ")
		as fotos_tema_estado on rel_fotos_temas.id_foto = fotos_tema_estado.id_foto where rel_fotos_temas.id_foto = fotos_tema_estado.id_foto) 
		as  id_temas_faltando on lista_temas.id_tema = id_temas_faltando.id_tema where lista_temas.id_tema = id_temas_faltando.id_tema) 
		as temas_estado_id on temas.Id = temas_estado_id.id_pai where temas.Id = temas_estado_id.id_pai order by Pai,Tema ASC;";

  $temas_menu = mysql_query($query_temas_menu, $pulsar) or die(mysql_error());
  $row_temas_menu = mysql_fetch_assoc($temas_menu);
  $totalRows_temas_menu = mysql_num_rows($temas_menu);

  /* 	
    mysql_select_db($database_pulsar, $pulsar);
    $query_temas_estado1 = "DROP TEMPORARY TABLE IF EXISTS tmp3";
    $temas_estado1 = mysql_query($query_temas_estado1, $pulsar) or die(mysql_error());
    $query_temas_estado1 = "CREATE TEMPORARY TABLE tmp3 ENGINE = MEMORY SELECT DISTINCT Fotos.Id_Foto, Fotos.tombo, Fotos.assunto_principal, Fotos.orientacao, Fotos.data_foto FROM Fotos INNER JOIN rel_fotos_temas ON (Fotos.Id_Foto=rel_fotos_temas.id_foto) INNER JOIN temas ON (rel_fotos_temas.id_tema=temas.Id) WHERE ( temas.Id in (select id from temas where Pai in (select id from temas where Tema like \"".$row_estado['Estado']."\" union select id from temas where Tema like \"".$row_estado['Estado']."\"))) ORDER BY Fotos.Id_Foto DESC";
    $temas_estado1 = mysql_query($query_temas_estado1, $pulsar) or die(mysql_error());
    $query_temas_estado1 = "SELECT *  FROM   temas WHERE id in (SELECT distinct  id_pai  FROM    lista_temas WHERE id_tema in (select distinct rel_fotos_temas.id_tema from rel_fotos_temas,tmp3,temas where rel_fotos_temas.id_foto = tmp3.Id_Foto and rel_fotos_temas.id_tema = temas.id) order by id_pai) and Pai = 0 order by Tema asc;";
    $temas_estado1 = mysql_query($query_temas_estado1, $pulsar) or die(mysql_error());
    $row_temas_estado1 = mysql_fetch_assoc($temas_estado1);
    $totalRows_temas_estado1 = mysql_num_rows($temas_estado1);
   */
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <title>Pulsar Imagens</title>
    <link href="style.css" rel="stylesheet" type="text/css" />
    <?php include("scripts.php"); ?>
    <script src="jquery.maphilight.min.js" type="text/javascript" ></script>
    <script type="text/javascript">
      jQuery(document).ready(function() {
        $('#imgMap').maphilight( {strokeColor:'FFA603', strokeWidth:3, fillColor:'FFA603', fillOpacity:.85} );
      });
    </script>
  </head>
  <body>
    <?php include("part_topbar.php"); ?>

    <div class="main size960">
      <div class="buscaavancada">

        <div class="mapa">
          <h2>Busca por Estado</h2>
          <?php if (isset($_GET['estado'])) { ?>
            <div class="estado hide_5s">
              <?php include("menu_coolmenu_busca_adv.php"); ?>
              <?php
              /* include("create_menu.php");
                $html = "
                <ul>";
                rootTree($temas_estado1, $html, $pulsar, $row_estado['Id']);
                //   				<div class=\"clear\"></div>
                $html .= "
                </ul>
                </div>
                ";

                printf("%s", $html);
               */
              ?>
            </div>
          <?php } ?>
          <div id="map">
            <img src="images/brasil.png" width="410" height="428" border="0" usemap="#MapArea" id="imgMap" />
            <map name="MapArea" id="MapArea">
              <area id="ap" shape="poly" coords="202,31,207,34,213,32,222,33,235,11,239,17,242,29,250,39,253,46,243,52,239,57,234,65,230,68,225,65,223,60,220,51,217,43,207,40,200,37" href="buscaavancada.php?estado=ap" />
              <area id="pa" shape="poly" coords="245,55,251,51,261,60,269,61,262,70,254,76,259,79,263,72,270,67,274,61,292,69,286,84,281,94,274,105,266,112,269,116,265,125,260,128,258,134,258,145,248,159,189,155,178,153,172,147,169,139,165,130,164,125,184,79,171,72,158,65,158,56,158,42,164,43,171,40,176,36,185,38,190,38,186,32,194,31,202,33,200,39,212,44,220,47,225,64,231,69" href="buscaavancada.php?estado=pa" />
              <area id="ma" shape="poly" coords="292,70,298,72,303,73,308,75,308,83,315,82,323,82,330,85,336,84,334,89,330,91,326,94,324,100,325,105,325,109,323,114,323,119,326,122,323,127,316,125,312,126,308,132,304,134,296,135,295,141,292,147,293,152,294,160,288,160,286,158,287,155,284,153,282,150,285,145,289,143,288,140,284,138,281,136,277,134,275,130,278,124,279,118,278,115,278,112,269,110,279,99,288,83" href="buscaavancada.php?estado=ma" />
              <area id="pi" shape="poly" coords="337,86,341,87,339,91,344,100,341,105,347,116,348,122,352,127,349,135,347,142,331,153,327,156,320,153,316,153,316,160,310,167,303,170,297,167,289,161,296,159,294,149,296,140,301,133,311,130,314,126,324,127,324,121,325,113,327,112,325,101,329,92" href="buscaavancada.php?estado=pi" />
              <area id="ce "shape="poly" coords="343,86,353,84,361,88,384,107,379,109,375,114,371,119,370,126,369,128,371,133,364,137,360,132,351,134,353,128,348,122,348,115,343,109,342,105,345,102,342,95,340,91" href="buscaavancada.php?estado=ce" />
              <area id="rn" shape="poly" coords="384,107,399,108,405,111,408,124,397,123,393,121,390,128,388,126,380,126,385,119,379,120,375,122,371,122,376,113" href="buscaavancada.php?estado=rn" />
              <area id="pb" shape="poly" coords="371,123,379,121,385,120,382,127,390,128,394,123,408,126,408,134,403,133,396,139,392,137,389,141,385,141,382,138,384,133,381,131,375,136,369,136,372,131,371,127" href="buscaavancada.php?estado=pb" />
              <area id="pe" shape="poly" coords="345,146,348,155,355,150,360,145,366,148,373,152,379,148,384,152,391,154,396,151,401,149,405,150,408,139,408,136,405,133,401,138,393,139,390,141,383,140,385,135,381,132,376,136,369,136,365,138,360,133,351,134,349,138" href="buscaavancada.php?estado=pe" />
              <area id="al" shape="poly" coords="374,152,378,148,384,152,394,152,405,149,390,164,384,158" href="buscaavancada.php?estado=al" />
              <area id="se" shape="poly" coords="390,165,385,169,381,177,376,174,372,168,378,166,379,161,375,153,384,157" href="buscaavancada.php?estado=se" />
              <area id="ba" shape="poly" coords="380,178,372,192,369,193,365,204,367,220,365,228,364,237,364,243,359,247,352,242,349,237,354,229,357,225,346,220,343,222,336,213,332,215,322,208,320,210,314,209,315,203,308,205,292,214,294,206,291,203,290,199,292,192,291,189,288,183,290,180,292,177,285,173,294,165,304,171,315,164,317,161,317,155,322,154,329,157,339,148,347,144,345,147,348,156,355,150,361,146,376,153,378,159,381,162,372,169" href="buscaavancada.php?estado=ba" />
              <area id="to" shape="poly" coords="267,112,273,111,278,113,280,119,276,127,276,130,281,137,289,143,285,146,283,150,288,155,287,158,294,166,289,168,286,174,292,176,290,182,290,188,281,194,277,194,274,192,271,195,261,192,262,188,257,191,247,191,249,188,245,188,244,181,244,168,251,156,259,145,259,133,261,128,268,121" href="buscaavancada.php?estado=to" />
              <area id="es" shape="poly" coords="359,248,358,256,358,262,353,267,350,274,343,283,339,280,336,275,337,270,342,269,344,264,346,260,343,253,345,247,352,244" href="buscaavancada.php?estado=es" />
              <area id="mg" shape="poly" coords="293,215,310,205,316,204,314,209,319,211,324,209,330,214,334,217,335,212,343,221,350,223,358,225,352,232,349,237,353,245,347,245,345,251,345,258,343,268,339,271,336,274,331,284,327,290,320,290,315,290,306,295,298,296,294,299,289,299,287,294,286,292,287,288,288,284,284,283,280,278,280,270,277,267,271,269,258,269,253,268,247,265,240,269,242,260,244,257,249,252,258,252,266,249,274,250,278,247,281,244,278,238,282,234,278,230,279,223,284,222,285,209" href="buscaavancada.php?estado=mg" />
              <area id="rj" shape="poly" coords="336,277,341,281,345,283,344,289,338,294,334,296,334,300,324,299,314,302,306,303,310,300,309,294,316,290,327,290,332,284" href="buscaavancada.php?estado=rj" />
              <area id="sp" shape="poly" coords="306,304,309,301,311,300,309,295,303,295,296,297,294,300,289,298,286,293,287,287,289,284,284,284,280,279,282,273,279,267,275,270,266,270,260,270,252,267,248,266,240,269,235,273,230,280,227,283,226,289,219,296,228,296,233,296,239,297,244,299,250,300,256,302,258,311,260,316,257,319,268,323,268,327,283,315,294,309,299,310,301,308" href="buscaavancada.php?estado=sp" />
              <area id="pr" shape="poly" coords="220,296,238,296,248,299,257,304,259,310,261,316,259,321,266,322,270,328,266,334,260,335,256,338,252,335,244,334,244,337,238,337,237,344,233,341,226,341,223,338,217,338,211,337,210,333,208,329,203,331,202,327,207,319,206,312,210,306,213,302,215,299" href="buscaavancada.php?estado=pr" />
              <area id="sc" shape="poly" coords="266,334,265,346,267,351,265,358,264,365,253,374,251,372,253,364,247,363,242,361,236,352,228,349,219,349,210,348,213,338,221,340,226,340,228,341,234,341,238,343,239,338,245,338,246,334,252,336,257,338" href="buscaavancada.php?estado=sc" />
              <area id="rs" shape="poly" coords="210,349,229,349,239,353,241,356,245,364,253,364,252,370,254,375,248,387,241,399,235,404,238,399,240,395,243,388,240,382,239,385,237,388,237,392,233,397,229,400,228,402,229,405,226,410,225,415,222,422,219,425,215,425,215,420,218,414,216,411,214,412,211,407,206,403,204,399,199,399,197,397,193,391,189,396,186,390,182,383,179,381,174,384,171,384,178,375,187,363,195,356,202,352" href="buscaavancada.php?estado=rs" />
              <area id="go" shape="poly" coords="291,189,292,193,291,198,291,202,294,206,294,213,287,210,286,218,285,221,280,222,280,218,267,217,267,224,279,226,279,230,283,234,279,237,277,240,281,244,277,248,275,251,270,249,266,250,259,252,253,252,248,253,242,260,236,257,230,254,227,253,220,253,222,250,219,250,218,243,218,236,220,232,226,229,227,225,231,221,235,214,239,212,244,202,245,196,246,189,247,189,249,191,252,192,259,192,262,190,265,192,274,195,277,192,282,195,286,192" href="buscaavancada.php?estado=go" />
              <area id="df" shape="rect" coords="267,218,280,225" href="buscaavancada.php?estado=df" />
              <area id="ms" shape="poly" coords="172,243,178,241,182,237,186,236,191,239,197,242,203,239,207,240,213,238,210,245,219,246,222,250,220,253,228,254,238,257,243,260,241,267,240,269,231,279,228,283,227,287,221,294,215,300,209,310,207,311,205,309,199,311,195,311,192,305,192,294,187,291,182,291,178,293,166,290,167,283,169,277,165,270,170,267,166,262,171,254" href="buscaavancada.php?estado=ms" />
              <area id="mg" shape="poly" coords="166,131,163,135,163,140,163,147,131,147,131,154,131,161,131,171,140,171,147,172,145,178,149,183,146,190,139,199,142,201,142,208,144,212,147,212,145,227,165,229,163,231,165,237,169,242,171,247,174,241,178,241,185,236,196,241,202,241,205,239,213,239,210,244,218,247,219,240,220,236,222,229,229,223,233,219,236,214,240,211,244,203,247,192,249,190,245,184,245,177,246,169,250,163,251,157,224,158,202,156,185,154,173,149,169,139" href="buscaavancada.php?estado=mt" />
              <area id="ro" shape="poly" coords="132,147,125,147,122,144,118,141,113,139,107,141,103,144,100,147,96,150,92,153,86,154,79,154,77,159,81,157,88,157,91,159,91,165,91,171,92,177,100,183,102,185,107,186,113,188,121,193,126,197,135,198,139,198,146,191,150,187,149,184,146,180,147,173,140,171,132,171" href="buscaavancada.php?estado=ro" />
              <area id="ac" shape="poly" coords="76,158,47,144,40,141,30,138,14,135,4,130,3,134,3,140,9,144,12,150,9,153,14,154,21,159,28,159,35,157,37,155,36,163,36,169,38,171,45,169,51,170,59,173,62,169,65,166,72,164" href="buscaavancada.php?estado=ac" />
              <area id="am" shape="poly" coords="2,128,7,123,9,122,6,117,11,111,17,103,23,101,32,98,36,98,42,98,45,84,48,73,48,68,46,64,47,62,43,60,40,54,41,50,43,49,46,49,50,47,47,44,43,43,44,37,55,37,60,35,66,36,69,34,70,39,72,43,77,44,79,46,85,44,90,46,94,44,101,39,106,34,111,31,114,34,117,37,119,43,121,48,118,53,118,56,124,59,122,63,128,68,129,65,131,63,134,59,138,63,142,63,143,57,145,54,146,53,156,54,157,64,183,78,165,123,166,127,164,129,163,135,162,146,125,146,122,143,119,140,111,138,105,141,96,146,91,150,87,153,78,154,77,158,61,151,46,144,32,138,21,136,16,136,9,132" href="buscaavancada.php?estado=am" />
              <area id="rr" shape="poly" coords="97,11,105,14,114,15,119,18,123,12,131,12,136,8,140,6,139,3,148,3,146,6,145,7,150,10,152,15,149,20,147,23,148,29,151,39,158,43,159,55,152,54,146,55,144,62,142,65,137,63,129,68,123,64,127,61,122,59,120,53,123,47,121,41,118,34,112,34,111,30,104,30,104,24" href="buscaavancada.php?estado=rr" />
            </map>
          </div>
        </div>
        <!-- 
        
              <ul id="map">
                <li id="crs" estado="rs"><a href="buscaavancada.php?estado=rs" id="rs" title="RS"><img src="images/mapa/null.png" alt="RS" /></a></li>
                <li id="csc" estado="sc"><a href="buscaavancada.php?estado=sc" id="sc" title="SC"><img src="images/mapa/null.png" alt="SC" /></a></li>
                <li id="cpr" estado="pr"><a href="buscaavancada.php?estado=pr" id="pr" title="PR"><img src="images/mapa/null.png" alt="PR" /></a></li>
                <li id="csp" estado="sp"><a href="buscaavancada.php?estado=sp" id="sp" title="SP"><img src="images/mapa/null.png" alt="SP" /></a></li>
                <li id="cms" estado="ms"><a href="buscaavancada.php?estado=ms" id="ms" title="MS"><img src="images/mapa/null.png" alt="MS" /></a></li>
                <li id="crj" estado="rj"><a href="buscaavancada.php?estado=rj" id="rj" title="RJ"><img src="images/mapa/null.png" alt="RJ" /></a></li>
                <li id="ces" estado="es"><a href="buscaavancada.php?estado=es" id="es" title="ES"><img src="images/mapa/null.png" alt="ES" /></a></li>
                <li id="cmg" estado="mg"><a href="buscaavancada.php?estado=mg" id="mg" title="MG"><img src="images/mapa/null.png" alt="MG" /></a></li>
                <li id="cgo" estado="go"><a href="buscaavancada.php?estado=go" id="go" title="GO"><img src="images/mapa/null.png" alt="GO" /></a></li>
                <li id="cdf" estado="df"><a href="buscaavancada.php?estado=df" id="df" title="DF"><img src="images/mapa/null.png" alt="DF" /></a></li>
                <li id="cba" estado="ba"><a href="buscaavancada.php?estado=ba" id="ba" title="BA"><img src="images/mapa/null.png" alt="BA" /></a></li>
                <li id="cmt" estado="mt"><a href="buscaavancada.php?estado=mt" id="mt" title="MT"><img src="images/mapa/null.png" alt="MT" /></a></li>
                <li id="cro" estado="ro"><a href="buscaavancada.php?estado=ro" id="ro" title="RO"><img src="images/mapa/null.png" alt="RO" /></a></li>
                <li id="cac" estado="ac"><a href="buscaavancada.php?estado=ac" id="ac" title="AC"><img src="images/mapa/null.png" alt="AC" /></a></li>
                <li id="cam" estado="am"><a href="buscaavancada.php?estado=am" id="am" title="AM"><img src="images/mapa/null.png" alt="AM" /></a></li>
                <li id="crr" estado="rr"><a href="buscaavancada.php?estado=rr" id="rr" title="RR"><img src="images/mapa/null.png" alt="RR" /></a></li>
                <li id="cpa" estado="pa"><a href="buscaavancada.php?estado=pa" id="pa" title="PA"><img src="images/mapa/null.png" alt="PA" /></a></li>
                <li id="cap" estado="ap"><a href="buscaavancada.php?estado=ap" id="ap" title="AP"><img src="images/mapa/null.png" alt="AP" /></a></li>
                <li id="cma" estado="ma"><a href="buscaavancada.php?estado=ma" id="ma" title="MA"><img src="images/mapa/null.png" alt="MA" /></a></li>
                <li id="cto" estado="to"><a href="buscaavancada.php?estado=to" id="to" title="TO"><img src="images/mapa/null.png" alt="TO" /></a></li>
                <li id="cse" estado="se"><a href="buscaavancada.php?estado=se" id="se" title="SE"><img src="images/mapa/null.png" alt="SE" /></a></li>
                <li id="cal" estado="al"><a href="buscaavancada.php?estado=al" id="al" title="AL"><img src="images/mapa/null.png" alt="AL" /></a></li>
                <li id="cpe" estado="pe"><a href="buscaavancada.php?estado=pe" id="pe" title="PE"><img src="images/mapa/null.png" alt="PE" /></a></li>
                <li id="cpb" estado="pb"><a href="buscaavancada.php?estado=pb" id="pb" title="PB"><img src="images/mapa/null.png" alt="PB" /></a></li>
                <li id="crn" estado="rn"><a href="buscaavancada.php?estado=rn" id="rn" title="RN"><img src="images/mapa/null.png" alt="RN" /></a></li>
                <li id="cce" estado="ce"><a href="buscaavancada.php?estado=ce" id="ce" title="CE"><img src="images/mapa/null.png" alt="CE" /></a></li>
                <li id="cpi" estado="pi"><a href="buscaavancada.php?estado=pi" id="pi" title="PI"><img src="images/mapa/null.png" alt="PI" /></a></li>
              </ul>
            </div>
        -->
        <div class="busca">
          <h2>Busca Avan�ada</h2>
          <div class="box">
            <form name="form1" method="get" action="listing.php">
              <ul>
                <li>
                  <label>Tipo:</label>
                  <select class="select" name="filtro">
                    <option value="foto" selected="selected">Fotos</option>
                    <option value="video">V�deos</option>
                  </select>
                  <div class="clear"></div>
                </li>
                <li>
                  <label>Fra��o da palavra:</label>
                  <input name="fracao" type="text" class="text" />
                  <div class="clear"></div>
                </li>
                <li>
                  <label>Palavra chave:</label>
                  <input name="palavra1" type="text" class="text" style="width: 91px;" /> <span>e</span> <input name="palavra2" type="text" class="text" style="width: 91px;" /> <span>e</span> <input name="palavra3" type="text" class="text"  style="width: 90px;" />
                  <div class="clear"></div>
                </li>
                <li>
                  <label style="padding-top:0; line-height: 1em">N�o contendo palavra:</label>
                  <input name="nao_palavra" type="text" class="text" />
                  <div class="clear"></div>
                </li>
                <li>
                  <label>Cidade:</label>
                  <input name="local" type="text" class="text" style="width: 211px; margin-right: 6px;" /> 
                  <select name="estado[]" id="estado" class="select multi_select" style="width: 105px; margin-right: 6px;" multiple="multiple">
                    <option value="">Estado</option>
                    <?php
                    do {
                      ?>
                      <option value="<?php echo $row_estados['Sigla'] ?>"><?php echo $row_estados['Estado'] ?></option>
                      <?php
                    } while ($row_estados = mysql_fetch_assoc($estados));
                    $rows = mysql_num_rows($estados);
                    if ($rows > 0) {
                      mysql_data_seek($estados, 0);
                      $row_estados = mysql_fetch_assoc($estados);
                    }
                    ?>
                  </select> 
                  <div class="clear"></div>
                </li>
                <li>
                  <label>Pa&iacute;s:</label>
                  <select name="pais" class="select" style="width: 345px;" >
                    <option value="">Todos</option>
                    <?php
                    do {
                      ?>
                      <option value="<?php echo $row_paises['id_pais'] ?>"><?php echo $row_paises['nome'] ?></option>
                      <?php
                    } while ($row_paises = mysql_fetch_assoc($paises));
                    $rows = mysql_num_rows($paises);
                    if ($rows > 0) {
                      mysql_data_seek($paises, 0);
                      $row_paises = mysql_fetch_assoc($paises);
                    }
                    ?>
                  </select>
                  <div class="clear"></div>
                </li>
                <li>
                  <label>Autor:</label>
                  <select name="id_autor[]" class="select"> <!-- size="5" multiple  -->
                    <option class="select" value="">Todos</option>
                    <?php
                    do {
                      ?>
                      <option class="select" value="<?php echo $row_fotografos['id_fotografo'] ?>"><?php echo $row_fotografos['Nome_Fotografo'] ?></option>
                      <?php
                    } while ($row_fotografos = mysql_fetch_assoc($fotografos));
                    ?>
                  </select>
                  <div class="clear"></div>
                </li>
                <li>
                  <label>Data:</label>
                  <input name="dia" type="text" class="text" style="width: 36px;" /> <span>/</span> <input name="mes" type="text" class="text" style="width: 36px;" /> <span>/</span> <input name="ano" type="text" class="text" style="width: 80px;" /> <span>dd/mm/aaaa</span>
                  <div class="clear"></div>
                </li>
                <li>
                  <label></label>
                  <input name="data_tipo" type="radio" value="exata" class="radio" checked/> <p>Data Exata</p>
                  <input name="data_tipo" type="radio" value="depois" class="radio" /> <p>A partir de</p>
                  <input name="data_tipo" type="radio" value="antes" class="radio" /> <p>Anterior a</p>
<!--	<select name="data_tipo" class="select">
    <option value="exata">Data Exata</option>
    <option value="depois">A partir de</option>
    <option value="antes">Anterior a</option>
    </select>	-->
                  <div class="clear"></div>
                </li>
                <li>
                  <label>Formato:</label>
                  <input name="horizontal" type="checkbox" value="H" class="radio" checked/> <p>Horizontal</p>
                  <input name="vertical" type="checkbox" value="V" class="radio" checked/> <p>Vertical</p>
                  <div class="clear"></div>
                </li>
                <!-- 						<li>
                              <label>Comparativo:</label>
                              <input name="" type="radio" value="" class="radio" /> <p>Ativar</p>
                              <input name="" type="radio" value="" class="radio" checked /> <p>Desativar</p>
                              <div class="clear"></div>
                            </li>
                            <li>
                              <input name="autorizada" type="checkbox" value="autorizada" class="check" checked/>
                              <label class="usoimagem">Uso de imagem autorizado</label>
                              <div class="clear"></div>
                            </li>  -->
                <li class="organizar">
                  <label>Organizar resultados por</label>
                  <input name="ordem" type="radio" value="recente" class="radio" checked/> <p>Mais recentes</p>
                  <input name="ordem" type="radio" value="data" class="radio" /> <p>Data da foto</p>
              <!--	<input name="ordem" type="radio" value="vista" class="radio" disabled/> <p>Mais Visualizadas</p>-->
                  <input name="ordem" type="radio" value="maior" class="radio" /> <p>Tamanho do arquivo</p>	
                  <div class="clear"></div>
                </li>
                <li>
                  <input name="pa_action" type="submit" value="Realizar Busca" class="button" />
                  <input name="tipo" type="hidden" value="inc_pa.php"/>
                </li>
              </ul>
            </form>
          </div>
        </div>
      </div>
      <div class="clear"></div>
    </div>
    <?php include("part_footer.php"); ?>
    </div>
    <div class="clear" > <img src="coolmenus/cm_fill.gif" width="1" height="120" alt="" border="0"></div>
  </body>
</html>
