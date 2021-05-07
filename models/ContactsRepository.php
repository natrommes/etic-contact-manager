<?php

use JetBrains\PhpStorm\ExpectedValues;

require_once '../core/Database.php';

class ContactsRepository extends Database { // interagir/gerir os contatos dentro da base de dados.

    private $contacts;

    public function all() {
      return $this->select('contatos');
    }

    public function id($id) {
      return $this->byId('contatos', $id);
    }

    public function create($name, $email, $phone = null){
  
       $result = $this->insert('contatos', [
         'name' => $name,
         'email' => $email,
         'phone' => $phone
       ]);

       if ($result['stmt']->rowCount() < 1) {
         throw new Exception('Error creating contact');
       }
    }

    public function edit ($id, $name, $email, $phone = null) {
      $stmt = $this->update('contatos', [
        'name' => $name,
        'email' => $email,
        'phone' => $phone
      ], ['id' => $id]);

      if ($stmt->rowCount() < 1) {
        throw new Exception('Error updating contact');
      }
    }

    public function remove ($id){
      $stmt = $this->delete('contatos', ['id' => $id]);

      if($stmt->rowCount() < 1) {
        throw new Exception('Error updating contact');
      }
    }

    public function export (){

    }

    public function upload ($file){

    }

    public function sendMessage($id, $message){

    }
}