<?php require_once('Connections/pulsar.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
<title>Pulsar Imagens</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<?php include("scripts.php");?>
</head>
<body>

<?php include("part_topbar.php")?>

<div class="main size960">

<!--<?php //include("part_grid_left_pergunta.php")?>-->

	<div class="grid-center">
		<div class="faq">
			<h2>Perguntas mais frequentes</h2>
		  <p class="p">Nessa �rea voc� encontra todas as informa��es sobre o funcionamento do nosso site. Confira abaixo as perguntas mais frequentes e tire todas as suas d�vidas.</p>
			<ul>
				<li>
					<h3> A conta no Pulsar � paga?</h3>
					N�o. A cria��o de uma conta no site � gratuita. Atrav�s dela � poss�vel realizar cota��es e armazenar suas fotos prediletas.
				</li>
				<li>
					<h3>Por que se cadastrar no site?</h3>
					Ao se cadastrar, voc� poder� utilizar as diversas ferramentas que o site disp�e para facilitar o seu trabalho.
				</li>
				<li>
					<h3>Como fa�o para me cadastrar?</h3>
					Selecione a op��o Cadastro no menu e preencha todos os campos observando apenas se voc� deseja se cadastrar como Pessoa F�sica ou Jur�dica.
				</li>
				
				<li>
					<h3>Busca</h3>
Voc� poder� iniciar a sua pesquisa de duas formas:
<br/><br/>
- Palavra-Chave<br/>
digite aqui a palavra-chave (ou descritor) que deseja pesquisar e confirme. O retorno de sua busca logo aparecer�, mencionando o termo pesquisado e o n�mero de imagens encontradas. Voc� poder� escolher o n�mero de fotos que deseja mostrar em cada tela e ver sua pesquisa atrav�s dos thumbnails ou das imagens ampliadas. Neste caso voc� poder� ler todas as identifica��es pertencentes a cada uma delas.<br/>
- C�digo<br/>
caso voc� saiba o c�digo de identifica��o da imagem que deseja visualizar basta digit�-lo no campo correspondente e confirmar. O retorno ser� imediato. Se voc� digitou o c�digo errado o sistema emitir� uma mensagem de erro informando. 
				</li>
				<li>
					<h3>Temas</h3>
Criamos uma rela��o de Temas para facilitar sua busca. Basta percorr�-la com o mouse e os assuntos aparecer�o. Se voc� se interessar por um deles clique e as fotos relacionadas aparecer�o.
<br/><br/>
Sempre que voc� escolher o termo mais gen�rico ter� como retorno todas as imagens que possam ter rela��o com o assunto selecionado. Por�m se selecionar alguma subdivis�o poder� visualizar as imagens mais espec�ficas.<br/>
Por exemplo: se voc� clicar em Natureza / Parques Nacionais ver� todas fotos relacionadas aos Parques Nacionais dispon�veis no site. Mas se escolher Natureza / Parques Nacionais / Parque Nacional Das Emas (GO) ver� apenas as fotos relacionadas a esse Parque. 
				</li>
				<li>
					<h3>Pesquisa Avan�ada</h3>
Essa se��o permite que voc� fa�a suas pesquisas de forma mais pontual. Disponibilizamos diversas ferramentas de busca que, combinadas entre si, poder�o retornar as fotos mais espec�ficas.<br/>
Usando a op��o �E� voc� obt�m a soma de um ou mais termos. Por exemplo:<br/>
Soja �E� Colheita � retornar�o fotos apenas da colheita da soja. N�o vir�o todas as fotos de soja nem todas as fotos de colheita.<br/>
Soja �N�o Contenha a Palavra� Colheita � retornar�o todas as fotos de soja dispon�veis, exceto as de colheita da soja.<br/>
Poder� ser feita uma combina��o de assunto e autor de forma a visualizar somente as fotos que determinado autor produziu sobre o assunto.<br/>
Escolhendo apenas o nome do autor, sem determinar o assunto, voc� poder� visualizar todas as fotos desse autor que est�o dispon�veis no site.<br/>
Pode-se tamb�m determinar a orienta��o das fotos, caso voc� deseje apenas Horizontal ou Vertical e, clicando nos dois campos, vir�o ambas as orienta��es.<br/>
Todos esses campos poder�o ser trabalhados isoladamente ou em conjunto. A elabora��o de sua estrat�gia de pesquisa definir� a consist�ncia de seu retorno. 
				</li>
                <li>
                <h3>Pesquisa por Estado</h3>
Dentro da Pesquisa Avan�ada criamos um mapa do Brasil dividido em estados. Cada �rea � destacada conforme o mouse pousa sobre a mesma. Ao clicar sobre o estado todos os temas que s�o relativos aquela regi�o s�o mostrados possibilitando uma filtragem na busca de acordo com a regi�o de interesse.

                </li>
		  <li>
					<h3>Retorno de Pesquisa</h3>
Ao fazer uma pesquisa a p�gina seguinte trar� o n�mero de fotos encontradas sobre o assunto. No canto superior direito, voc� poder� escolher o n�mero de fotos que deseja exibir em sua tela.
Ao rolar o mouse sobre a imagem voc� ter� acesso as informa��es b�sicas da foto. Passando o mouse sobre a lupa e poss�vel visualizar uma vers�o maior da imagem. Para adicionar imagens a Minhas Imagens, basta clicar sobre o �cone de l�mpada e selecionar a pasta em que deseja adicionar a imagem.<br /> Clicando sobre a imagem ela ser� ampliada com as principais informa��es de identifica��o desta imagem. Ao p� da p�gina de retorno existe uma seq��ncia num�rica referente ao n�mero de p�ginas que cont�m o resultado de sua pesquisa. O n�mero que aparecer em negrito refere-se � p�gina que voc� est� visualizando. Clique sobre o n�mero seguinte ou apenas na op��o �pr�xima p�gina� para continuar visualizando sua pesquisa.				</li>
				<li>
					<h3>Amplia��o de Imagem</h3>
Quando voc� estiver visualizando uma foto ampliada, ver� tamb�m as principais informa��es de identifica��o desta imagem. As informa��es b�sicas de cada imagem s�o: c�digo de identifica��o da foto, assunto principal, autor da foto, local da foto (cidade, Estado, ou pa�s), data de realiza��o da foto (dia/ m�s/ano), autor da foto e as dimens�es do arquivo em alta resolu��o.<br/>
As outras informa��es s�o interativas. O campo �Temas� s�o links que poder�o te remeter a novas pesquisas dentro do site. �Palavras-chave � s�o Tags que podem ser adicionadas a busca possibilitando um cruzamento desses termos para gerar uma nova pesquisa.<br/>
Existem tamb�m outras ferramentas de trabalho:
<br/><br/>
- Salvar<br/>
Voc� poder� salvar a imagem selecionada, em baixa resolu��o, em seu microcomputador. O uso dessa imagem, por�m, dever� sempre obedecer �s leis de Direitos Autorais (copyright) mencionadas abaixo.
<br/><br/>
- Adicionar �s Minhas imagens<br/>
Clicando nesse bot�o voc� enviar� essa imagem a uma �rea em nosso site onde voc� poder� fazer e salvar sua sele��o pessoal.<br/>
Clique aqui para saber mais sobre a �rea �Minhas imagens�
<br/><br/>
- Enviar por e-mail<br/>
Voc� poder� enviar esta foto para um ou mais e-mail(s) que desejar. Preencha o campo com seu nome e endere�o de e-mail para que sirva como identifica��o de remetente. Se quiser inserir alguma observa��o para acompanhar a foto, escreva no campo �Coment�rios�. O destinat�rio de sua mensagem poder� ler seu texto e visualizar a imagem que voc� enviou.
<br/><br/>
- Cotar<br/>
Clicando nesse bot�o voc� poder� proceder � cota��o de pre�o da imagem selecionada. Clique aqui para saber mais sobre a utiliza��o da �rea de �Cota��o.
<br/><br/>
- Download<br/>
Essa funcionalidade permite que voc� baixe a imagem em m�dia ou alta resolu��o diretamente do site. Para poder utilizar essa ferramenta voc� dever� efetuar seu cadastro �Pessoa Jur�dica�. Com base nas informa��es fornecidas nesse cadastro a Pulsar ir� liberar seu acesso, determinando o n�mero de fotos por dia que sua empresa poder� baixar para arquivos em alta. Para arquivos de layout o uso ser� liberado. � importante esclarecer que todas as fotos em alta resolu��o baixadas , n�o sendo solicitadas como layout, ser�o cobradas. 
Uma vez autorizado seu acesso o procedimento a seguir ser�:
<br />
1) fazer a pesquisa utilizando o c�digo da foto ou palavra-chave,
<br />
2) clicar sobre a foto escolhida,
<br />
3) na barra inferior da foto ampliada, clicar sobre o bot�o DOWNLOAD. Certifique-se que voc� esta devidamente logado,<br />
4) Selecionar a op��o desejada: Download ou Layout,<br />
5) Preencher os campos solicitados. <br />
<strong>Para imagens de Download em alta resolu��o voc� deve clicar em �ACEITO�. Nesse momento voc� confirmar� seu interesse no download, assumindo seu compromisso de compra,</strong> <br />
6) Salvar a foto em seu computador. 

