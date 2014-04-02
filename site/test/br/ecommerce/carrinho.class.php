
<?php
//session_start();
//session_destroy();
//instancia pagina carrinho

//class

include('ecommerce/crud.php');
class Carrinho extends Crud{
	
	public $tabela;
	private $totalgeral = 0;
	
	public function montaCarrinho(){
		// verifica se existe uma sessão

			
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
								$subtotal =  $_SESSION['produto'.$id]['valor'];
								
								echo '
									<tbody>
										<tr>
										  <td>
											<div class="imagem">
											  <img src="http://www.pulsarimagens.com.br/bancoImagens/'.$id.'.jpg" />
											  <ul class="acoes-item">
												<li class="adicionar"><a href="#">Adicionar as minhas imagens</a></li>
												<li class="remover last"><a href="ecommerce/action.php?del='.$id.'">Remover</a></li>
											  </ul>
											</div>
											<div class="descricao">
											  <ul>
												<li class="autor"><span class="label">Autor:</span> '.$data['Nome_Fotografo'].'</li>
												<li class="codigo"><span class="label">C&oacute;digo:</span> '.$id.'</li>
												<li class="uso"><span class="label">Uso:</span> Clique aqui para adicionar o uso e o pre&ccedil;o nessa imagem</li>
											  </ul>
											</div>
										  </td>
										  <td class="acoes">
											<div class="calculo-preco">
											  <div class="preco">R$ '.number_format($subtotal,2,',','.').'</div>
											  <div class="calcular"><a href="#">Calcular preço</a></div>
											</div>
										  </td>
										</tr>
									  </tbody>';
								// faz soma de todos os produtos do carrinho	  
								$this->setTotalgeral($subtotal);
							}// fim do foreach						
						}// fim do if
					} // fim do if
				}// fim do foreach	

		}//FIM DO IF
		
		if($this->getTotalgeral() == 0){
			echo 'N&atilde;o h&aacute; itens no carrinho';
			echo '<br><br></table>';
		} else {
			echo '
				<tfoot>
					<tr>
					  <td colspan="2" class="total">Total: R$ '.number_format($this->getTotalgeral(),2,',','.').'</td>
					</tr>
				</tfoot>
				</table>
				<div class="carrinho-footer">
				  <a href="#" class="finalizar-compra">Finalizar compra</a>
				  <a href="#" class="continuar-comprando">Continuar comprando</a>
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

