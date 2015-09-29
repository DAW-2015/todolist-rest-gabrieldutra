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
        
        $app->post('/usuarios', function () {
            $system = new System();
            $system->loadUsers();
            $request = \Slim\Slim::getInstance()->request();
            $usuario = json_decode($request->getBody()); 
            $name = $usuario->name;
            $login = $usuario->login;
            $password = $usuario->password;
            $email = $usuario->email;
            $emaile = $system->checkEmail($email);
            $logine = $system->checkLogin($login);
            if($logine == 1 && $emaile == 1){
                $system->register($name,$email,$login,$password);
                echo json_encode($system->getUser($login)); 
            } else {
                if($emaile != 1){
                    echo json_encode(new Error($emaile));
                } else echo json_encode(new Error($logine));
            }
            
            //echo $usuario->nome;
            
        });
        
        $app->put('/usuarios/:id', function ($id) {
            $system = new System();
            $system->loadUsers();
            $request = \Slim\Slim::getInstance()->request();
            $usuario = json_decode($request->getBody()); 
            $name = $usuario->name;
            $password = $usuario->password;
            $query = mysqli_query($system->connection,"UPDATE mylist_users SET name='$name', password='$password' WHERE id = '$id'");
            $arr = array('success' => $query);
            echo json_encode($arr);           
        });
        
        $app->delete('/usuarios/:id', function ($id) {
            $system = new System();
            $query = mysqli_query($system->connection, "DELETE FROM mylist_users WHERE id='$id'");
            $arr = array('success' => $query);
            echo json_encode($arr); 
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
        
        $app->get('/categorias/:cat', function ($cat) {
            //$categoria = null;
            $system = new System();
            /*if($query = mysqli_query($system->connection,"SELECT id,category FROM mylist_categories WHERE id = ".$id)){
                $rowcount = mysqli_num_rows($query);               

     
                //echo "found $rowcount users";
                for($i=0;$i<$rowcount;$i++){
                  $struser = mysqli_fetch_array($query);
                  $categoria = new Category($struser["id"],$struser["category"]);
                }
            }*/
            $arr = array('id' => $system->getCategoryId($cat));
            echo json_encode($arr);
        });
        
        $app->post('/categorias', function () {
            //$categoria = null;
            $system = new System();
            $request = \Slim\Slim::getInstance()->request();
            $categoria = json_decode($request->getBody()); 
            $cat = $categoria->category;
            $query = mysqli_query($system->connection,"INSERT INTO mylist_categories (id, category) VALUES (NULL, '$cat')");
            $arr = array('success' => $query);
            echo json_encode($arr);
        });
        
        $app->put('/categorias/:id', function ($id) {
            //$categoria = null;
            $system = new System();
            $request = \Slim\Slim::getInstance()->request();
            $categoria = json_decode($request->getBody()); 
            $cat = $categoria->category;
            $query = mysqli_query($system->connection,"UPDATE mylist_categories SET category='$cat' WHERE id = '$id'");
            $arr = array('success' => $query);
            echo json_encode($arr);
        });
        
        $app->delete('/categorias/:id', function ($id) {
            $system = new System();
            $query = mysqli_query($system->connection, "DELETE FROM mylist_categories WHERE id='$id'");
            $arr = array('success' => $query);
            echo json_encode($arr); 
        });
        
        $app->get('/tarefas', function () {
            $system = new System();
            $tarefa = $system->tasks;
            //echo $usuario->nome;
            echo json_encode($tarefa); 
        });
        
        $app->get('/tarefas/:id', function ($id) {
            $system = new System();
            foreach($system->tasks as $t) {
                if($t->id == $id) echo json_encode($t);
            }
            //echo $usuario->nome;
             
        });
        
        
        $app->post('/tarefas', function () {
            $system = new System();
            $request = \Slim\Slim::getInstance()->request();
            $tarefa = json_decode($request->getBody()); 
            $cid = $system->getCategoryId($tarefa->category);
            $user = $tarefa->user;
            $uid = $user->id;
            $description = $tarefa->description;
            $query = mysqli_query($system->connection,"INSERT INTO mylist_tasks (id, user_id, category_id, description) VALUES (NULL, '$uid', '$cid', '$description')");
            $arr = array('success' => $query);
            echo json_encode($arr); 
        });
        
        $app->put('/tarefas/:id', function ($id) {
            $system = new System();
            $request = \Slim\Slim::getInstance()->request();
            $tarefa = json_decode($request->getBody()); 
            $cid = $system->getCategoryId($tarefa->category);
            $user = $tarefa->user;
            $uid = $user->id;
            $description = $tarefa->description;
            $query = mysqli_query($system->connection,"UPDATE mylist_tasks SET user_id = '$uid', category_id = '$cid', description = '$description' WHERE id = '$id'");
            $arr = array('success' => $query);
            echo json_encode($arr); 
        });
        
        
        $app->delete('/tarefas/:id', function ($id) {
            $system = new System();
            $query = mysqli_query($system->connection, "DELETE FROM mylist_tasks WHERE id='$id'");
            $arr = array('success' => $query);
            echo json_encode($arr); 
        });
        
        
        $app->run();
        ?>
    </body>
</html>
