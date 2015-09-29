<?php
//session_start();

class User{
  var $id;
  var $name;
  var $email;
  var $login;
  var $password;

  function User($id, $nam,$ema,$log,$pas){
    $this->id = $id;
    $this->name = $nam;
    $this->email = $ema;
    $this->login = $log;
    $this->password = $pas;
  }

  function __toString(){
    return $this->login;
  }
}

class Category{
  var $id;
  var $category;

  function Category($id, $cat){
    $this->id = $id;
    $this->category = $cat;
  }

}

class Task{
  var $id;
  var $user;
  var $description;
  var $category;
  var $status;

  function Task($id, $use,$des,$cat,$sta){
    $this->id = $id;
    $this->user = $use;
    $this->description = $des;
    $this->category = $cat;
    $this->status = $sta;
  }
}

class Error{
    var $error;
    var $description;
    function Error($description){
        $this->error=true;
        $this->description = $description;
    }
}

class System{
  var $users;
  var $tasks;
  var $connection;
  function System(){
    // Lista usuários do sistema
    $this->connection = mysqli_connect("alunos.coltec.ufmg.br","daw-aluno3","gabriel","daw-aluno3");
    $this->loadUsers();
    $this->loadTasks();
  }

  function loadUsers(){
    if($query = mysqli_query($this->connection,"SELECT id,name,email,login,password FROM mylist_users")){
      $rowcount = mysqli_num_rows($query);

      $this->users = null;
      //echo "found $rowcount users";
      for($i=0;$i<$rowcount;$i++){
        $struser = mysqli_fetch_array($query);
        $this->users[sizeof($this->users)] = new User($struser["id"],$struser["name"],$struser["email"],$struser["login"],$struser["password"]);
      }
    }

    /*
    $this->users = null;
    $loginlist = fopen("db/login.txt","r");
    if($loginlist){
      while(!feof($loginlist)){
        $str = fgets($loginlist);
        $struser = str_getcsv($str);
        if(sizeof($struser) != 4) continue;
        $this->users[sizeof($this->users)] = new User($struser[0],$struser[1],$struser[2],$struser[3]);
      }
      fclose($loginlist);
    }*/
  }

  function taskExists($description,$category,$status){
    foreach($this->tasks as $task){
      if($task->user == $_SESSION["user"] && $category == $task->category && $status == $task->status && $description == $task->description) return true;
    }
    return false;
  }

  function remSTask($description,$category,$status){
    foreach($this->tasks as $task){
      if($task->user == $_SESSION["user"] && $category == $task->category && $status == $task->status && $description == $task->description) {
        $this->remTask($task);
        return true;
      }
    }
    return false;
  }

  function loadTasks(){
    $query = mysqli_query($this->connection,"SELECT mylist_tasks.id, mylist_tasks.description,mylist_categories.category,mylist_users.login FROM mylist_tasks JOIN mylist_categories ON mylist_categories.id = mylist_tasks.category_id JOIN mylist_users ON mylist_users.id = mylist_tasks.user_id");
    $rowcount = mysqli_num_rows($query);
    $this->tasks = null;
    //echo "found $rowcount tasks";
    for($i=0;$i<$rowcount;$i++){
      $strtask = mysqli_fetch_array($query);
      $this->tasks[sizeof($this->tasks)] = new Task($strtask["id"],$this->getUser($strtask["login"]),$strtask["description"],$strtask["category"],"Em Progresso");
    }
    /*
    $this->tasks = null;
    $tasklist = fopen("db/tasks.txt","r");
    if($tasklist){
      while(!feof($tasklist)){
        $str = fgets($tasklist);
        $strtask = str_getcsv($str);
        if(sizeof($strtask) != 4) continue;
        $this->tasks[sizeof($this->tasks)] = new Task($this->getUser($strtask[0]),$strtask[1],$strtask[2],$strtask[3]);
      }
      fclose($tasklist);
    }*/
  }

  function getCategories(){
    $categories = array(0 => "Pessoal", 1=> "Trabalho", 2=> "Outros");
    foreach($this->tasks as $task){
      if($task->user == $_SESSION["user"]) {
        $exists=0;
        foreach($categories as $cat) if($cat == $task->category) $exists=1;
        if($exists==1) continue;
        $categories[sizeof($categories)] = $task->category;
      }
    }
    return $categories;
  }

  function remTask($t){
    $query = mysqli_query($this->connection, "DELETE FROM mylist_tasks WHERE id='$t->id'");
    /*
    $tasklist = fopen("db/tasks.txt","w");
    foreach($this->tasks as $task){
      if($task != $t) {
        fwrite($tasklist,"\"$task->user\",\"$task->description\",\"$task->category\",\"$task->status\"\n");
      }
    }
    fclose($tasklist);*/
    $this->loadTasks();
  }

  function getUserId($user){
      $query = mysqli_query($this->connection,"SELECT id,login FROM mylist_users WHERE login='$user'");
      if(mysqli_num_rows($query) > 0){
        $userm = mysqli_fetch_array($query);
        return $userm["id"];
      }
      return 0;
  }

  function getCategoryId($category){
      $query = mysqli_query($this->connection,"SELECT id,category FROM mylist_categories WHERE category='$category'");
      if(mysqli_num_rows($query) > 0){
        $userm = mysqli_fetch_array($query);
        return $userm["id"];
      } else {
        $query = mysqli_query($this->connection,"INSERT INTO mylist_categories (id, category) VALUES (NULL, '$category')");
        return $this->getCategoryId($category);
      }
      return 0;
  }

  function addTask($user,$description,$category,$status){
    $uid = $this->getUserId($user);
    $cid = $this->getCategoryId($category);
    $query = mysqli_query($this->connection,"INSERT INTO mylist_tasks (id, user_id, category_id, description) VALUES (NULL, '$uid', '$cid', '$description')");
    //$tasklist = fopen("db/tasks.txt","a");
    //fwrite($tasklist,"\"$user\",\"$description\",\"$category\",\"$status\"\n");
    //fclose($tasklist);
    $this->loadTasks();
  }


  function getUser($login){
    foreach($this->users as $user){
      if($user->login == $login) return $user;
    }
    return NULL;
  }

  function login($login,$password){
    foreach($this->users as $user) {
      if($user->login == $login && $user->password == $password){
        $_SESSION["user"] = $user;
        return 1;
      }
    }
    return 0;
  }

  function loginG($name,$email,$login,$password){
    if($this->getUser($login) == null){
       return $this->register($name,$email,$login,$password);
    } else {
      foreach($this->users as $user) {
        if($user->login == $login){
          $_SESSION["user"] = $user;
          return "true";
        }
      }
    }
    return "true";
  }

  function checkEmail($email){
    foreach($this->users as $user) {
      if($user->email == $email) return new Error("Email já cadastrado!");
    }
    return 1;
  }

  function checkLogin($login){
    foreach($this->users as $user) {
      if($user->login == $login) return new Error("Login já cadastrado!");
    }
    return 1;
  }

  function isLogged(){
    return isset($_SESSION["user"]);
  }

  function logout(){
    session_destroy();
  }

  function register($name,$email,$login,$password){
    $query = mysqli_query($this->connection,"INSERT INTO mylist_users (id, name, email, login, password) VALUES (NULL, '$name', '$email', '$login', '$password')");
    /*$loginlist = fopen("db/login.txt","a");
    fwrite($loginlist,"\"$name\",\"$email\",\"$login\",\"$password\"\n");
    fclose($loginlist);*/
    $this->loadUsers();
    $_SESSION["user"] = $this->getUser($login);
    return "true";
  }
}

?>
