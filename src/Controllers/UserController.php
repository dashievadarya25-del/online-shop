<?php

class UserController
{
    public function getRegistrate()
    {
        session_start();
        if (!isset($_SESSION['userId'])) {
            header('location: /catalog');
        }
        require_once '../Views/registration_form.php';
    }


    public function registrate()
    {
        $errors = $this->regValidate($_POST);

// добавляем в БД, если нет ошибок
        if (empty($errors)) {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['psw'];
            $passwordrepeat = $_POST['psw-repeat'];

            $password = password_hash($password, PASSWORD_DEFAULT);

            require_once '../Model/User.php';
            $userModel = new User();

            $userModel->insetUsers($name, $email, $password);

            $result = $userModel->getByEmail($email);

            print_r($result);
        }
        require_once '../Views/registration_form.php';
    }

    private function regValidate(array $data): array
    {
        $errors = [];

        //объявление и валидация данных
        if (isset($data['name'])) {
            $name = $data['name'];
            if (strlen($name) < 3) {
                $errors['name'] = "Name must be at least 3 characters";
            }
        } else {
            $errors['name'] = "Name is required";
        }

        if (isset($data['email'])) {
            $email = $data['email'];

            if (strlen($email) < 2) {
                $errors['email'] = 'email не должен быть меньше 2 символов';
            } elseif (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
                $errors['email'] = 'email некорректный';
            } else {
                require_once '../Model/User.php';
                $userModel = new User();
                $user = $userModel->getByEmail($email);
                if ($user !== false) {
                    $errors['email'] = "этот email уже существует";
                }
            }
        } else {
            $errors['email'] = 'email должен быть заполнен';
        }

        if (isset($data['psw'])) {
            $password = $data ['psw'];

            if (strlen($password) < 4) {
                $errors['psw'] = 'Пароль не должен быть меньше 4';
            }

            $passwordrepeat = $data['psw-repeat'];
            if ($password !== $passwordrepeat) {
                $errors['psw-repeat'] = 'пароли не совпадают';
            }
        } else {
            $errors['psw'] = 'Пароль должен быть заполнен';
        }

        return $errors;
    }

    public function getLogin()
    {
        require_once '../Views/login_form.php';
    }

    public function login()
    {

        $errors = $this->logValidate($_POST);

        if (empty($errors)) {
            $username = $_POST["u"];
            $password = $_POST["p"];
            require_once '../Model/User.php';
            $userModel = new User();
            $user = $userModel->getUsernameByEmail($username);
            if (!empty($user)) {
                $passwordDb = $user['password'];

                if (password_verify($password, $passwordDb)) {
                    //вход через сессии
                    session_start();
                    $_SESSION['userId'] = $user['id'];
                    //вход через куки
                    // setcookie('user_id', $user['id']);
                    header("Location: /catalog");
                } else {
                    $errors['u'] = 'username or password incorrect';
                }
            } else {
                $errors['u'] = 'пользователя с таким логином не существует';
            }
        }

        require_once '../Views/login_form.php';
    }

    function logValidate(array $data): array
    {
        $errors = [];

        if (!isset($data['u'])) {
            $errors['u'] = 'Поле Username обязательно для заполнения';
        }
        if (!isset($data['p'])) {
            $errors['p'] = 'Поле Password обязательно для заполнения';
        }
        return $errors;
    }

    public function getProfile()
    {
        require_once '../Views/profile_page.php';
    }

    public function profile()
    {
        session_start();

        if (isset($_SESSION['userId'])) {
            require_once '../Model/User.php';
            $userModel = new User();
            $user = $userModel->getByUserId();

            require_once '../Views/profile_page.php';
        } else {
            header("Location: /login");
        }
    }


    public function getEditprofile()
    {
        session_start();

        if (isset($_SESSION['userId'])) {
            require_once '../Model/User.php';
            $userModel = new User();
            $user = $userModel->getByUserId();

            require_once '../Views/edit_profile_form.php';
        } else {
            header("Location: /login");
        }
    }

    public function editProfile()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['userId'])) {
            header("Location: /login");
            exit;
        }

        $errors = $this->editProfilevalidate($_POST);

        if (empty($errors)) {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $userId = $_SESSION['userId'];

            $password = password_hash($password, PASSWORD_DEFAULT);

            require_once '../Model/User.php';
            $userModel = new User();

            $user = $userModel->getById($userId);

            if ($user['name'] !== $name) {
               $userModel->updateNameById($name, $userId);
            }

            if ($user['email'] !== $email) {

                $userModel->updateEmailById($email, $userId);
            }
            header("Location: /profile");
            exit;
        }


        require_once '../Views/edit_profile_form.php';
    }

    private function editProfilevalidate(array $data): array
    {
        $errors = [];

        //объявление и валидация данных
        if (isset($data['name'])) {
            $name = $data['name'];
            if (strlen($name) < 3) {
                $errors['name'] = "Name must be at least 3 characters";
            }
        }

        if (isset($data['email'])) {
            $email = $data['email'];

            if (strlen($email) < 2) {
                $errors['email'] = 'email не должен быть меньше 2 символов';
            } elseif (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
                $errors['email'] = 'email некорректный';
            } else {
                require_once '../Model/User.php';
                $userModel = new User();
                $user = $userModel->getByEmail($email);

                $userId = $_SESSION['userId'];
                if ($user['id'] !== $userId) {
                    $errors['email'] = "этот email уже существует";
                }
            }
        }

        if (isset($data['password'])) {
            $password = $data ['password'];

            if (strlen($password) < 4) {
                $errors['password'] = 'Пароль не должен быть меньше 4';
            }
        }

        return $errors;
    }

}





