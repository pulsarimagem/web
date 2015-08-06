<?php
class HelperHtmlPaginaCabecalho
{
	
	public function HtmlTituloPagina($arrBreadCrumb)
	{
		return '
			<div id="content-header">
				<h1>'.$arrBreadCrumb[1].'</h1>
			</div>
		';
	}
	
}