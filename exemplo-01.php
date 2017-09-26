<?php

$file = fopen("log.txt", "a+"); //cria e abre o arquivo - tipo resource 
//w+ zera o que tinha - 
//a+ add mais no fim do arquivo

fwrite($file, date("d/m/Y H:i:s")."\r\n"); //escreve a data - \n pula linha \r fim do arquivo

fclose($file);

echo "Arquivo criado com sucesso";

?>