<?php

class FactoryConnection{
    private $host = '';
    private $user = '';
    private $pass = '';
    private $database = '';
    private function getConnection(){
        try{
            $link = mysqli_connect($this->host, $this->user, $this->pass, $this->database);       
            $this->_link = $link;
            return $link;   
        } catch (Exception $ex){
            echo $ex->getMessage();
        }
    }
    private function checkQueryDMLSelect($query){
        $agulha   = 'SELECT';
        $pos = strpos( $query, $agulha );
        return $pos;
    }
    public function executQueryDML($sql){
        try {
            $dados = array();
            $result = mysqli_query($this->getConnection(),$sql);
            if($result){
                while($dado = mysqli_fetch_assoc($result)){
                    $dados[] = $dado;
                }
                return $dados;
            }         
        } catch (Exception $e) {      
            echo json_encode($e->getMessage());  
        }
    }
    public function  executQueryJson($sql){
        $result = mysqli_query($this->getConnection(),$sql);
        while($dados = mysqli_fetch_assoc($result)){
            $array[] = array_map('utf8_encode', $dados); 
        }
        return json_encode($array);
    }
    public function execut($sql){ 
       $return = mysqli_query($this->getConnection(), $sql);
       $this->closeConnection();
       return $return;
    }
    
    public function executLastId($sql){ 
       $return = mysqli_query($this->getConnection(), $sql);
       $id = mysqli_insert_id($this->_link);
       $this->closeConnection();
       return $id;
    }
    
    private function closeConnection(){
        mysqli_close($this->getConnection());
    }
}
