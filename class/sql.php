<?php 
// a classe Sql eh uma extensao da classe PDO (Nativa do php), tudo que o PDO faz, a classe sql tbm vai fazer
class Sql extends PDO {

    private $conn;

//como nao vamos precisar alterar nenhum dado da variavel, vamos usar o metodo construtor 
//(diferente do get and set)
    public function __construct()
    {
//tem que colocar o $this + nome da variável sem o $ pois o atributo está fora do metodo, 
//com isso ele precisa ser instanciado.
        $this->conn = new PDO("mysql:host=localhost;dbname=dbphp7", "root","");
    }




    private function setParams($statment, $parameters = array()){
//para nao ter que criar uma variavel para cada dado, e depois criar um bindParam pra cada um, faremos um foreach, primeiro parametro eh a variavel 
        foreach ($parameters as $key => $value) {
 //aqui ele chama o metodo setParam, que eh responsavel por fazer o bindParam      
            $this->setParam($statment ,$key, $value);

        }

    }


//Criamos o metodo para fazer o bindParam
    private function setParam($statment, $key, $value){
//bindParam eh para passar os dados da variavel criada para o parametro no comando    
        $statment->bindParam($key, $value);

}


//executar o comando no banco:
//cria um metodo publico, que recebe dois parametros, o primeiro parametro seria o comando
//o segundo parametro seria os dados, por isso eh um array
    public function execQuery($rawQuery, $params = array())
    {
//Criamos uma variavel stmt que so vai funcionar dentro desse metodo
//Com isso, pega o atributo conn e acessa o metodo prepare, ja que a classe que o atributo `conn` esta, eh a extensao da classe PDO
//o rawQuery eh o comando a ser executado
        $stmt = $this->conn->prepare($rawQuery);

//aqui a funcao execQuery chama o metodo setParams, que seta cada parametro
        $this->setParams($stmt, $params);

        $stmt->execute();

        return $stmt;

        }


//Criando a funcao select, que recebe a query, e os parametros
        public function select($rawQuery, $params = array())
        {

//aqui a variavel stmt chama o metodo execQuery, que ja faz o tratamento do parametro
        $stmt =  $this->execQuery($rawQuery, $params);

//PDO::FETCH_ASSOC eh so pra vir os dados associativos, limpar o que vai mostrar na tela
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }
    }


?>