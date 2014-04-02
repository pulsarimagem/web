<?php
	$corpo_email = '
<html>
<head>
<title>:: Pulsar Imagens ::</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<STYLE type=”text/css”>
.ReadMsgBody
{ width: 100%;}
.ExternalClass
{width: 100%;}
</STYLE>


</head>


<body style="margin: 0; padding: 0; "marginheight="0" topmargin="0" marginwidth="0" leftmargin="0">
  <p style="font-family:Arial, Helvetica, sans-serif; font-size: 12px; text-align:center; margin: 0; color:#666666; font-weight: normal;">Caso n&atilde;o consiga visualizar esse e-mail <a href="http://www.pulsarimagens.com.br/tool_ver_email.php?email_id='.$email_id.'&tipo=pasta" target="_blank">clique aqui</a></p>

<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><table width="650" align="center" border="0" cellspacing="0" cellpadding="0">
        
        <tr>
          <td colspan="3">&nbsp;</td>
        </tr>
        <tr>
          <td width="39" valign="top">&nbsp;</td>
          <td width="580" rowspan="2" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td align="center"><table width="100%" border="1" cellpadding="15" cellspacing="0" bordercolor="#efefef">
            <tr>
              <td width="96%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td height="5" bgcolor="#febf1b"></td>
                </tr>
                <tr>
                  <td><table width="100%" height="50" border="0" cellpadding="10" cellspacing="10">
                    <tr>
                      <td><img src="http://www.pulsarimagens.com.br/images/pulsarimagens.png" alt="logo" width="216" height="34" /></td>
                      <!-- Logo -->
                      <td width="19%"><a href="http://www.facebook.com/profile.php?id=100001082880521&amp;ref=profile#!/profile.php?id=100001082880521&amp;ref=profile" target="_blank"><img src="http://new.pulsarimagens.com.br/images/socialbar-facebook.png" alt="facebook" width="80" height="18" border="0" /></a></td>
                      <td width="16%"><a href="http://www.flickr.com/photos/pulsarimagens/" target="_blank"><img src="http://new.pulsarimagens.com.br/images/socialbar-flickr.png" alt="flickr" width="60" height="18" border="0" /></a></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td align="center">&nbsp;</td>
                </tr>
                <tr>
                  <td align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="75%"><p style="font-family:Arial, Helvetica, sans-serif; font-size: 24px; text-align:left; margin: 0; color:#ff9900; font-weight: bold; padding-left: 30px; padding-top: 20px; padding-bottom: 2px; letter-spacing: 2px;">Mensagem:</p></td>
                      </tr>
                    <tr>
                      <td><table width="90%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td height="1" bgcolor="#999999"></td>
  </tr>
</table></td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td><p style="font-family:Arial, Helvetica, sans-serif; font-size: 12px; text-align:left; margin: 0; padding-left:30px; color:#000000; font-weight: normal;">
                              '.$mensagem.'<br><br> '.$nome.'
                                <br>
                                
                          <p style="font-family:Arial, Helvetica, sans-serif; font-size: 12px; text-align:left; margin: 0; padding-left:30px; color:#666666; font-weight: normal;">&nbsp;</p></td>
                      </tr>
                    <tr>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td><p style="font-family:Arial, Helvetica, sans-serif; font-size: 12px; text-align:left; margin: 0; padding-left:30px; color:#666666; font-weight: normal;">Clicando na(s) foto(s) &eacute; poss&iacute;vel ampli&aacute;-la(s).</p></td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td><table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
                        <tr>
';		
	$tot_fotos = 1;
	$cont_fotos = 0;
	do {

		$insertSQL = "
	INSERT INTO email_fotos (tombo, id_email)
	VALUES ('".$row_fotos['tombo']."', ".$email_id.")
	";
		mysql_select_db($database_pulsar, $pulsar);
		$Result1 = mysql_query($insertSQL, $pulsar) or die(mysql_error());

		if ($tot_fotos > 3) {
			$corpo_email .=	'
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
			';
			$tot_fotos = 1; 
		}
		$corpo_email .= '
                          <td align="center">
                        	<p align="center"><a href="http://www.pulsarimagens.com.br/listing.php?show_tombo='. $row_fotos['tombo'] .'&ordem_foto='.($cont_fotos).'&email_action=&email_id='.$email_id.'" target="_blank"><img src="http://www.pulsarimagens.com.br/bancoImagens/'. $row_fotos['tombo'] .'p.jpg" border="0"></a></p>
							<p style="font-family:Arial, Helvetica, sans-serif; font-size: 12px; text-align:center; margin: 0; color:#333333; font-weight: normal;">'. $row_fotos['tombo'] .'</p>
						  </td>
		';
		$tot_fotos++;
		$cont_fotos++;
	} while ($row_fotos = mysql_fetch_assoc($fotos));
	$corpo_email .='                        
                        
 
                        </tr>
                        
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                      </table>
                      
                     </td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                    </tr>
                  </table></td>
                </tr>
              </table></td>
              </tr>
            
            
          </table>            
             </td>
              </tr>
          </table></td>
          <td width="31" valign="top">&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td valign="bottom">&nbsp;</td>
          <td>&nbsp;</td>
          <td valign="bottom">&nbsp;</td>
        </tr>
        
        <tr>
          <td colspan="3">&nbsp;</td>
        </tr>
      </table>
     </td>
  </tr>
</table>

</body>
</html>

';
?>