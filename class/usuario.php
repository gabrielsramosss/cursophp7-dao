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

    public function loadByid($id){

        $sql = new Sql();

        $results = $sql->select("SELECT * FROM tb_usuarios WHERE idusuario = :ID", array(
                ":ID"=>$id
        ));
//como o select de id só pode ser 1 número pq é primary key, o results não pode ser maior que 0       
        if (count($results) > 0){
//a posicão é 0 porque como o select retornou 1 ID só, ele ta na posição 0 do array.
            $row = $results [0];

            $this->setIdusuario($row['idusuario']);
            $this->setLogin($row['login']);
            $this->setSenha($row['senha']);
            $this->setDtcadastro($row['dtcadastro']);

        }

    }

//esse metodo serve pra trazer uma lista com todos os usuarios que tem na tabela
//Como nao precisamos acessar nenhum atributo fora do metodo, podemos criar de forma statica
//A vantagem de criar estatico eh que nao vai precisar estanciar esse objeto 
    public static function getList(){

        $sql = new Sql();
        return $sql->select("SELECT * FROM tb_usuarios");

    }



    public static function search($login){

        $sql = new Sql();

        return $sql->select("SELECT * FROM tb_usuarios WHERE login LIKE :SEARCH", array(
            ':SEARCH'=>"%". $login . "%"
        ));

    }

    
    public function login($login, $password){

        $sql = new Sql();

        $results = $sql->select("SELECT * FROM tb_usuarios WHERE login = :LOGIN AND senha = :PASSWORD", array(
                ":LOGIN"=>$login,
                ":PASSWORD"=>$password
        ));
//como o select de id só pode ser 1 número pq é primary key, o results não pode ser maior que 0       
        if (count($results) > 0){
//a posicão é 0 porque como o select retornou 1 ID só, ele ta na posição 0 do array.
            $row = $results [0];

            $this->setIdusuario($row['idusuario']);
            $this->setLogin($row['login']);
            $this->setSenha($row['senha']);
            $this->setDtcadastro($row['dtcadastro']);

        } else {

             throw new Exception ("Login e/ou senha invalidos.");  

        }

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