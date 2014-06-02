<?php require_once('Connections/pulsar.php'); ?>
<?php include("tool_auth.php"); ?>
<?php
$id_contrato = $_GET['id_contrato'];

$dias_de_prazo_para_pagamento = 10;
$taxa_boleto = 2.95;


$strSQL 		= "SELECT ID_CLIENTE, ID_CONTATO,ID_CONTRATO_DESC, DESCRICAO, DATA, VALOR_TOTAL, BAIXADO, FINALIZADO, NOTA_FISCAL, DATA_PAGTO FROM CONTRATOS WHERE ID=".$id_contrato;
$objRS	= mysql_query($strSQL, $sig) or die(mysql_error());
$row_objRS = mysql_fetch_assoc($objRS);
$id_cliente	= $row_objRS['ID_CLIENTE'];
$id_contato	= $row_objRS['ID_CONTATO'];
$descricao	= $row_objRS['DESCRICAO'];
$contratoDesc = $row_objRS['ID_CONTRATO_DESC'];
$data		= $row_objRS['DATA'];
$valor 		= str_replace(".", "",$row_objRS['VALOR_TOTAL']);
$finalizado		= $row_objRS['FINALIZADO'];
$baixado		= $row_objRS['BAIXADO'];
$nota		= $row_objRS['NOTA_FISCAL'];
$data_nota 	= $row_objRS['DATA_PAGTO'];

$strSQL 		= "SELECT CNPJ, FANTASIA, RAZAO, ENDERECO, BAIRRO, CEP, CIDADE, ESTADO, TELEFONE, OBS, desc_valor, desc_porcento FROM CLIENTES WHERE ID=".$id_cliente;
$objRS1	= mysql_query($strSQL, $sig) or die(mysql_error());
$row_objRS1 = mysql_fetch_assoc($objRS1);
$cnpj		= $row_objRS1['CNPJ'];
$fantasia	= $row_objRS1['FANTASIA'];
$razao		= $row_objRS1['RAZAO'];
$endereco	= $row_objRS1['ENDERECO'];
$cep		= $row_objRS1['CEP'];
$cidade		= $row_objRS1['CIDADE'];
$estado		= $row_objRS1['ESTADO'];
$telefone	= $row_objRS1['TELEFONE'];
$obs		= $row_objRS1['OBS'];

// +----------------------------------------------------------------------+
// | BoletoPhp - Versão Beta                                              |
// +----------------------------------------------------------------------+
// | Este arquivo está disponível sob a Licença GPL disponível pela Web   |
// | em http://pt.wikipedia.org/wiki/GNU_General_Public_License           |
// | Você deve ter recebido uma cópia da GNU Public License junto com     |
// | esse pacote; se não, escreva para:                                   |
// |                                                                      |
// | Free Software Foundation, Inc.                                       |
// | 59 Temple Place - Suite 330                                          |
// | Boston, MA 02111-1307, USA.                                          |
// +----------------------------------------------------------------------+

// +----------------------------------------------------------------------+
// | Originado do Projeto BBBoletoFree que tiveram colaborações de Daniel |
// | William Schultz e Leandro Maniezo que por sua vez foi derivado do	  |
// | PHPBoleto de João Prado Maia e Pablo Martins F. Costa				        |
// | 														                                   			  |
// | Se vc quer colaborar, nos ajude a desenvolver p/ os demais bancos :-)|
// | Acesse o site do Projeto BoletoPhp: www.boletophp.com.br             |
// +----------------------------------------------------------------------+

// +--------------------------------------------------------------------------------------------------------+
// | Equipe Coordenação Projeto BoletoPhp: <boletophp@boletophp.com.br>              		             				|
// | Desenvolvimento Boleto Banco do Brasil: Daniel William Schultz / Leandro Maniezo / Rogério Dias Pereira|
// +--------------------------------------------------------------------------------------------------------+


// ------------------------- DADOS DINÂMICOS DO SEU CLIENTE PARA A GERAÇÃO DO BOLETO (FIXO OU VIA GET) -------------------- //
// Os valores abaixo podem ser colocados manualmente ou ajustados p/ formulário c/ POST, GET ou de BD (MySql,Postgre,etc)	//

// DADOS DO BOLETO PARA O SEU CLIENTE
// $dias_de_prazo_para_pagamento = 10;
// $taxa_boleto = 2.95;
$data_venc = date("d/m/Y", time() + ($dias_de_prazo_para_pagamento * 86400));  // Prazo de X dias OU informe data: "13/04/2006"; 
$valor_cobrado = $valor; // Valor - REGRA: Sem pontos na milhar e tanto faz com "." ou "," ou com 1 ou 2 ou sem casa decimal
$valor_cobrado = str_replace(",", ".",$valor_cobrado);
$valor_boleto=number_format($valor_cobrado+$taxa_boleto, 2, ',', '');

