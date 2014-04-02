
<?php
//session_start();
//session_destroy();
//instancia pagina carrinho

//class

include('ecommerce/crud.php');
class Carrinho extends Crud{
	
	public $tabela;
	private $totalgeral = 0;
	public $lingua = "br";
	
	public function montaCarrinho(){
		// verifica se existe uma sessão

		$lingua = $this->lingua;
		$isEmpty = true;
		$hasNoUse = false;
		
		if(isset($_SESSION['produto'])){
				// separando nome do produto da quantidade
				foreach($_SESSION['produto'] as $nome => $quantidade){
					//verifica se a quantidade for = 0
					if($quantidade > 0){
						
						if(substr($nome,0,9) == 'produtos_'){
							//pega o id do produto (sessao)
							$id = substr($nome,9,(strlen($nome) -9));
							$this->tabela = 'Fotos';
							$campTabela = "Fotos.Id_Foto,
										  Fotos.tombo,
										  Fotos.id_autor,
										  fotografos.Nome_Fotografo,
										  Fotos.data_foto,
										  Fotos.cidade,
										  Estados.Sigla,
										  Fotos.orientacao,
										  Fotos.dim_a,
										  Fotos.dim_b,
										  Fotos.direito_img,
										  Fotos.assunto_principal,
										  paises.nome AS pais
										  ";
							$db = $this->readJoinCarrinho($campTabela,'Fotos.tombo ="'.$id.'"');
							foreach($db as $data){
								$isEmpty = false;
								
								$subtotal =  isset($_SESSION['produto'.$id]['valor'])?$_SESSION['produto'.$id]['valor']:"0";
								$subtotal = ($lingua!="br"?convertPounds($subtotal):$subtotal);
								
								include('part_form_uso_carrinho.php');
								
								// faz soma de todos os produtos do carrinho	  
								$this->setTotalgeral($subtotal);
								if($subtotal == 0) {
									$hasNoUse = true;
								}
							}// fim do foreach						
						}// fim do if
					} // fim do if
				}// fim do foreach	

		}//FIM DO IF
		
		$total = number_format($this->getTotalgeral(),2,',','.');
		if($lingua!="br")
			$total = number_format($this->getTotalgeral(),2,'.',',');
		
//		if($this->getTotalgeral() == 0){
		if($isEmpty) {
			echo CARRINHO_VAZIO;
			echo '<br><br></table>';
		} else {
			$class = "finalizar-compra";
			if($hasNoUse)
				$class = "bloq-compra";
			
			echo '
				<tfoot>
					<tr>
					  <td colspan="2" class="total">Total: '.CARRINHO_MOEDA.' '.$total.'</td>
					</tr>
				</tfoot>
				</table>
				<div class="carrinho-footer">
				  <a href="#" class="'.$class.'">'.CARRINHO_COMPRA_BTN.'</a>
				  <a href="#" class="continuar-comprando">'.CARRINHO_CONTINUA_BTN.'</a>
				</div>
			';
			
		}
		
	}// fim da function
	
	
	public function setTotalgeral($valor){
		$this->totalgeral += $valor; 
	}
	
	public function getTotalgeral(){
		return $this->totalgeral;
		
	}
	
	
}//fim da classe


?>

