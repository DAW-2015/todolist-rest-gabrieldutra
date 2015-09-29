<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        include 'functions.php';
        require 'Slim/Slim.php';
        \Slim\Slim::registerAutoloader();
        $app = new \Slim\Slim();
        $app->response->headers->set('ContentType','application/json');
        $app->get('/usuarios', function () {
            $system = new System();
            $usuario = $system->users;
            //echo $usuario->nome;
            echo json_encode($usuario); 
        });
        
        $app->post('/usuarios/:name/:login/:password/:email', function ($name,$login,$password,$email) {
            $system = new System();
            $emaile = $system->checkEmail($email);
            $logine = $system->checkLogin($login);
            if($logine == 1 && $emaile == 1){
                $system->register($name,$email,$login,$password);
                echo json_encode($system->getUser($login)); 
            } else {
                if($emaile != 1){
                    echo json_encode(emaile);
                } else echo json_encode(logine);
            }
            
            //echo $usuario->nome;
            
        });
        
        $app->get('/usuarios/:id', function ($id) {
            $system = new System();
            foreach($system->users as $u) {
                if($u->id == $id) echo json_encode($u);
            }
            //echo $usuario->nome;
             
        });
        
        $app->get('/categorias', function () {
            $categorias = null;
            $system = new System();
            if($query = mysqli_query($system->connection,"SELECT id,category FROM mylist_categories")){
                $rowcount = mysqli_num_rows($query);               

     
                //echo "found $rowcount users";
                for($i=0;$i<$rowcount;$i++){
                  $struser = mysqli_fetch_array($query);
                  $categorias[sizeof($categorias)] = new Category($struser["id"],$struser["category"]);
                }
            }
            echo json_encode($categorias);
        });
        
        $app->get('/categorias/:id', function ($id) {
            $categoria = null;
            $system = new System();
            if($query = mysqli_query($system->connection,"SELECT id,category FROM mylist_categories WHERE id = ".$id)){
                $rowcount = mysqli_num_rows($query);               

     
                //echo "found $rowcount users";
                for($i=0;$i<$rowcount;$i++){
                  $struser = mysqli_fetch_array($query);
                  $categoria = new Category($struser["id"],$struser["category"]);
                }
            }
            echo json_encode($categoria);
        });
        
        
        $app->run();
        ?>
    </body>
</html>
