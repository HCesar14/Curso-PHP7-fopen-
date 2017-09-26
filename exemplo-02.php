<?php

require_once("config.php");

$sql = new Sql();

$usuarios = $sql->select("SELECT * from usuarios");

/*print_r($usuarios);

echo "<br/>";*/

$headers = array();

foreach ($usuarios[0] as $key => $value) {
	

	array_push($headers, ucfirst($key));
}
//echo implode("#",$headers); //usei o # como separador

$file = fopen("usuarios.csv", "w+"); //w+ escrita e se o file n existir ele o cria

fwrite($file, implode("#",$headers)."\r\n"); //ja coloca a 1 linha com os titulos

foreach ($usuarios as $row) { //percorre cada linha do array
	
	$data = array();

	foreach ($row as $key => $value) { //percorre cada coluna pegando os values, pois as keys ja foram salvas no foreach acima
		
		array_push($data, $value);
	}

	fwrite($file, implode("#", $data)."\r\n"); //adiciona no fim do arquivo e pulando uma linha para cada linha percorrida
}

fclose($file);

echo "Arquivo gerado com sucesso!";
?>