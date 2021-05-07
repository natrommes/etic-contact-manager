<?php 

// AutoController faz a gestão da autenticação: quem pode entra, sair e se registrar na aplicação. 

require_once '../core/controller.php';
require_once '../models/UserRepository.php';

class AutoController extends Controller {

    // private $message = '';
    private $users;

    public function __construct() {
      $this->users = new UserRepository();
           
    }

    public function login() {

        if ($this->isPost()) { 
           try{
               $username = $_POST['username'];
               $password = $_POST['password'];

               $this->users->attempLogin($username, $password);
               $this->redirect('/contacts');
           } catch (Exception $e) {
               $message = $e->getMessage();
           }
        }

        $this->render('login', ['message'=> isset($message) ? $message : null]);
    }

    public function logout () {
       $this->users->doLogout();
       $this->redirect('/'); 
    }

    public function signup () {
        if ($this->isPost()) {
                $username = $_POST['username'];
                $password = $_POST['password'];
                $name = $_POST['name'];

                try {
                    $this->users->signUpUser($username, $password, $name);
                    $this->redirect('/');
                } catch (Exception $e) {
                    $message = $e->getMessage(); // resultado da função signUpUser no ficheiro (UserRepository.php) que saia o resultado de erro no $result.
                }

        }

        $this->render('signup', [
        'message' => isset($message) ? $message : null
        ]);
    }

}
