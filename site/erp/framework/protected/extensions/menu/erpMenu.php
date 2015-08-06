<?php 
class erpMenu {
	public $menu;
	public $actualPage;
	public $dbConn;
	public $db;
	private $strUrlManagerMenuFramework;
	private $strUrlManagerMenuOld;

	function __construct() 
	{
		
		if($_SERVER['HTTP_HOST'] == 'localhost:8888')
		{
			$this->strUrlManagerMenuFramework = 'http://localhost:8888/erp_dev/framework/';
			$this->strUrlManagerMenuOld = 'http://localhost:8888/erp_dev/';
		}
		elseif($_SERVER['HTTP_HOST'] == 'erp_dev.pulsarimagens.com.br') 
		{
			$this->strUrlManagerMenuFramework = 'http://erp_dev.pulsarimagens.com.br/erp/framework/';
			$this->strUrlManagerMenuOld = 'http://erp_dev.pulsarimagens.com.br/';
		}
		
		$this->menu = new erpMenuElem("root", "index.php", "");
		
		$currentURL = $_SERVER["PHP_SELF"];
		
		$partsURL = Explode('/', $currentURL);
		
		$this->actualPage = $partsURL[count($partsURL) - 1];
		
		$this->createMenuArr();
	}
	
	function createMenuArr() 
	{
		$i = 0;
		$j = 0;
		
		if($this->menu->getNumChild() == 0) 
		{
			$this->menu->child[$i] = new erpMenuElem("Dashboard", $this->strUrlManagerMenuOld."main.php", "icon-home"); 
			$i++; $j=0;

			$this->menu->child[$i] = new erpMenuElem("Site", "#", "icon-picture");
			$this->menu->child[$i]->child[$j] = new erpMenuElem("Relatório Download", $this->strUrlManagerMenuOld."relatorio_download.php", ""); $j++;
			$this->menu->child[$i]->child[$j] = new erpMenuElem("Formulário Email", $this->strUrlManagerMenuOld."envio.php", ""); $j++;
			$this->menu->child[$i]->child[$j] = new erpMenuElem("FTP", $this->strUrlManagerMenuOld."ftp.php", ""); $j++;
			$this->menu->child[$i]->child[$j] = new erpMenuElem("Cotação", $this->strUrlManagerMenuOld."cotacao.php", ""); $j++;
			$this->menu->child[$i]->child[$j] = new erpMenuElem("Cadastro", $this->strUrlManagerMenuOld."cadastro.php", ""); $j++;
			$i++; $j=0;
				
			$this->menu->child[$i] = new erpMenuElem("Pagina Inicial", $this->strUrlManagerMenuOld."pagina_inicial.php", "icon-book");
			$i++; $j=0;

			$this->menu->child[$i] = new erpMenuElem("Edição Videos", $this->strUrlManagerMenuOld."edicao_videos.php", "icon-book");
			$i++; $j=0;
				
			$this->menu->child[$i] = new erpMenuElem("Indexação", "#", "icon-picture");
			$this->menu->child[$i]->child[$j] = new erpMenuElem("Image/Video", $this->strUrlManagerMenuOld."indexacao.php", ""); $j++;
			$this->menu->child[$i]->child[$j] = new erpMenuElem("Alteração Lote", $this->strUrlManagerMenuOld."indexacao_lote.php", ""); $j++;
			$this->menu->child[$i]->child[$j] = new erpMenuElem("Temas", $this->strUrlManagerMenuOld."indexacao_temas.php", ""); $j++;
			$this->menu->child[$i]->child[$j] = new erpMenuElem("Palavras-chave", $this->strUrlManagerMenuOld."indexacao_pc.php", ""); $j++;
			$this->menu->child[$i]->child[$j] = new erpMenuElem("Edição Videos", $this->strUrlManagerMenuOld."edicao_videos.php", "");
			$this->menu->child[$i]->child[$j] = new erpMenuElem("Fotos sem Indexação", $this->strUrlManagerMenuOld."fotos_sem_index.php?show=3", ""); $j++;
			$this->menu->child[$i]->child[$j] = new erpMenuElem("Indexação sem Foto", $this->strUrlManagerMenuOld."index_sem_foto.php", ""); $j++;
			$this->menu->child[$i]->child[$j] = new erpMenuElem("Autorização de imagem", $this->strUrlManagerMenuFramework."indexacao/autorizacao/principal/Indexação/pagina/Autorização de imagem", ""); $j++;
			$i++; $j=0;
				
			$this->menu->child[$i] = new erpMenuElem("Mineração de Dados", "#", "icon-picture");
			$this->menu->child[$i]->child[$j] = new erpMenuElem("Comparativo Sinônimos", $this->strUrlManagerMenuOld."sinonimos.php", "icon-briefcase"); $j++;
			$this->menu->child[$i]->child[$j] = new erpMenuElem("Relação Temas-Descritores", $this->strUrlManagerMenuOld."temas_descritores.php", "icon-briefcase"); $j++;
			$i++; $j=0;
			
			$this->menu->child[$i] = new erpMenuElem("Autores", $this->strUrlManagerMenuOld."profissionais.php", "icon-briefcase");
			$i++; $j=0;
				
			$this->menu->child[$i] = new erpMenuElem("Administrativo", "#", "icon-signal");
			$this->menu->child[$i]->child[$j] = new erpMenuElem("Clientes", $this->strUrlManagerMenuOld."clientes.php", ""); $j++;
			$this->menu->child[$i]->child[$j] = new erpMenuElem("Licenças", $this->strUrlManagerMenuOld."administrativo_licencas.php", ""); $j++;
			$this->menu->child[$i]->child[$j] = new erpMenuElem("Relatório Comissões", $this->strUrlManagerMenuOld."administrativo_comissoes.php", ""); $j++;
			$this->menu->child[$i]->child[$j] = new erpMenuElem("Relatório Licenças", $this->strUrlManagerMenuOld."relatorio_contratos.php", ""); $j++;
			$this->menu->child[$i]->child[$j] = new erpMenuElem("Relatório Cromo vs Licenças", $this->strUrlManagerMenuOld."relatorio_cromos_licenca.php", ""); $j++;
			$this->menu->child[$i]->child[$j] = new erpMenuElem("Relatório Download", $this->strUrlManagerMenuOld."relatorio_download.php", ""); $j++;
			$this->menu->child[$i]->child[$j] = new erpMenuElem("Relatório Não Faturadas", $this->strUrlManagerMenuOld."administrativo_naofaturadas.php", ""); $j++;
			$i++; $j=0;
				
			$this->menu->child[$i] = new erpMenuElem("Estatisticas", "#", "icon-signal");
			$this->menu->child[$i]->child[$j] = new erpMenuElem("Pauta das Pesquisas", $this->strUrlManagerMenuOld."pauta.php", "icon-briefcase"); $j++;
			$this->menu->child[$i]->child[$j] = new erpMenuElem("Pauta das Vendas", $this->strUrlManagerMenuOld."pauta_venda.php", "icon-briefcase"); $j++;
			$i++; $j=0;
				
			$this->menu->child[$i] = new erpMenuElem("Gerenciamento", "#", "icon-user");
			$this->menu->child[$i]->child[$j] = new erpMenuElem("Contratos", $this->strUrlManagerMenuOld."administrativo_contratos.php", ""); $j++;
			$this->menu->child[$i]->child[$j] = new erpMenuElem("Preços", $this->strUrlManagerMenuOld."administrativo_precos.php", ""); $j++;
			$this->menu->child[$i]->child[$j] = new erpMenuElem("Indios", $this->strUrlManagerMenuOld."administrativo_indios.php", "");	$j++;
			$this->menu->child[$i]->child[$j] = new erpMenuElem("Usuários", $this->strUrlManagerMenuOld."usuarios.php", ""); $j++;
			$this->menu->child[$i]->child[$j] = new erpMenuElem("Regras", $this->strUrlManagerMenuOld."roles.php", "icon-user"); $j++;
			$this->menu->child[$i]->child[$j] = new erpMenuElem("Corte Royalt-free", $this->strUrlManagerMenuOld."royalt_free.php", "icon-briefcase"); $j++;
			$this->menu->child[$i]->child[$j] = new erpMenuElem("Excluir do S3", $this->strUrlManagerMenuOld."administracao_s3.php", ""); $j++;
			$i++; $j=0;
		}	
			
			
	} 
	function createMenu($objParamMenu) 
	{
		$strReturn = '';
		
		if($this->menu->getNumChild() == 0) 
		{
			$this->createMenuArr();
		}
		
		foreach($this->menu->getChild() as $submenu) 
		{
			
			$perm = isset( $objParamMenu[utf8_encode($this->getChildNoSpace($submenu->name))]) ? $objParamMenu[utf8_encode($this->getChildNoSpace($submenu->name))] : -1;

			if ($perm >= 0) 
			{
				$strReturn .=  $submenu->getHtml($this->actualPage);
			}
			
			if($submenu->url == $this->actualPage || $submenu->hasChild($this->actualPage)) 
			{
				
				switch($perm) {
					case 1:
						$return = true;
						break;
					case 0:
						$return = false;
						break;
					case -1:
					default:
// 						header("location: index.php");
						break;
				}
			}
		}
		return $strReturn;

	}
	function getChildNoSpace($child) {
		$noSpaceChild = str_replace(" ", "", $child);
		return $noSpaceChild;
	}
	
	function getMenuArr() {
		$arr = array();
		foreach($this->menu->getChild() as $child) {
			$noSpaceChild = $this->getChildNoSpace($child->name);
			$arr[$noSpaceChild] = "-1";
		}
		return $arr;
	}
}