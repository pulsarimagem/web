<?php require_once('Connections/pulsar.php'); ?>
<?php include("tool_auth.php"); ?>
<?php
$id_contrato = $_GET['id_contrato'];

$dias_de_prazo_para_pagamento = 10;
$taxa_boleto = 0;


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
// | PHPBoleto de João Prado Maia e Pablo Martins F. Costa			       	  |
// | 																	                                    |
// | Se vc quer colaborar, nos ajude a desenvolver p/ os demais bancos :-)|
// | Acesse o site do Projeto BoletoPhp: www.boletophp.com.br             |
// +----------------------------------------------------------------------+

// +----------------------------------------------------------------------+
// | Equipe Coordenação Projeto BoletoPhp: <boletophp@boletophp.com.br>   |
// | Desenvolvimento Boleto Bradesco: Ramon Soares						            |
// +----------------------------------------------------------------------+


// ------------------------- DADOS DINÂMICOS DO SEU CLIENTE PARA A GERAÇÃO DO BOLETO (FIXO OU VIA GET) -------------------- //
// Os valores abaixo podem ser colocados manualmente ou ajustados p/ formulário c/ POST, GET ou de BD (MySql,Postgre,etc)	//

// DADOS DO BOLETO PARA O SEU CLIENTE
$dias_de_prazo_para_pagamento = 5;
$taxa_boleto = $taxa_boleto;
$data_venc = date("d/m/Y", time() + ($dias_de_prazo_para_pagamento * 86400));  // Prazo de X dias OU informe data: "13/04/2006";
$valor_cobrado = $valor;//"5470,00"; // Valor - REGRA: Sem pontos na milhar e tanto faz com "." ou "," ou com 1 ou 2 ou sem casa decimal
$valor_cobrado = str_replace(",", ".",$valor_cobrado);
$valor_boleto=number_format($valor_cobrado+$taxa_boleto, 2, ',', '');

$dadosboleto["nosso_numero"] = "13417500364";  // Nosso numero sem o DV - REGRA: Máximo de 11 caracteres!
$dadosboleto["numero_documento"] = 5887;//$dadosboleto["nosso_numero"];	// Num do pedido ou do documento = Nosso numero
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
$dadosboleto["demonstrativo2"] = "Descrição: $descricao<br>";//Taxa bancária - R$ ".number_format($taxa_boleto, 2, ',', '');
$dadosboleto["demonstrativo3"] = "&nbsp;";
$dadosboleto["instrucoes1"] = "*** VALORES EXPRESSOS EM REAIS ***";
$dadosboleto["instrucoes2"] = "";
$dadosboleto["instrucoes3"] = "";
$dadosboleto["instrucoes4"] = "";

// DADOS OPCIONAIS DE ACORDO COM O BANCO OU CLIENTE
$dadosboleto["quantidade"] = "";
$dadosboleto["valor_unitario"] = "";
$dadosboleto["aceite"] = "Sem";
$dadosboleto["especie"] = "R$";
$dadosboleto["especie_doc"] = "DM";


// ---------------------- DADOS FIXOS DE CONFIGURAÇÃO DO SEU BOLETO --------------- //


// DADOS DA SUA CONTA - Bradesco
$dadosboleto["agencia"] = "422"; // Num da agencia, sem digito
$dadosboleto["agencia_dv"] = "7"; // Digito do Num da agencia
$dadosboleto["conta"] = "67986"; 	// Num da conta, sem digito
$dadosboleto["conta_dv"] = "0"; 	// Digito do Num da conta

// DADOS PERSONALIZADOS - Bradesco
$dadosboleto["conta_cedente"] = "67986"; // ContaCedente do Cliente, sem digito (Somente Números)
$dadosboleto["conta_cedente_dv"] = "0"; // Digito da ContaCedente do Cliente
$dadosboleto["carteira"] = "09";  // Código da Carteira: pode ser 06 ou 03

// SEUS DADOS
$dadosboleto["identificacao"] = "Pulsar Imagens LTDA";
$dadosboleto["cpf_cnpj"] = "66.647.157/0001-11";
$dadosboleto["endereco"] = "Rua Apiacas, 934";
$dadosboleto["cidade_uf"] = "São Paulo / SP";
$dadosboleto["cedente"] = "Pulsar Imagens LTDA";

// NÃO ALTERAR!
include("boletophp/include/funcoes_bradesco.php");
include("boletophp/include/layout_bradesco.php");
?>
