<?php 

// ContactsController faz gestão dos contatos. 

require_once '../core/SecuredController.php';
require_once '../models/ContactsRepository.php';
require_once '../core/Request.php';

class ContactsController extends SecuredController {

    private $contacts;

    public function __construct() {
        parent::__construct();

        $this->contacts = new ContactsRepository ();
    }

    public function list() {
        $contacts = $this->contacts->all();

        $this->render('list', ['contacts' => $contacts]);
    }

    public function detail () {}

    public function create () { // cria nova class request.php
         if($this->isPost()) {
           $name = Request::post('name');
           $email = Request::post('email');
           $phone = Request::post('phone');
      
           try {
               $this->contacts->create($name, $email, $phone);
               $this->redirect('/contacts');
           } catch (Exception $e) {
               die($e->getMessage());
           }
         }

         $this->render('form');
    }

    public function update () {
        $id = Request::get('id');
        $contact = $this->contacts->id($id);

        if (is_null($contact)) {
            $this->redirect('/contacts');
        }

        if($this->isPost()) {
            $name = Request::post('name');
            $email = Request::post('email');
            $phone = Request::post('phone');
 
            try {
                $this->contacts->update($name, $email, $phone);
                $this->redirect('/contacts');
            } catch (Exception $e) {
                die($e->getMessage());
            }
          }
 
          $this->render('form', [
              'contacts' => $contact
          ]);
        
    }

    public function remove () {
        $id = Request::get('id');
        $contact = $this->contacts->id($id);

        if (is_null($contact)) {
            $this->redirect('/contacts');
        }
            
        try {         
            $this->contacts->remove($id);        
            $this->redirect('/contacts');
        } catch (Exception $e) {
            die($e->getMessage());
            
        }
    }

    public function export () {}

    public function send () {}

}