<br/><br/>
- Avan�ar / Voltar<br/>
H� ainda as op��es de avan�ar e / ou voltar as imagens de sua pesquisa. Clicando sobre um destes �cones voc� ver� a imagem tamb�m ampliada que est� imediatamente anterior ou posterior �quela que voc� est� visualizando, podendo ir dessa forma at� o come�o ou final de sua pesquisa. 
				</li>
				
				<li>
					<h3>Minhas imagens</h3>
"Minhas imagens" � uma �rea em nosso site onde voc� poder� fazer e salvar sua sele��o pessoal. Essa se��o foi criada para que voc� tenha sua pr�pria �rea de trabalho dentro do site.<br/>
Abaixo da foto ampliada existe um link "Adicionar" que encaminhar� a imagem para uma pasta criada e nomeada por voc�.<br/>
Essa se��o permite o envio de pastas por e-mail, altera��o de dados em seu cadastro, exclus�o de imagens e muito mais. Aqui voc� ver� todas as imagens que separou, poder� concluir sua sele��o e cotar sua edi��o.
<br/><br/>
Para utilizar essa se��o voc� precisa ser cadastrado.<br/>
Caso ainda n�o seja, voc� dever� fazer seu cadastro na respectiva se��o.<br/>
Se voc� perdeu sua senha clique na op��o �Esqueceu sua senha?�, digite o email cadastrado e ela ser� enviada.
<br/><br/>
- Criar Nova<br/>
Clicando aqui voc� poder� criar uma nova pasta para reunir suas fotos. Basta atribuir um nome para essa pasta e clicar em �Criar Pasta�. Automaticamente sua pasta estar� pronta para receber as imagens selecionadas por voc�.
<br/><br/>
- Renomear<br/>
Essa ferramenta foi criada para que voc� possa atribuir um novo nome a uma pasta j� existente.<br/>
Basta selecionar a pasta que deseja renomear, clicar no bot�o e ent�o digitar o novo nome escolhido. Clique finalmente no bot�o �Renomear� e sua pasta aparecer� com seu novo nome. Seu conte�do permanecer� inalterado.
<br/><br/>
- Mesclar<br/>
Caso voc� precise mesclar duas ou mais pastas no transcorrer do seu trabalho, selecione as pastas que deseja reunir e clique em �Mesclar�. D� o novo nome que deseja � essa fus�o e confirme clicando em Mesclar no pop onde digitou o nome. A nova pasta estar� criada reunindo o conte�do das pastas que haviam sido selecionadas. Essas, por�m, permanecer�o na rela��o de pastas aguardando sua ordem de exclus�o. Isso permite que voc� re�na pesquisas diversas de v�rias formas, sem perder a sua pesquisa inicial.<br/>
Essa ferramenta tamb�m serve para a duplica��o de uma pasta. Basta selecionar a pasta que deseja duplicar e clicar no bot�o �Mesclar�, atribua nome � nova pasta e confirme clicando novamente em �Mesclar�.
<br/><br/>
- Excluir<br/>
Para excluir uma pasta basta selecion�-la e clicar em �Excluir�. Ela ser� automaticamente removida da sua rela��o de pastas.
<br/><br/>
- Cotar<br/>
Clique na foto desejada e selecione a op��o �Cotar�. Confirme o pedido. A foto ser� encaminhada � �rea de cota��o. Maiores explica��es voc� encontrar� na se��o espec�fica �Cota��o�.
<br/><br/>
- Enviar pasta por e-mail<br/>
Essa ferramenta permite que voc� envie uma pasta para uma outra pessoa. Selecione a pasta que deseja enviar clicando no quadrado que se encontra � esquerda do "Nome da Pasta". Clique ent�o em "Enviar pasta por e-mail". Surgir� uma tela onde voc� dever� preencher o seu nome e e-mail, para efeito de identifica��o. A seguir digite o e-mail da pessoa para quem deseja enviar a pasta. Preencha o campo �Com c�pia para� caso deseje envi�-la a uma terceira pessoa. Se quiser acrescentar algum coment�rio � sua sele��o ou apenas ressaltar alguma observa��o preencha o campo �Coment�rios�. Ao final clique em enviar.
				</li>
				<li>
					<h3>Cota��o</h3>
