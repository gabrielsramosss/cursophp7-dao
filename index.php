<?php 

require_once("config.php");

//Aqui ele pega o nome da classe Sql, que envia para o arquivo config.php, que acha a classe pelo nome
$sql = new Sql();

//ele vai na classe select e busca o metodo select. Entre os () eu coloco o comando.
//Crio a variavel usuario para guardar tudo que vier do select
$usuario = $sql->select("SELECT * FROM tb_usuarios");

echo json_encode($usuario);

?>