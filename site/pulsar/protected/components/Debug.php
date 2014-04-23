<?php
/**
 * 
 * Debug representará um padrão para encontrar possíveis erros no desenvolvimento do sistema
 * e como identificar erros de retorno ou tipagem de variáveis 
 * 
 */
class Debug 
{
	/**
	 * 
	 * Método vai imprimir o print_r já identado para identificação do que estamos recebendo e 
	 * poderá parar a execução do código.
	 * 
	 * @Param array Matriz que contém o conteúdo a ser identificado.
	 * @Param boolean Para saber se é uma matriz simples o bidimensional.
	 * @Param boolean Para saber se deve para a codificação, por padrão parará a aplicação.
	 *  
	 */
	public function printArray($arrMatriz,$booMatriz=true, $booStop=true ) 
	{
		if($booMatriz==true)
		{
			echo '<pre>';
			print_r($arrMatriz);
			echo '</pre>';
		}
		else
		{
			foreach ($arrMatriz as $arrValor)
			{
				echo '<pre>';
				print_r($arrValor);
				echo '</pre>';
			}
		}
		if($booStop)
			exit;
	}
	/**
	 * 
	 * Executará o var_dump(veja o funcionamento no php.net).
	 * 
	 * @Param multiple Variável pode ser de qualquer tipo.
	 *  
	 */
	public function varDump($mulVar) 
	{
		var_dump($mulVar);
	}
}