Ao abrir esta p�gina voc� ver� as fotos que havia selecionado para cotar. Antes de solicitar a cota��o final voc� poder� excluir alguma imagem selecionando-a e apertando o bot�o �Excluir cromos�. Caso voc� confirme a exclus�o a foto selecionada ter� sido eliminada deste processo.
Na �rea de Cota��o, ao clicar em �Cotar� surgir� uma tela onde voc� dever� fazer uma descri��o do uso que dar� para a(s) foto(s) escolhida(s). Quanto mais espec�fica for a sua descri��o mais objetiva ser� a atribui��o do valor a ser cobrado pela(s) foto(s). Finalmente especifique se a distribui��o do produto onde a(s) foto(s) ser�(�o) utilizada(s) ser� Nacional ou internacional. 
				</li>
				<li>
					<h3>Cadastro</h3>
� necess�rio o preenchimento deste campo para que voc� possa utilizar as diversas ferramentas que o site disp�e para facilitar seu trabalho. Preencha todos os campos do cadastro, observando apenas se voc� deseja se cadastrar como Pessoa F�sica ou Jur�dica. Guarde bem sua senha porque ela ser� solicitada em outras �reas deste site.<br/>
Todas as informa��es fornecidas neste cadastro jamais ser�o utilizadas para qualquer outro uso que n�o seja estritamente relacionado � administra��o deste site. <br /><br />

