<?php 

//spl para carregar onde vai estar as nossas classes, a funcao anonima recebe o nome da classe que ta sendo chamada
spl_autoload_register(function($class_name){

//precisamos mostrar em qual diretorio vai procurar    
    $filename = "class". DIRECTORY_SEPARATOR . $class_name. ".php";

//if pra ver se o arquivo que ta no caminho filename existe
    if(file_exists(($filename))) {

//Se existir, ele faz a importacao do arquivo        
        require_once($filename);

    }

});

?>