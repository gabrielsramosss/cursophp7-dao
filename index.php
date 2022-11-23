<?php 

require_once("config.php");

//Aqui ele pega o nome da classe Sql, que envia para o arquivo config.php, que acha a classe pelo nome
//$sql = new Sql();

//ele vai na classe select e busca o metodo select. Entre os () eu coloco o comando.
//Crio a variavel usuario para guardar tudo que vier do select
//$usuario = $sql->select("SELECT * FROM tb_usuarios");
//echo json_encode($usuario);

//Carrega um usuario 
//$root = new Usuario();
//$root->loadByid(1);
//echo $root;


//carrega uma lista de usuarios
//$lista = Usuario::getList();
//echo json_encode($lista);


//carrega uma lista de usuario buscando pelo login
//$search = Usuario::search("Ga");
//echo json_encode($search);


//carrega um usuario usando o login e a senha
$usuario = new Usuario();
$usuario->login("Gabriel","12345");

echo $usuario;
?>