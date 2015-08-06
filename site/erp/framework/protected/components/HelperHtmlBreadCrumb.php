<?php
class HelperHtmlBreadCrumb
{
	
	private $strUrlManagerMenuFramework;
	
	private $strUrlManagerMenuOld;
	
	private $arrBreadCrumb;
	
	private $arrBreadCrumbControllerView;
		
	public function __construct($arrBreadCrumb, $arrBreadCrumbControllerView, $strUrlManagerMenuFramework, $strUrlManagerMenuOld)
	{
		$this->arrBreadCrumb = $arrBreadCrumb;
		$this->arrBreadCrumbControllerView = $arrBreadCrumbControllerView;
		$this->strUrlManagerMenuFramework = $strUrlManagerMenuFramework;
		$this->strUrlManagerMenuOld = $strUrlManagerMenuOld;
	}
	
	public function HtmlBreadCrumb()
	{	
		$strBreadcrumb = 
			'<div id="breadcrumb"><a class="tip-bottom" href="'.$this->strUrlManagerMenuOld.'main.php" data-original-title="Dashboard">Dashboard</a>
				<a href="#">'.$this->arrBreadCrumb[0].'</a>	
				<a class="current" href="'.$this->strUrlManagerMenuFramework.$this->arrBreadCrumbControllerView[0].'/'.$this->arrBreadCrumbControllerView[0].'">'.$this->arrBreadCrumb[1].'</a>
			</div>'
		;

		return $strBreadcrumb;
	}
}