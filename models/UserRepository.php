<?php

use JetBrains\PhpStorm\ExpectedValues;

require '../core/database.php';

// class Database: interagem com base dados sozinha (SELECT, DALETE, INSERT....)

class UserRepository extends Database { // interagir com base da dados para com tudo que são operações com os utilizadores. 
   
   public function getUserByUsername($username) {
      $users = $this->where('utilizadores', [ // buscar o utilizardor com metodo where
          'username' => $username]);

      return isset($users[0]) ? $users[0] : null;
  }
    public function attempLogin ($username, $password) {
        $user = $this->getUserByUsername($username);

        if (is_null($user) || !password_verify($password, $user->password)) { // função password_verify verifica se igual a password criptografada do $user->password
            throw new Exception("Bad credentials!"); // retorna uma mensagem de credencial errada.
        }

        if(session_start()== PHP_SESSION_NONE) {
            session_start();
            $_SESSION['user'] = $user;
            //return true;
        }  
    }
         
    
    public function doLogout () {
        if(session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        unset($_SESSION['user']);
    }


    public function isAuthenticated() { // verificar se o utilizador esta autenticado ou não.
        if(session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        return isset($_SESSION['user']);
    }

    public function getLoggedInUser (){ // retorna o utilizador que esta logado, da quem fez o login.
        if(session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        return $_SESSION['user'];
    }


    public function signUpUser ($username, $password, $name){ // registrar um novo usuario no banco de dados com password criptografada.
        $password = password_hash($password, PASSWORD_BCRYPT); // função password_hast com PASSWORD_BCRYPT, para cripitografar as password.
        $result = $this->insert('utilizadores', [
           'username' => $username,
           'password' => $password,
           'name' => $name
        
        ]);

        if ($result['stmt']->rowCount () < 1) {
            throw new Exception('Error signing up user');
        }
    }
    
}

// caso queira fazer login utilizar a mesma função.
