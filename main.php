<?php
    require_once("./config/config.php");
    require_once("./models/get.php");
    require_once("./models/post.php");
    require_once("./models/auth.php");

    $mysql = new mysqli(SERVER,USER,PW,DBASE);

    $db = new Connection();
    $pdo = $db->connect();

    $get = new Get($pdo);
    // $post = new Post($pdo);
    $auth = new Auth($pdo);

    $req = [];
    if(isset($_REQUEST['request'])) {
        $req = explode('/', rtrim($_REQUEST['request'], '/'));
    } else {
        $req = array("errorcatcher");
    }

    switch($_SERVER['REQUEST_METHOD']) {
        case 'POST':
            switch ($req[0]) {
                case 'register':
                    $d = json_decode(file_get_contents("php://input")); 
                    // print_r($d);
                    echo json_encode($auth->register($d));
                break;

                case 'login':
                    $d = json_decode(file_get_contents("php://input")); 
                    echo json_encode($auth->login($d));
                break;

                case 'get_dish':
                    $d = json_decode(file_get_contents("php://input")); 
                    echo json_encode($get->get_dish($d));
                break;


                # End POST Operations

                default:
                    echo "no endpoint";
                break;
            }
        break;

        default:
            echo "prohibited";
        break;
    }

?>