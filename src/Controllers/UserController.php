<?php
namespace Controllers;
use Model\User;

class UserController extends BaseController
{
    private User $userModel;
    public function __construct()
    {
        parent::__construct();
        $this->userModel = new User();
    }

    public function getRegistrate()
    {
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

            //require_once '../Model/User.php';

            $this->userModel->insertUsers($name, $email, $password);

            $result = $this->userModel->getByEmail($email);

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
                //require_once '../Model/User.php';

                $user = $this->userModel->getByEmail($email);
                if ($user === false) {
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
        $data = $_POST;
        $errors = $this->logValidate($data);

        if (empty($errors)) {
            $result = $this->authService->auth($_POST['email'], $_POST['password']);

            if ($result === true) {
                header("Location: /catalog");
                exit();
            } else {
                $errors['autorization'] = 'email или пароль неверный';
            }
        }

        require_once '../Views/login_form.php';
    }

    function logValidate(array $data): array
    {
        $errors = [];

        if (!isset($data['email'])) {
            $errors['email'] = 'Поле Email обязательно для заполнения';
        }
        if (!isset($data['password'])) {
            $errors['password'] = 'Поле Password обязательно для заполнения';
        }
        return $errors;
    }

    public function getProfile()
    {
        require_once '../Views/profile_page.php';
    }

    public function profile()
    {
        if ($user = $this->authService->getCurrentUser()) {

            require_once '../Views/profile_page.php';
        } else {
            header("Location: /login");
        }
    }
    public function logout()
    {
        parent::logout();
        header("Location: /login");
        exit();
    }

    public function getEditprofile()
    {
        $user = $this->authService->getCurrentUser();

        require_once '../Views/edit_profile_form.php';
    }

    public function editProfile()
    {

        if (!$this->authService->check()) {
            header("Location: /login");
            exit;
        }

        $errors = $this->editProfilevalidate($_POST);

        if (empty($errors)) {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];



            $password = password_hash($password, PASSWORD_DEFAULT);
            //            $user = $this->userModel->getById($userId);
            $user = $this->authService->getCurrentUser();

            if ($user->getName() !== $name) {
               $this->userModel->updateNameById($name, $user->getId());
            }

            if ($user->getName() !== $email) {

                $this->userModel->updateEmailById($email, $user->getId());
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

                $user = $this->userModel->getByEmail($email);

                $userId = $_SESSION['userId'];
                if ($user->getId() !== $userId) {
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





