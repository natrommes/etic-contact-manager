<?php

require_once'../core/controller.php';
require_once'../models/UserRepository.php';

abstract class SecuredController extends Controller  {
   
    protected $users;
    protected $user;

    public function __construct() {
        $this->users = new UserRepository();

        if(!$this->users->isAuthenticated()) {
            $this->redirect('/');
        }
        $this->user = $this->users->getLoggedInUser();
    }
    
}