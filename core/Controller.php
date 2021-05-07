<?php

//Controlador base e herdem todas as abilidades com a Class controller. 

abstract class Controller {

    protected function render($view, $data = null) { //metodo render qual a view vai mostra e quais os dados pode mostrar  
        
        if (!is_null($data)) {
            extract($data);
        }

        include "../views/$view.phtml"; //$view: quer dizer o ficheiro que vier com .phtml ele processa.
    }

    protected function redirect($url) { // metodo redirect: para onde sera direcionado.
        header("Location: $url");
        die();
    }

    protected function isPost() { // metodo isPost: que vai dizer se o pedido vem via POST ou não.
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }
}