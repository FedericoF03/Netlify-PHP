<?php 

class Router {
    protected $route;

    public function __construct () {

        if( !isset($_SESSION) )  session_start(); 
         
        if( !isset($_SESSION['ok']) )  $_SESSION['ok'] = false;

        if( $_SESSION['ok'] ) {
            
            $this->route = isset($_GET['r']) ? $_GET['r'] : 'home';
            $controller = new ViewController();
            switch ($this->route) {
                case 'home':
                    $controller->load_view('home');
                    break;
                case 'movieseries':
                    if(!isset( $_POST['r'])) $controller->load_view('movieseries');
                    else if ( $_POST['r'] == 'movieserie-add') $controller->load_view('movieserie-add');
                    else if ( $_POST['r'] == 'movieserie-edit') $controller->load_view('movieserie-edit');
                    else if ( $_POST['r'] == 'movieserie-delete') $controller->load_view('movieserie-delete');
                    else if ( $_POST['r'] == 'movieserie-show') $controller->load_view('movieserie-show');
                    break;
                case 'users':
                    if(!isset( $_POST['r'])) $controller->load_view('users');
                    else if ( $_POST['r'] == 'user-add') $controller->load_view('user-add');
                    else if ( $_POST['r'] == 'user-edit') $controller->load_view('user-edit');
                    else if ( $_POST['r'] == 'user-delete') $controller->load_view('user-delete');
                    break;
                case 'status':
                    if(!isset( $_POST['r'])) $controller->load_view('status');
                    else if ( $_POST['r'] == 'status-add') $controller->load_view('status-add');
                    else if ( $_POST['r'] == 'status-edit') $controller->load_view('status-edit');
                    else if ( $_POST['r'] == 'status-delete') $controller->load_view('status-delete');
                    break;
                case 'salir':
                    $_SESSION['ok'] = false;
                    session_start();
                    session_destroy();
                    header('Location: ./');
                    break;
                default:
                    $controller->load_view('error404');
                    break;
            }
           
           
            

        } else {
            if(!isset($_POST['user']) && !isset($_POST['pass'])) {
               
                $controller = new ViewController();
                $controller->load_view('login');

            } else {
                $user_session = new SessionController();
                $session = $user_session->login($_POST['user'], $_POST['pass'] );
                if(empty($session)) {

                    $controller = new ViewController();
                    $controller->load_view('login');
                    header('Location: ./?error=El usuario ' . $_POST['user'] . ' y el password proporcionado no coinciden');
                } else {
                    $_SESSION['ok'] = true;
                   
                    foreach ($session as $row) {
                        $_SESSION['user_u'] = $row['user_u'];
                        $_SESSION['email'] = $row['email'];
                        $_SESSION['name_u'] = $row['name_u'];
                        $_SESSION['birthday'] = $row['birthday'];
                        $_SESSION['pass'] = $row['pass'];
                        $_SESSION['role_u'] = $row['role_u'];
                    }
                    
                    header('Location: ./');
                }
                
            }
                  
        }
    }

    public function __destruct() {

    }
}

?>