$dadosboleto["nosso_numero"] = "87654";
$dadosboleto["numero_documento"] = "27.030195.10";	// Num do pedido ou do documento
$dadosboleto["data_vencimento"] = $data_venc; // Data de Vencimento do Boleto - REGRA: Formato DD/MM/AAAA
$dadosboleto["data_documento"] = date("d/m/Y"); // Data de emissão do Boleto
$dadosboleto["data_processamento"] = date("d/m/Y"); // Data de processamento do boleto (opcional)
$dadosboleto["valor_boleto"] = $valor_boleto; 	// Valor do Boleto - REGRA: Com vírgula e sempre com duas casas depois da virgula

// DADOS DO SEU CLIENTE
$dadosboleto["sacado"] = $razao;
$dadosboleto["endereco1"] = $endereco;
$dadosboleto["endereco2"] = "$cidade - $estado -  CEP: $cep";

// INFORMACOES PARA O CLIENTE
$dadosboleto["demonstrativo1"] = "Pagamento de Compra na Pulsar Imagens";
$dadosboleto["demonstrativo2"] = "Descrição: $descricao<br>Taxa bancária - R$ ".number_format($taxa_boleto, 2, ',', '');
$dadosboleto["demonstrativo3"] = "&nbsp;";

// INSTRUÇÕES PARA O CAIXA
$dadosboleto["instrucoes1"] = "- Sr. Caixa, cobrar multa de 2% após o vencimento";
$dadosboleto["instrucoes2"] = "- Receber até 10 dias após o vencimento";
$dadosboleto["instrucoes3"] = "- Em caso de dúvidas entre em contato conosco: pulsar@pulsarimagens.com.br";
$dadosboleto["instrucoes4"] = "&nbsp;";

// DADOS OPCIONAIS DE ACORDO COM O BANCO OU CLIENTE
$dadosboleto["quantidade"] = "1";
$dadosboleto["valor_unitario"] = "1";
$dadosboleto["aceite"] = "N";		
$dadosboleto["especie"] = "R$";
$dadosboleto["especie_doc"] = "DM";


// ---------------------- DADOS FIXOS DE CONFIGURAÇÃO DO SEU BOLETO --------------- //


// DADOS DA SUA CONTA - BANCO DO BRASIL
$dadosboleto["agencia"] = "9999"; // Num da agencia, sem digito
$dadosboleto["conta"] = "99999"; 	// Num da conta, sem digito

// DADOS PERSONALIZADOS - BANCO DO BRASIL
$dadosboleto["convenio"] = "7777777";  // Num do convênio - REGRA: 6 ou 7 ou 8 dígitos
$dadosboleto["contrato"] = "999999"; // Num do seu contrato
$dadosboleto["carteira"] = "18";
$dadosboleto["variacao_carteira"] = "-019";  // Variação da Carteira, com traço (opcional)

// TIPO DO BOLETO
$dadosboleto["formatacao_convenio"] = "7"; // REGRA: 8 p/ Convênio c/ 8 dígitos, 7 p/ Convênio c/ 7 dígitos, ou 6 se Convênio c/ 6 dígitos
$dadosboleto["formatacao_nosso_numero"] = "2"; // REGRA: Usado apenas p/ Convênio c/ 6 dígitos: informe 1 se for NossoNúmero de até 5 dígitos ou 2 para opção de até 17 dígitos

/*
#################################################
DESENVOLVIDO PARA CARTEIRA 18

- Carteira 18 com Convenio de 8 digitos
  Nosso número: pode ser até 9 dígitos

- Carteira 18 com Convenio de 7 digitos
  Nosso número: pode ser até 10 dígitos

- Carteira 18 com Convenio de 6 digitos
  Nosso número:
  de 1 a 99999 para opção de até 5 dígitos
  de 1 a 99999999999999999 para opção de até 17 dígitos

#################################################
*/


// SEUS DADOS
$dadosboleto["identificacao"] = "Pulsar Imagens LTDA";
$dadosboleto["cpf_cnpj"] = "123.123.123/0001-12";
$dadosboleto["endereco"] = "Rua Apiacas, 934";
$dadosboleto["cidade_uf"] = "São Paulo / SP";
$dadosboleto["cedente"] = "Pulsar Imagens LTDA";

// NÃO ALTERAR!
include("boletophp/include/funcoes_bb.php"); 
include("boletophp/include/layout_bb.php");
?>
