<?
require("funcoes.php");

$nome_pessoa = trim(base64_decode($_REQUEST["p"]));
$id_pessoa = trim($_REQUEST["id"]);

require("conectar_mysql.php");
$query = "UPDATE pessoas SET recebe_email_pessoa = 'n' WHERE id_pessoa=" . $id_pessoa . " AND nome_pessoa='" . $nome_pessoa . "'";
$result = mysql_query($query) or tela_erro("Erro de conex�o ao banco de dados: " . mysql_error(), false);
require("desconectar_mysql.php");

inicia_pagina_sem_menu();
inicia_quadro_branco('width="500"', 'Sucesso!'); ?>
	<table width="100%">
		<tr>
			<td><img src="imagens/ok.jpg"></td>
			<td>Voc� foi removido da nossa lista de emails. Obrigado por utilizar nosso servi�o!</td>
		</tr>
	</table>
<?
termina_quadro_branco(); 
termina_pagina();
?>