<?
require("funcoes.php");
require("permissao_documento.php");
require("conectar_mysql.php");

$modo = $_REQUEST["modo"];
$id_mala = $_REQUEST["id_mala"];
$pagina = $_REQUEST["pagina"];
$nome_mala = $_REQUEST["nome_mala"];
$assunto_mala = $_REQUEST["assunto_mala"];
$css_mala = addslashes(rawurldecode($_REQUEST["css_mala"]));
$html_mala = addslashes($_REQUEST["html_mala"]);
$data_mala = $_REQUEST["data_mala"];
$status_mala = $_REQUEST["status_mala"];
$remetente_mala = $_REQUEST["remetente_mala"];

if(empty($data_mala)) $data_mala = "NULL";
else{
	$data_mala = split("/", $data_mala);
	$data_mala = "'" . $data_mala[2] . "-" . $data_mala[1] . "-" . $data_mala[0] . "'";
}

if($modo == "apagar"){
	$query = "DELETE FROM malas WHERE id_mala='" . $id_mala . "'";
	$result = mysql_query($query) or tela_erro("Erro de conex�o ao banco de dados: " . mysql_error());
	
	$query = "DELETE FROM segmentos_malas WHERE id_mala=" . $id_mala;
	$result = mysql_query($query) or tela_erro("Erro ao atualizar registros no Banco de dados: " . mysql_error(), false);
	
	$query = "DELETE FROM malas_envios WHERE id_mala=" . $id_mala;
	$result = mysql_query($query) or tela_erro("Erro ao atualizar registros no Banco de dados: " . mysql_error(), false);
	
	$query = "DELETE FROM malas_visualizacoes WHERE id_mala=" . $id_mala;
	$result = mysql_query($query) or tela_erro("Erro ao atualizar registros no Banco de dados: " . mysql_error(), false);
	
	$mensagem = "Mala direta removida com sucesso!";
	$url = "browser_malas.php?pagina=" . $pagina;
	if($result) tela_ok($mensagem, $url);
	die();
}

if($modo == "alterar_status"){
	$query = "UPDATE malas SET status_mala = '" . $status_mala . "' WHERE id_mala='" . $id_mala . "'";
	$result = mysql_query($query) or tela_erro("Erro de conex�o ao banco de dados: " . mysql_error());
	
	$mensagem = "Status da mala direta modificado com sucesso!";
	$url = "browser_malas.php?pagina=" . $pagina;
	if($result) tela_ok($mensagem, $url);
	die();
}

if($modo == "add"){
	$query = "INSERT INTO malas (nome_mala, assunto_mala, css_mala, html_mala, data_mala, remetente_mala) VALUES ";
	$query .= "('" . $nome_mala . "', ";
	$query .= "'" . $assunto_mala . "', ";
	$query .= "'" . $css_mala . "', ";
	$query .= "'" . $html_mala . "', ";
	$query .= $data_mala . ",";
	$query .= "'" . $remetente_mala . "')";
	$result = mysql_query($query) or tela_erro("Erro ao atualizar registros no Banco de dados: " . mysql_error(), false);
	$result = mysql_query("SELECT LAST_INSERT_ID();") or tela_erro("Erro ao atualizar registros no Banco de dados: " . mysql_error(), false);
	$registro = mysql_fetch_row($result);
	$id_mala = $registro[0];
	
	foreach ($_POST as $chave => $valor){
		if(substr($chave, 0, 9) == "segmento_"){
			$id_segmento = str_replace("segmento_", "", $chave);
			$query = "INSERT INTO segmentos_malas (id_segmento, id_mala) VALUES (" . $id_segmento . "," . $id_mala . ")";
			$result = mysql_query($query) or tela_erro("Erro ao atualizar registros no Banco de dados: " . mysql_error(), false);
		}
	}

	$mensagem = "Mala Direta cadastrada com sucesso!";
	$url = "form_mala.php?modo=update&id_mala=" . $id_mala;
}
if($modo == "update"){
	$query = "UPDATE malas SET ";
	$query .= "nome_mala='" . $nome_mala . "', ";
	$query .= "assunto_mala='" . $assunto_mala . "', ";
	$query .= "css_mala='" . $css_mala . "', ";
	$query .= "html_mala='" . $html_mala . "', ";
	$query .= "status_mala='" . $status_mala . "', ";
	$query .= "remetente_mala='" . $remetente_mala . "', ";
	$query .= "data_mala=" . $data_mala;
	$query .= " WHERE id_mala='" . $id_mala . "'";
	$mensagem = "Informa��es alteradas com sucesso!";
	$url = "form_mala.php?modo=update&id_mala=" . $id_mala;
	$result = mysql_query($query) or tela_erro("Erro ao atualizar registros no Banco de dados: " . mysql_error(), false);
	
	$query = "DELETE FROM segmentos_malas WHERE id_mala=" . $id_mala;
	$result = mysql_query($query) or tela_erro("Erro ao atualizar registros no Banco de dados: " . mysql_error(), false);
	foreach ($_POST as $chave => $valor){
		if(substr($chave, 0, 9) == "segmento_"){
			$id_segmento = str_replace("segmento_", "", $chave);
			$query = "INSERT INTO segmentos_malas (id_segmento, id_mala) VALUES (" . $id_segmento . "," . $id_mala . ")";
			$result = mysql_query($query) or tela_erro("Erro ao atualizar registros no Banco de dados: " . mysql_error(), false);
		}
	}
}

if($result) tela_ok($mensagem, $url);

require("desconectar_mysql.php");
?>