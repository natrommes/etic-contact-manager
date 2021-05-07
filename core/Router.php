<?php

// class Router é responsavel por rotear os pedidos, logo saber que endereço que chegou e quem vai processa este endereço.

class Router {

    private $router = [];

    public function __construct(string $routesFile){ // fazer o ingeste das rotas.
        if (file_exists($routesFile)){
            $this->router = require $routesFile;
        }
    }

    public function get (string $uri): array { // função que dara uma rota, vai receber $uri e vai retornar uma array ou excessão.
       
        if (isset($this->router[$uri])) { // esta definido a rota com o $uri
           return $this->router[$uri];
       }
       throw new Exception("404 NOT Found"); // se não existir a rota, laça um 404.
    }
}
