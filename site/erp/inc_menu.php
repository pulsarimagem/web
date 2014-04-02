<?php
class erpMenuElem {
	public $name;
	public $url;
	public $icon;
	public $father;
	public $child = array();

	function __construct($name, $url, $icon) {
		$this->name = $name;
		$this->url = $url;
		$this->icon = $icon;
	}
	
	function getNumChild() {
		return count($this->child);
	}
	
	function getChild() {
		return $this->child;
	}
	
	function getHtml($actualPage) {
		if(($numChild = $this->getNumChild()) == 0) {
			$html = "<li ".($actualPage == $this->url?"class='active'":"")."><a href='$this->url'><i class='icon $this->icon'></i> <span>$this->name</span></a></li>";
			return $html;
		}
		else {
			$html = "<li class='submenu'>";
// 			$html .= "	<a href='$this->url'><i class='icon $this->icon'></i> <span>$this->name</span> <span class='label'>$numChild</span></a>";
			$html .= "	<a href='$this->url'><i class='icon $this->icon'></i> <span>$this->name</span> <span class='label'>&darr;</span></a>";
			$html .= "	<ul>";
			foreach($this->getChild() as $child) {
				$html .= $child->getHtml($actualPage);
			}
			$html .= "	</ul>";
			$html .= "</li>";
				
			return $html;		
		}
	}
	function hasChild($page) {
		foreach($this->child as $child) {
			if($child->url == $page) {
				return true;
			}
		}
		return false;
	}
}

class erpMenu {
	public $menu;
	public $actualPage;
	public $dbConn;
	public $db;

	function __construct() {
		$this->menu = new erpMenuElem("root", "index.php", "");
		
		$currentURL = $_SERVER["PHP_SELF"];
		$partsURL = Explode('/', $currentURL);
		$this->actualPage = $partsURL[count($partsURL) - 1];
		$this->createMenuArr();
	}
	
	function connect() {
		mysql_select_db($this->db, $this->dbConn);		
	}
	
