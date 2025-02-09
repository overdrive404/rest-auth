<?php
require_once 'User.php';
class Api {
    private $user;

    public function __construct() {
        $this->user = new User();
    }

    public function processRequest() {
        header("Content-Type: application/json");
        $method = $_SERVER['REQUEST_METHOD'];
        $request = explode('/', trim($_GET['q'] ?? '', '/'));
        switch ($method) {
            case 'POST':
                if ($request[0] === 'register') {
                    $this->registerUser();
                } elseif ($request[0] === 'login') {
                    $this->loginUser();
                }
                break;
            case 'GET':
                if ($request[0] === 'user' && isset($request[1])) {
                    $this->getUser($request[1]);
                }
                break;
            case 'PUT':
                if ($request[0] === 'user' && isset($request[1])) {
                    $this->updateUser($request[1]);
                }
                break;
            case 'DELETE':
                if ($request[0] === 'user' && isset($request[1])) {
                    $this->deleteUser($request[1]);
                }
                break;
            default:
                http_response_code(405);
                echo json_encode(["message" => "Метод не разрешен"]);
        }
    }

    private function registerUser() {
        if (!isset($_POST['username']) || !isset($_POST['password'])) {
            echo json_encode(["message" => "Заполните все поля"]);
            return;
        }

        if ($this->user->createUser($_POST['username'], $_POST['password'])) {
            echo json_encode(["message" => "Пользователь зарегистрирован"]);
        } else {
            echo json_encode(["message" => "Ошибка регистрации"]);
        }
    }

    private function loginUser() {
        echo json_encode($this->user->loginUser($_POST['username'], $_POST['password']));
    }

    private function getUser($id) {
        $user = $this->user->getUser($id);
        if ($user) {
            echo json_encode($user);
        } else {
            http_response_code(404);
            echo json_encode(["message" => "Пользователь не найден"]);
        }
    }

    private function updateUser($id) {
        $data = json_decode(file_get_contents("php://input"), true);
        print_r($data);
        if (!isset($data['username'])) {
            echo json_encode(["message" => "Необходимо указать имя пользователя"]);
            return;
        }

        if ($this->user->updateUser($id, $data['username'])) {
            echo json_encode(["message" => "Данные обновлены"]);
        } else {
            echo json_encode(["message" => "Ошибка обновления"]);
        }
    }

    private function deleteUser($id) {
        if ($this->user->deleteUser($id)) {
            echo json_encode(["message" => "Пользователь удален"]);
        } else {
            echo json_encode(["message" => "Ошибка удаления"]);
        }
    }
}


