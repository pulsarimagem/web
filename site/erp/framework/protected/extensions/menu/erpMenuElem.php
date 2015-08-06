<?php
class erpMenuElem {
	public $name;
	public $url;
	public $icon;
	public $father;
	public $child = array();

	public function __construct($name, $url, $icon) {
		$this->name = $name;
		$this->url = $url;
		$this->icon = $icon;
	}

	
	public function getNumChild() {
		return count($this->child);
		//return 0;
	}
	
	public function getChild() {
		return $this->child;
	}
	
	function getHtml($actualPage) {
		
		
		if(($numChild = $this->getNumChild()) == 0) 
		{
			$html = "<li ".($actualPage == $this->url?"class='active'":"")."><a href='$this->url'><i class='icon $this->icon'></i> <span>$this->name</span></a></li>";
			return $html;
		}
		else 
		{
			$html = "<li class='submenu'>";
			$html .= "	<a href='$this->url'><i class='icon $this->icon'></i> <span>$this->name</span> <span class='label'>&darr;</span></a>";
			$html .= "	<ul>";
			foreach($this->getChild() as $child) 
			{
				$html .= $child->getHtml($actualPage);
			}
			$html .= "	</ul>";
			$html .= "</li>";
				
			return $html;		
		}
	}
	
	public function hasChild($page) {
		foreach($this->child as $child) {
			if($child->url == $page) {
				return true;
			}
		}
		return false;
	}
}