	function createMenuArr() {
		$i = 0;
		$j = 0;
		
		if($this->menu->getNumChild() == 0) {
			$this->menu->child[$i] = new erpMenuElem("Dashboard", "main.php", "icon-home"); 
			$i++; $j=0;

			$this->menu->child[$i] = new erpMenuElem("Site", "#", "icon-picture");
			$this->menu->child[$i]->child[$j] = new erpMenuElem("Relatório Download", "relatorio_download.php", ""); $j++;
			$this->menu->child[$i]->child[$j] = new erpMenuElem("Formulário Email", "envio.php", ""); $j++;
			$this->menu->child[$i]->child[$j] = new erpMenuElem("FTP", "ftp.php", ""); $j++;
			$this->menu->child[$i]->child[$j] = new erpMenuElem("Cotação", "cotacao.php", ""); $j++;
			$this->menu->child[$i]->child[$j] = new erpMenuElem("Cadastro", "cadastro.php", ""); $j++;
			$i++; $j=0;
				
			$this->menu->child[$i] = new erpMenuElem("Pagina Inicial", "pagina_inicial.php", "icon-book");
			$i++; $j=0;

			$this->menu->child[$i] = new erpMenuElem("Edição Videos", "edicao_videos.php", "icon-book");
			$i++; $j=0;
				
			$this->menu->child[$i] = new erpMenuElem("Indexação", "#", "icon-picture");
			$this->menu->child[$i]->child[$j] = new erpMenuElem("Image/Video", "indexacao.php", ""); $j++;
			$this->menu->child[$i]->child[$j] = new erpMenuElem("Alteração Lote", "indexacao_lote.php", ""); $j++;
			$this->menu->child[$i]->child[$j] = new erpMenuElem("Temas", "indexacao_temas.php", ""); $j++;
			$this->menu->child[$i]->child[$j] = new erpMenuElem("Palavras-chave", "indexacao_pc.php", ""); $j++;
			$this->menu->child[$i]->child[$j] = new erpMenuElem("Edição Videos", "edicao_videos.php", "");
			$this->menu->child[$i]->child[$j] = new erpMenuElem("Fotos sem Indexação", "fotos_sem_index.php", ""); $j++;
			$this->menu->child[$i]->child[$j] = new erpMenuElem("Indexação sem Foto", "index_sem_foto.php", ""); $j++;
			$i++; $j=0;
				
			$this->menu->child[$i] = new erpMenuElem("Mineração de Dados", "#", "icon-picture");
			$this->menu->child[$i]->child[$j] = new erpMenuElem("Comparativo Sinônimos", "sinonimos.php", "icon-briefcase"); $j++;
			$this->menu->child[$i]->child[$j] = new erpMenuElem("Relação Temas-Descritores", "temas_descritores.php", "icon-briefcase"); $j++;
			$i++; $j=0;
			
			$this->menu->child[$i] = new erpMenuElem("Autores", "profissionais.php", "icon-briefcase");
			$i++; $j=0;
				
			$this->menu->child[$i] = new erpMenuElem("Administrativo", "#", "icon-signal");
			$this->menu->child[$i]->child[$j] = new erpMenuElem("Clientes", "clientes.php", ""); $j++;
			$this->menu->child[$i]->child[$j] = new erpMenuElem("Licenças", "administrativo_licencas.php", ""); $j++;
			$this->menu->child[$i]->child[$j] = new erpMenuElem("Relatório Comissões", "administrativo_comissoes.php", ""); $j++;
			$this->menu->child[$i]->child[$j] = new erpMenuElem("Relatório Licenças", "relatorio_contratos.php", ""); $j++;
			$this->menu->child[$i]->child[$j] = new erpMenuElem("Relatório Cromo vs Licenças", "relatorio_cromos_licenca.php", ""); $j++;
			$this->menu->child[$i]->child[$j] = new erpMenuElem("Relatório Download", "relatorio_download.php", ""); $j++;
			$i++; $j=0;
				
			$this->menu->child[$i] = new erpMenuElem("Estatisticas", "#", "icon-signal");
			$this->menu->child[$i]->child[$j] = new erpMenuElem("Pauta das Pesquisas", "pauta.php", "icon-briefcase"); $j++;
			$this->menu->child[$i]->child[$j] = new erpMenuElem("Pauta das Vendas", "pauta_venda.php", "icon-briefcase"); $j++;
			$i++; $j=0;
				
			$this->menu->child[$i] = new erpMenuElem("Gerenciamento", "#", "icon-user");
			$this->menu->child[$i]->child[$j] = new erpMenuElem("Contratos", "administrativo_contratos.php", ""); $j++;
			$this->menu->child[$i]->child[$j] = new erpMenuElem("Preços", "administrativo_precos.php", ""); $j++;
			$this->menu->child[$i]->child[$j] = new erpMenuElem("Indios", "administrativo_indios.php", "");	$j++;
			$this->menu->child[$i]->child[$j] = new erpMenuElem("Usuários", "usuarios.php", ""); $j++;
			$this->menu->child[$i]->child[$j] = new erpMenuElem("Regras", "roles.php", "icon-user"); $j++;
			$this->menu->child[$i]->child[$j] = new erpMenuElem("Corte Royalt-free", "royalt_free.php", "icon-briefcase"); $j++;
			$i++; $j=0;
				
// 			$this->menu->child[$i] = new erpMenuElem("Páginas", "#pagina.php", "icon-book"); 
// 			$i++; $j=0;
			
			
// 			$this->menu->child[$i] = new erpMenuElem("Site", "#", "icon-picture");
// 			$this->menu->child[$i]->child[$j] = new erpMenuElem("Pagina Inicial", "pagina_inicial.php", ""); $j++;
// 			$this->menu->child[$i]->child[$j] = new erpMenuElem("Relatório Download", "relatorio_download.php", ""); $j++;
// 			$this->menu->child[$i]->child[$j] = new erpMenuElem("FTP", "ftp.php", ""); $j++;
// 			$this->menu->child[$i]->child[$j] = new erpMenuElem("Cotação", "cotacao.php", ""); $j++;
// 			$this->menu->child[$i]->child[$j] = new erpMenuElem("Fotos sem Indexação", "fotos_sem_index.php", ""); $j++;
// 			$this->menu->child[$i]->child[$j] = new erpMenuElem("Indexação sem Foto", "index_sem_foto.php", ""); $j++;
// 			$i++; $j=0;
			
// 			$this->menu->child[$i] = new erpMenuElem("Mineração de Dados", "#", "icon-picture");
// 			$this->menu->child[$i]->child[$j] = new erpMenuElem("Comparativo Sinônimos", "sinonimos.php", "icon-briefcase"); $j++;
// 			$this->menu->child[$i]->child[$j] = new erpMenuElem("Pauta das Pesquisas", "pauta.php", "icon-briefcase"); $j++;
// 			$this->menu->child[$i]->child[$j] = new erpMenuElem("Pauta das Vendas", "pauta_venda.php", "icon-briefcase"); $j++;
// 			$this->menu->child[$i]->child[$j] = new erpMenuElem("Relação Temas-Descritores", "temas_descritores.php", "icon-briefcase"); $j++;
// 			$this->menu->child[$i]->child[$j] = new erpMenuElem("Corte Royalt-free", "royalt_free.php", "icon-briefcase"); $j++;
// 			$i++; $j=0;
			
// 			$this->menu->child[$i] = new erpMenuElem("Profissionais", "profissionais.php", "icon-briefcase");
// 			$i++; $j=0;
			
// 			$this->menu->child[$i] = new erpMenuElem("Clientes", "clientes.php", "icon-list");
// 			$i++; $j=0;
			
// 			$this->menu->child[$i] = new erpMenuElem("Cadastro", "cadastro.php", "icon-list");
// 			$i++; $j=0;
			
// 			$this->menu->child[$i] = new erpMenuElem("Usuários", "usuarios.php", "icon-user");
// 			$i++; $j=0;
			
// 			$this->menu->child[$i] = new erpMenuElem("Regras", "roles.php", "icon-user");
// 			$i++; $j=0;
								
// 			$this->menu->child[$i] = new erpMenuElem("Administrativo", "#", "icon-signal");
// 			$this->menu->child[$i]->child[$j] = new erpMenuElem("Relatório Comissões", "administrativo_comissoes.php", ""); $j++;
// 			$this->menu->child[$i]->child[$j] = new erpMenuElem("Contratos", "administrativo_contratos.php", ""); $j++;
// 			$this->menu->child[$i]->child[$j] = new erpMenuElem("Licenças", "administrativo_licencas.php", ""); $j++;
// 			$this->menu->child[$i]->child[$j] = new erpMenuElem("Preços", "administrativo_precos.php", ""); $j++;
// 			$this->menu->child[$i]->child[$j] = new erpMenuElem("Indios", "administrativo_indios.php", "");	$j++;
// 			$this->menu->child[$i]->child[$j] = new erpMenuElem("Relatório Contratos", "relatorio_contratos.php", ""); $j++;	
// 			$this->menu->child[$i]->child[$j] = new erpMenuElem("Relatório Licença Cromo", "relatorio_cromos_licenca.php", ""); $j++;	
		}
	} 
	function createMenu($role) {
		$this->connect();
		$sql = "SELECT * FROM roles WHERE id = $role";
		$rs = mysql_query($sql, $this->dbConn) or die(mysql_error()); 
		$row = mysql_fetch_array($rs);
		
		$return = false;
		
		if($this->menu->getNumChild() == 0) {
			$this->createMenuArr();
		}
		foreach($this->menu->getChild() as $submenu) {
			$perm = isset($row[$this->getChildNoSpace($submenu->name)])?$row[$this->getChildNoSpace($submenu->name)]:-1;
			if ($perm >= 0) {
				echo $submenu->getHtml($this->actualPage);
			}
			if($submenu->url == $this->actualPage || $submenu->hasChild($this->actualPage)) {
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
?>