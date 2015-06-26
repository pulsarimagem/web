<?php require_once('Connections/sig.php'); ?>
<?php
$id = explode("|",$_GET['id'])[2];
$contrato = explode("|",$_GET['id'])[3];
$ret = "";
$queryDesc = "
select 
uso.Id, uso.contrato, tipo_br as tipo, utilizacao.subtipo_br as utilizacao, formato_br as formato, distribuicao_br as distribuicao, periodicidade_br as periodicidade, tamanho.descricao_br as tamanho, uso.id_tamanho
from 
USO as uso
left join USO_TIPO as tipo on uso.id_tipo = tipo.Id
left join USO_SUBTIPO as utilizacao on uso.id_utilizacao = utilizacao.Id
left join uso_formato on uso.id_formato = uso_formato.id 
left join uso_distribuicao on uso.id_distribuicao = uso_distribuicao.id 
left join uso_periodicidade on uso.id_periodicidade = uso_periodicidade.id 
left join USO_DESC as tamanho on uso.id_tamanho = tamanho.Id
left join uso_descricao on uso.id_descricao = uso_descricao.id
where uso.status != 0 AND uso.contrato like '$contrato'
order by contrato, tipo, utilizacao,formato,distribuicao,periodicidade,tamanho
";
$rsDesc = mysql_query($queryDesc, $sig) or die(mysql_error());
$return = array();
while($rowDesc = mysql_fetch_array($rsDesc)) {
	$return[$rowDesc['Id'].'|'.$rowDesc['id_tamanho']] = utf8_encode($rowDesc['Id'].'|'.$rowDesc['tipo'].'|'.$rowDesc['utilizacao'].'|'.$rowDesc['formato'].'|'.$rowDesc['distribuicao'].'|'.$rowDesc['periodicidade'].'|'.$rowDesc['tamanho']);
	if($rowDesc['Id'] == $id)
		$return['selected'] = $rowDesc['Id'].'|'.$rowDesc['id_tamanho'];
}
echo json_encode($return);
?>
