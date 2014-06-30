<?php require_once('Connections/pulsar.php'); ?>
<?php
$idsContratos = isset($_GET['id_contrato'])?$_GET['id_contrato']:0;
$idsContratos_str = implode(",",$idsContratos);

$query_contratos="SELECT ID, ID_CLIENTE, DESCRICAO, VALOR_TOTAL FROM CONTRATOS WHERE ID IN ($idsContratos_str)";
echo $query_contratos;
$contratos = mysql_query($query_contratos, $sig) or die(mysql_error());
$totalRowsContratos = mysql_num_rows($contratos);

$idCliente = 0;
$sumTotal = 0;
$desc = "";
while($rowContratos = mysql_fetch_array($contratos)) {
	if($idCliente == 0) {
		$idCliente = $rowContratos['ID_CLIENTE']; 
	}
	else if($idCliente != $rowContratos['ID_CLIENTE']) {
		echo "Contratos de Clientes diferentes!<br>";
		exit(0);
	}
	$sumTotal += fixnumber($rowContratos['VALOR_TOTAL']);
	$desc .= $rowContratos['DESCRICAO']." - LR ".$rowContratos['ID'].".....R$ ".$rowContratos['VALOR_TOTAL']."\n";
}

$query_empresas = "SELECT * FROM CLIENTES WHERE ID=$idCliente AND STATUS = 'A' ORDER BY RAZAO";
echo $query_empresas;
$empresas = mysql_query($query_empresas, $sig) or die(mysql_error());
$rowEmpresas = mysql_fetch_array($empresas); 
$totalRowsEmpresas = mysql_num_rows($empresas);

// Envio NFS-e Prefeitura Sao Paulo

require('libs/NFSeSP.class.php');
require('libs/NFeRPS.class.php');

$nfse = new NFSeSP();

$rps = new NFeRPS();

$rps->CCM = '98980084';  // inscricao municipal da Empresa
$rps->serie = 'A';       // serie do RPS gerado
$rps->numero = '1';      // numero do RPS gerado

$rps->dataEmissao = date("Y-m-d");
$rps->valorServicos = $sumTotal;
$rps->valorDeducoes = 0;
$rps->codigoServico = '06173';   // codigo do servicoo executado
$rps->aliquotaServicos = 0;
$rps->tributacao = "T";
$rps->discriminacao = $desc;

$rps->contractorRPS = new ContractorRPS();

$endRaw = explode(",",$rowEmpresas['ENDERECO']);
$endRua = $endRaw[0];
$endRaw2 = explode(",",$endRaw[1]);
$endNum = $endRaw2[0];
$endComp = $endRaw2[1];

$queryCidade ="SELECT * FROM municipios WHERE municipio LIKE '".removeAccents($rowEmpresas['CIDADE'])."' AND estado LIKE '".$rowEmpresas['ESTADO']."'";
$rsCidade = mysql_query($queryCidade, $sig) or die(mysql_error());
$rowCidade = mysql_fetch_array($rsCidade); 
$totalCidade = mysql_num_rows($rsCidade);
if($totalCidade != 1) {
	echo "Erro localizando cidade! SQL=$queryCidade <br>";
	exit(0);
}
$rps->contractorRPS->cnpjTomador = $rowEmpresas['CNPJ'];
$rps->contractorRPS->ccmTomador = $rowEmpresas['INSCRICAO'];
$rps->contractorRPS->type = 'C';		// C=Pessoa Juridica, F=Pessoa Fisica
$rps->contractorRPS->name = $rowEmpresas['RAZAO'];
$rps->contractorRPS->tipoEndereco = "R";  // Rua
$rps->contractorRPS->endereco = $endRua;
$rps->contractorRPS->enderecoNumero = $endNum;
$rps->contractorRPS->complemento = $endComp;
$rps->contractorRPS->bairro = $rowEmpresas['BAIRRO'];
$rps->contractorRPS->cidade = $rowCidade['id'];
$rps->contractorRPS->estado = 'SP';
$rps->contractorRPS->cep = $rowEmpresas['CEP'];
$rps->contractorRPS->email = 'pulsar@pulsarimagens.com.br';