Para alterar seu cadastro, basta voc� esta logado e clicar no link Cadastro. Altere os dados desejados e clique em �Confirmar altera��o� para finalizar.				</li>
				<li><a id="copyright"></a>
					<h3>Copyright</h3>
Estes termos constituem o acordo legal entre voc� e a PULSAR IMAGENS. Favor ler estas condi��es antes de continuar a usar o site ou fazer um �download� de alguma fotografia.
<br/><br/>
Este website � de propriedade da Pulsar Imagens Ltda. Tudo o que for mostrado aqui incluindo fotografias, textos, design e softwares pertencem a Pulsar Imagens e a seus representantes licenciados e est�o protegidas pelas leis nacionais e internacionais de Direito Autoral (Copyright).
<br/><br/>
N�o � permitida a utiliza��o total ou de qualquer fragmento de imagem para fins publicit�rios, editoriais ou qualquer outra forma de divulga��o ou comunica��o, por qualquer meio, sem a expressa autoriza��o da Pulsar Imagens.<br/>
Essa autoriza��o se tornar� efetiva mediante a emiss�o de Nota Fiscal e/ou Licen�a de Reprodu��o de Obra Fotogr�fica por parte da Pulsar Imagens.
<br/><br/>
Para ter acesso �s �reas restritas deste site e fazer o �download� de fotografias voc� dever� ser cadastrado.<br/>
A Pulsar Imagens respeitando seu direito � privacidade n�o fornecer� a terceiros suas informa��es cadastrais, incluindo nome e e-mail.
<br/><br/>
As identifica��es das imagens contidas neste site s�o de responsabilidade total de seus autores, cabendo a Pulsar Imagens somente a sua reprodu��o.
<br/><br/>
As imagens digitais possuem diversos tamanhos o que poder� inviabilizar alguns usos. Consulte nosso pessoal de apoio antes de concluir seu trabalho.
<br/><br/>
N�o comercializamos imagens �royalty free�.
<br/><br/>
N�o nos responsabilizamos por qualquer processo advindo do mau uso de uma imagem por n�s licenciada, seja qual for a imagem. O autor do uso ser� seu �nico respons�vel.
<br/><br/>
Para esclarecer qualquer d�vida, por favor, entre em contato 
				</li>				
			</ul>
		</div>
	</div>
	<div class="clear"></div>
</div>

<?php include("part_footer.php")?>

</body>
</html>
