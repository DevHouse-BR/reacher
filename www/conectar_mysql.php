<?php
$db = mysql_connect("localhost", "root", "") or tela_erro("Erro de conex�o com o banco: " . mysql_error(),true);
mysql_select_db ("reacher");
?>