$rpsArray[] = $rps;

$rangeDate['inicio'] = date("Y-m-d");
$rangeDate['fim']   = date("Y-m-d");
$valorTotal['servicos'] = $sumTotal;
$valorTotal['deducoes'] = 0;

print_r($rpsArray);
echo "<br>\n";
$ret = $nfse->sendRPS ($rps);

$docxml = $ret->saveXML();


print_r($ret);
echo "<br>\n";
print_r($docxml);
echo "<br>\n";

if ($ret->Cabecalho->Sucesso == "true") {
   if ($ret->Cabecalho->Alerta) {
      $errMsg = "Erro " . $ret->Cabecalho->Alerta->Codigo . " - ";
      $errMsg.=  utf8_decode($ret->Cabecalho->Alerta->Descricao);
   }

   if ($ret->Cabecalho->Erro) {
      $errMsg = "Erro " . $ret->Cabecalho->Erro->Codigo . " - ";
      $errMsg.=  utf8_decode($ret->Cabecalho->Erro->Descricao);
   }
} else {
   if ($ret->Cabecalho->Erro) {
      $errMsg = "Erro " . $ret->Cabecalho->Erro->Codigo . " - ";
      $errMsg.=  utf8_decode($ret->Cabecalho->Erro->Descricao);
   } else {
      $errMsg = utf8_decode("Erro no processamento da solicitacao");
   }
}

if ($errMsg == "") {
   // obtem dados da Nota Fiscal
   $NumeroNFe = trim($ret->ChaveNFeRPS->ChaveNFe->NumeroNFe);
   $CodVer   = trim($ret->ChaveNFeRPS->ChaveNFe->CodigoVerificacao);

   // Como a Prefeitura de Sao Paulo desconsidera os dados do destinatario que voce envia
   // e mantem o que esta cadastrado no banco de dados deles...
   // Consulta NFS-e para acertar data / hora / Endereco do destinatario
   $ret = $nfse->queryNFe($NumeroNFe,0,'');
   if ($ret->Cabecalho->Sucesso) {
      $DtEmi = $ret->NFe->DataEmissaoNFe;
      if (strlen($DtEmi) == 19) {
         $HoraEmi = substr($DtEmi,11,2) . substr($DtEmi,14,2) . substr($DtEmi,17,2);
         $DataEmi = substr($DtEmi,0,4) . substr($DtEmi,5,2) . substr($DtEmi,8,2);
         $Tomador   = utf8_decode($ret->NFe->RazaoSocialTomador);
         $FavEmail  = $ret->NFe->EmailTomador;
         if ($FavEmail == "") {
            $FavEmail = "-----";
         }
         $FavRua    = $ret->NFe->EnderecoTomador->TipoLogradouro . " ";
         $FavRua   .= utf8_decode($ret->NFe->EnderecoTomador->Logradouro);
         $FavRua    = replace("'","`",$FavRua);
         $FavRuaNum = $ret->NFe->EnderecoTomador->NumeroEndereco;
         $FavRuaCpl = $ret->NFe->EnderecoTomador->ComplementoEndereco;
         $FavCep    = $ret->NFe->EnderecoTomador->CEP;
         if (strlen($FavCep) < 8) {
            $FavCep = str_repeat("0", 8 - strlen($FavCep)) . $FavCep;
         }
         $FavBairro = utf8_decode($ret->NFe->EnderecoTomador->Bairro);
         $FavBairro = replace("'","`",$FavBairro);
         $FavCidade = $ret->NFe->EnderecoTomador->Cidade;
         $FavEstado = $ret->NFe->EnderecoTomador->UF;
         $VrCredito = $ret->NFe->ValorCredito;
      }
      //
      // insira aqui sua rotina de atualizacao do banco de dados
      //
   }
}

?>
