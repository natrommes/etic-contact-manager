<?php 

//este ficheiro terá todas as rotas que a aplicação vai processar.
// quem são responsaveis pela a pagina, exe:HomeController ou MembersController

//NOTA: É comum ter varias rotas dentro da aplicação.

return [  // quando tiver somente o endereço da aplicação sem rota, indicado pela /
    '/' =>          [ 'controller' => 'AutoController', 'action'   => 'login' ],
    '/logout' =>    [ 'controller' => 'AutoController', 'action'   => 'logout'], // ação logout controldor que ira processar é o "AuthController" e a ação e o logout.
    '/signup' =>    [ 'controller' => 'AutoController', 'action'   => 'signup'],
   
    '/contacts' =>  [ 'controller' => 'ContactsController', 'action' => 'list'], // ação contactos controldor que ira processar é o "ContactsController" e a ação e o list.
    '/contacts/add' =>    [ 'controller' => 'ContactsController', 'action'  => 'create'],
    '/contacts/detail' => [ 'controller' => 'ContactsController', 'action' => 'detail'],
    '/contacts/update' => [ 'controller' => 'ContactsController',  'action'  => 'update'],
    '/contacts/remove' => [ 'controller' => 'ContactsController', 'action'  => 'remove' ],
    '/contacts/export' => [ 'controller' => 'ContactsController', 'action' => 'export' ],
    '/contacts/send'   => [ 'controller' => 'ContactsController', 'action'  => 'send'] // funcionalidade nova: enviar uma menssagem para um contato.
];  

// teremos duas class AuthController e a ContactsController.