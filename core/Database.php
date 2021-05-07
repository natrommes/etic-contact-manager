<?php
//Class fara varias ações de forma automatizada.

class Database { // class faz a conecção com base dados Mysql.
    private $connection;

    public function connect($configFile = '../configs/database.config.php'){
        extract($this->ingestConfigFile($configFile));
        $dsn = sprintf("mysql:host=%s;dbname=%s;port=%d", $host, $name, $port);
   
        try {
            return new PDO($dsn, $user, $pass,[
               PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
            ]);
        } catch (PDOException $e) {
            die ('Error connecting to database.' . $e->getMessage());
        }
    }

    private function ingestConfigFile($configFile){
        if (!file_exists($configFile)){
            throw new Exception('Database config not found'); 
        }
        $config = require $configFile;
        return $config;
    }

    
    // criando todos os Metodos(função) que seguem data automação a base dadados.

    public function query ($sql){ // retorna o resultado do sql.
       $this->connection = $this->connect(); // propriedade da class: connection 
       return $this->connection->query($sql);
    }


    public function select ($table) { // dizer qual a tabela, e ele ira dizer o resultado da tabela.
       $stmt = $this->query("SELECT * FROM $table");
       return $stmt->fetchAll(); // criando string que seram retornadas.
    }


    public function where ($table, $where) { // qual tabela e a condição do where, ele ira dizer todos os resultados filtrados com a condição que eu passo.
       $where = $this->getWhere($where); // $where passara os dados do getwhere
       $stmt = $this->query("SELECT * FROM $table WHERE $where");
       return $stmt->fetchAll();
    }


    public function byId ($table, $id, $idField = 'id') { // qual tabela, o id e qual é o campo id da tabela sera id
       $rs = $this->where($table, "$idField = $id");  // rs: resolt set
       return isset($rs[0]) ? $rs[0] : null;
    }


    public function insert ($table, $data) { // qual tabela e os dados que quero inserir nela.
        $fields = array_keys($data);
        $values = array_values($data);

        $fieldsAsString = implode(', ', $fields);
        $valuesAsString = implode("', '", $values);

        $sql = "INSERT INTO $table ($fieldsAsString) VALUES ('$valuesAsString')";
        $stmt = $this->query($sql);

        return [
            'stmt' => $stmt,
            'insertedId' => $this->connection->lastInsertId()
        ];
    }


    public function update ($table, $data, $where) { // qual é tabela, os dados e a condição para alterar a tabela.
        $pairs = $this->pairs($data);
        $pairsAsString = implode(', ', $pairs);
        
        $where = $this->getWhere($where);
        $sql = "UPDATE $table SET $pairsAsString WHERE $where";
        
        return $this->query($sql);
    } 


    public function delete ($table, $where){ // qual tabela e condição para deletar a tabela.
        $where = $this->getWhere($where);
        $sql = "DELETE FROM $table WHERE $where";

        return $this->query($sql);
    } 


    public function exists ($table, $field, $value) { // de um deteterminado registro existe dentro da tabela.
        $sql = "SELECT COUNT(*) AS counter FROM $table WHERE $field = '$value' LIMIT 1";
        $stmt = $this->query($sql);
        $row = $stmt->fetch();

        return $row && $row->counter > 0;
    }

    private function pairs ($data) {
        $pairs = [];
        foreach ($data as $key => $value) {
            $pairs[] = "$key = '$value'";
        }
        return $pairs;
    }

    private function getWhere ($where) { // converter where para uma string do where.
       if(is_array($where)){ // converte a array numa string.
           $pairs = $this->pairs($where);
           return implode(' AND', $pairs); // vou ter os dados neste linha: ['username' => 'Alberto', 'id' => 3]
       }  // implode = join (junção de array) no JS.

       return $where;
    }

}

