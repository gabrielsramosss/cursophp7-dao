<?php 

class Usuario {

    private $idusuario;
    private $login;
    private $senha;
    private $dtcadastro;

	public function getIdusuario() {
		return $this->idusuario;
	}
	
	public function setIdusuario($value){
		$this->idusuario = $value;
	}

	public function getLogin() {
		return $this->login;
	}
	
	public function setLogin($value){
		$this->login = $value;
	}
    public function getSenha() {
		return $this->senha;
	}
	
	public function setSenha($value){
		$this->senha = $value;
	}
    public function getDtcadastro() {
		return $this->dtcadastro;
	}
	
	public function setDtcadastro($value){
		$this->dtcadastro = $value;
	}


//metodo dos seters
public function setData($data){

    $this->setIdusuario($data['idusuario']);
    $this->setLogin($data['login']);
    $this->setSenha($data['senha']);
    $this->setDtcadastro($data['dtcadastro']);

}   


    public function loadByid($id){

        $sql = new Sql();

        $results = $sql->select("SELECT * FROM tb_usuarios WHERE idusuario = :ID", array(
//esse array que ele cria com o :ID e o parâmetro pro comando
//que aponta para o %id que é o parâmetro que recebeu lá em cima na hora que declarou o método
                ":ID"=>$id
        ));
//Pra validar que existe o ID, ele faz um if
//como o select de id só pode ser 1 número pq é primary key, o results não pode ser maior que 0       
        if (count($results) > 0){
//a posicão é 0 porque como o select retornou 1 ID só, ele ta na posição 0 do array.
//Ele pega o que retornou da posição 0 e guarda na variavel results. Que está dentro do método setData
//o método setdata carrega os valores que estão na variavel data para as respectivas variaveis
            $this->setData($results[0]);

        }
    }


//esse metodo serve pra trazer uma lista com todos os usuarios que tem na tabela
//Como nao precisamos acessar nenhum atributo fora do metodo, podemos criar de forma statica
//A vantagem de criar estatico eh que nao vai precisar instanciar esse objeto 
    public static function getList(){

        $sql = new Sql();
        return $sql->select("SELECT * FROM tb_usuarios");

    }


//Método para realizar uma busca
    public static function search($login){

        $sql = new Sql();

        return $sql->select("SELECT * FROM tb_usuarios WHERE login LIKE :SEARCH", array(
            ':SEARCH'=>"%". $login . "%"
        ));

    }

 
//pra validar os dados de login    
    public function login($login, $password){

        $sql = new Sql();

        $results = $sql->select("SELECT * FROM tb_usuarios WHERE login = :LOGIN AND senha = :PASSWORD", array(
                ":LOGIN"=>$login,
                ":PASSWORD"=>$password
        ));
//como o select de id só pode ser 1 número pq é primary key, o results não pode ser maior que 0       
        if (count($results) > 0){
//a posicão é 0 porque como o select retornou 1 ID só, ele ta na posição 0 do array.
            $this->setData($results[0]);

        } else {

             throw new Exception ("Login e/ou senha invalidos.");  

        }

    }


//metodo para insert
    public function insert(){

        $sql = new Sql();
        
//esse comando CALL chama a PROCEDURE sp_usuarios_insert configurada no banco 
//Na configuração do PROCEDURE você declara as variaveis que voce vai usar no banco, e depois o comando que ela vai executar.
//O comando PROCEDURE feito nesse caso foi:
/*CREATE PROCEDURE 'sp_usuarios_insert'(
            plogin VARCHAR(64),
            psenha(256)
)   BEGIN INSERT INTO tb_usuarios (login, senha) VALUES (plogin, psenha);
*/
        $results = $sql->select("CALL sp_usuarios_insert(:LOGIN , :PASSWORD)", array(
            'LOGIN'=>$this->getLogin(),
            'PASSWORD'=>$this->getSenha()
        ));
//Essa parte do comando é só pra mostrar na tela
        if(count($results) > 0) {
            $this->setData($results[0]);
        }
    }




//Metodo update 
//cria os dois parametros pro comando, login e password
    public function update($login, $password){
        
        $this->setLogin($login);
        $this->setSenha($password);

        $sql = new Sql();

        $sql->execQuery("UPDATE tb_usuarios SET login = :LOGIN, senha = :PASSWORD  WHERE idusuario= :ID",array(
            'LOGIN'=>$this->getLogin(),
            'PASSWORD'=>$this->getSenha(),
            ':ID'=>$this->getIdusuario()
        ));


}

//metodo delete
    public function delete(){

        $sql = new Sql();

        $sql->execQuery("DELETE FROM tb_usuarios WHERE idusuario = :ID", array(
            ':ID'=>$this->getIdusuario()

        ));
//Essa parte do comando é só pra mostrar na tela
//nao da pra eu usar o método setData porque nao vai retornar nenhum array igual quando é o select
//com isso faz o set separado pra gente selecionar o que vai retornar na tela
//        $this->setData($results);
        $this->setIdusuario(0);
        $this->setLogin("");
        $this->setSenha("");
        $this->setDtcadastro(new DateTime());

    }

//essa function __tostring eh pra mostrar os dados do metodo
    public function __toString()
    {
        return json_encode(array(
            "idusuario"=>$this->getIdusuario(),
            "login"=>$this->getLogin(),
            "senha"=>$this->getSenha(),
            "dtcadastro"=>$this->getDtcadastro()
        ));
    }
}

?>