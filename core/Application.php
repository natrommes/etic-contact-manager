<?php 

require_once'../core/Router.php'; // ficheiro Router.php tem class é responsavel por rotear os pedidos

class Application {
    
    private $defaultRoute = '/';
    private $router;
    

    public function __construct(){ // criando instancia do router que vai passar $uri e verificar qual a rota.
        $this->router = new Router('../configs/router.config.php');
    }

    public function run() { // run: executar cada vez que recebe um pedido da aplicação, index faz excutar este codigo. 
       $uri =$this->getUri();

       try { // cada vez que o index recebe um pedido, é verificar se o router tem a rota.
            $route = $this->router->get($uri);
            $this->invoke($route);    

        } catch (Exception $e){ // se não ouver as duas variaveis $controller, $action, caira no Catch.
             header("HTTP/1.1 404 Not found");
             die($e->getMessage());
        }
    }
      

       private function invoke($route) { // caso exista esta rota, envocaque a função invoke. o controlador, e precisa de uma rota que ele ira envocar.
          extract($route); // extrair os dados da rota e o valida. # extract: cada indice vai virar uma variavel
           
          if ($this->validateInvocation($controller, $action)) {
              $controllerInstance = new $controller(); // new $controller() = AutoController
              $controllerInstance->$action();
              return;
           }
          
          throw new Exception('404 Not Found'); // se o ficheiro não exitir, retorna falso com a mensagem.
      }


      private function validateInvocation($controller, $action) {
          $controllerPath = "../controllers/$controller.php"; 
 
          if (file_exists($controllerPath)) {
              require_once $controllerPath;
              return class_exists($controller) && method_exists($controller, $action);
           }
           return false;
        }

      
      private function getUri(){ // verificação esta no contesto da aplicação, por isto esta no private.
          return isset($_SERVER['PATH_INFO'])
            ? $_SERVER['PATH_INFO']
            : $this->defaultRoute;
        }


        
}